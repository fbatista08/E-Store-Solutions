<?php
require_once 'config.php';
requireLogin();

$pdo = getDatabase();
$orderId = (int)($_GET['id'] ?? 0);

if (!$orderId) {
    echo '<p>Pedido não encontrado.</p>';
    exit;
}

// Buscar dados do pedido
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$orderId]);
$order = $stmt->fetch();

if (!$order) {
    echo '<p>Pedido não encontrado.</p>';
    exit;
}

// Buscar itens do pedido com informações completas do produto
$stmt = $pdo->prepare("
    SELECT oi.*, 
           COALESCE(oi.product_name, p.name) as product_name,
           COALESCE(oi.product_image, p.image) as product_image,
           p.description as product_description,
           p.category as product_category
    FROM order_items oi 
    LEFT JOIN products p ON oi.product_id = p.id 
    WHERE oi.order_id = ?
    ORDER BY oi.id
");
$stmt->execute([$orderId]);
$items = $stmt->fetchAll();

$statusLabels = [
    'pending' => 'Pendente',
    'processing' => 'Processando',
    'shipped' => 'Enviado',
    'completed' => 'Concluído',
    'cancelled' => 'Cancelado'
];
?>

<div>
    <p><strong>Número do Pedido:</strong> <?php echo htmlspecialchars($order["order_number"]); ?></p>
    <p><strong>ID do Pedido:</strong> #<?php echo $order["id"]; ?></p>
    <p><strong>Cliente:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($order['customer_email']); ?></p>
    <p><strong>Telefone:</strong> <?php echo htmlspecialchars($order['customer_phone'] ?: 'Não informado'); ?></p>
    <p><strong>Status:</strong> <span class="badge <?php echo $order['status']; ?>"><?php echo $statusLabels[$order['status']] ?? $order['status']; ?></span></p>
    <p><strong>Total:</strong> <?php echo formatPrice($order['total_amount']); ?></p>
    <p><strong>Data do Pedido:</strong> <?php echo date('d/m/Y H:i:s', strtotime($order['created_at'])); ?></p>
    <p><strong>Última Atualização:</strong> <?php echo date('d/m/Y H:i:s', strtotime($order['updated_at'])); ?></p>
</div>

<?php if (!empty($items)): ?>
<h4 style="margin-top: 1.5rem; margin-bottom: 1rem;">Itens do Pedido</h4>
<table>
    <thead>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Preço Unitário</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): ?>
        <tr>
            <td>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <?php if ($item['product_image']): ?>
                        <img src="<?php echo htmlspecialchars($item['product_image']); ?>" 
                             alt="<?php echo htmlspecialchars($item['product_name']); ?>" 
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd;">
                    <?php endif; ?>
                    <div>
                        <strong><?php echo htmlspecialchars($item['product_name'] ?: 'Produto não encontrado'); ?></strong>
                        <?php if ($item['product_id']): ?>
                            <br><small style="color: #666;">ID: <?php echo $item['product_id']; ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            </td>
            <td><strong><?php echo $item['quantity']; ?></strong></td>
            <td><strong><?php echo formatPrice($item['price']); ?></strong></td>
            <td><strong style="color: #28a745;"><?php echo formatPrice($item['price'] * $item['quantity']); ?></strong></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr style="background-color: #f8f9fa; font-weight: bold;">
            <td colspan="3" style="text-align: right; padding: 15px;">
                <strong>TOTAL DO PEDIDO:</strong>
            </td>
            <td style="color: #28a745; font-size: 1.1em;">
                <strong><?php echo formatPrice($order['total_amount']); ?></strong>
            </td>
        </tr>
    </tfoot>
</table>
<?php else: ?>
<p style="margin-top: 1rem; color: #666;">Nenhum item encontrado para este pedido.</p>
<?php endif; ?>
