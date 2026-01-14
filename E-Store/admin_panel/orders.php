<?php
require_once 'config.php';
requireLogin();

$pdo = getDatabase();

// Processar ações
if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'update_status':
                $id = (int)$_POST['id'];
                $status = $_POST['status'];
                $stmt = $pdo->prepare("UPDATE orders SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
                $stmt->execute([$status, $id]);
                $message = "Status do pedido atualizado com sucesso!";
                break;
                
            case 'delete':
                $id = (int)$_POST['id'];
                // Deletar itens do pedido primeiro
                $stmt = $pdo->prepare("DELETE FROM order_items WHERE order_id = ?");
                $stmt->execute([$id]);
                // Deletar pedido
                $stmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
                $stmt->execute([$id]);
                $message = "Pedido excluído com sucesso!";
                break;
        }
    }
}

// Filtros
$status = $_GET['status'] ?? '';
$search = $_GET['search'] ?? '';

// Construir query
$where = [];
$params = [];

if ($status) {
    $where[] = "o.status = ?";
    $params[] = $status;
}

if ($search) {
    $where[] = "(o.customer_name LIKE ? OR o.customer_email LIKE ? OR o.id = ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = $search;
}

$whereClause = $where ? "WHERE " . implode(" AND ", $where) : "";

// Buscar pedidos com contagem de itens
$stmt = $pdo->prepare("
    SELECT o.*, o.order_number, COUNT(oi.id) as item_count 
    FROM orders o 
    LEFT JOIN order_items oi ON o.id = oi.order_id 
    $whereClause 
    GROUP BY o.id 
    ORDER BY o.created_at DESC
");
$stmt->execute($params);
$orders = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - Painel Administrativo</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }
        
        .header {
            background: linear-gradient(135deg,rgb(68, 87, 174) 0%, #3b4f79 100%);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed; /* Fixa o cabeçalho */
            width: 100%; /* Ocupa toda a largura */
            top: 0; /* Alinha ao topo */
            left: 0; /* Alinha à esquerda */
            z-index: 1000; /* Garante que fique acima de outros elementos */
        }
        
        .header h1 {
            font-size: 1.5rem;
        }
        
        .header .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .sidebar {
            position: fixed;
            left: 0;
            top: 68px; /* Ajustado para ficar abaixo do header */
            width: 250px;
            height: calc(100vh - 68px); /* Ajustado para preencher o restante da altura */
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
            z-index: 999; /* Garante que fique abaixo do header, mas acima do conteúdo */
            overflow-y: auto; /* Adiciona scroll se o conteúdo da sidebar for muito longo */
        }
        
        .sidebar ul {
            list-style: none;
        }
        
        .sidebar li {
            margin: 0.5rem 0;
        }
        
        .sidebar a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        
        .sidebar a:hover, .sidebar a.active {
            background-color: #f0f0f0;
            color: #667eea;
        }
        
        .sidebar i {
            margin-right: 0.75rem;
            width: 20px;
        }
        
        .main-content {
            margin-left: 250px; /* Espaço para a sidebar */
            padding: 2rem;
            margin-top: 68px; /* Espaço para o header fixo */
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .page-header h2 {
            color: #333;
            font-size: 1.8rem;
        }
        
        .filters {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .filters-row {
            display: flex;
            gap: 1rem;
            align-items: end;
        }
        
        .form-group {
            flex: 1;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 500;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e1e5e9;
            border-radius: 5px;
            font-size: 1rem;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 0.9rem;
            transition: background-color 0.3s;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
        }
        
        .btn-primary:hover {
            background: #5a6fd8;
        }
        
        .btn-success {
            background: #28a745;
            color: white;
        }
        
        .btn-success:hover {
            background: #218838;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .btn-logout {
            background: #dc3545;
            color: white;
        }
        
        .btn-logout:hover {
            background: #c82333;
        }
        
        .btn-sm {
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            background: #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-header h3 {
            color: #333;
            font-size: 1.1rem;
        }
        
        .card-body {
            padding: 0;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th,
        .table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        
        .table tr:hover {
            background: #f8f9fa;
        }
        
        .badge {
            padding: 0.25rem 0.5rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .badge.pending { background: #fff3e0; color: #ef6c00; }
        .badge.processing { background: #e3f2fd; color: #1976d2; }
        .badge.shipped { background: #f3e5f5; color: #7b1fa2; }
        .badge.completed { background: #e8f5e8; color: #2e7d32; }
        .badge.cancelled { background: #ffebee; color: #c62828; }
        
        .actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
        
        .status-select {
            padding: 0.25rem;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 0.8rem;
        }
        
        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 2rem;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
        }
        
        .modal h3 {
            margin-bottom: 1rem;
            color: #333;
        }
        
        .modal-buttons {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 1.5rem;
        }
        
        .order-details {
            margin: 1rem 0;
        }
        
        .order-details table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        
        .order-details th,
        .order-details td {
            padding: 0.5rem;
            border: 1px solid #ddd;
            text-align: left;
        }
        
        .order-details th {
            background: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-shopping-cart"></i> Gerenciar Pedidos</h1>
        <div class="user-info">
            <span>Bem-vindo, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            <a href="logout.php" class="btn btn-logout">
                <i class="fas fa-sign-out-alt"></i> Sair
            </a>
        </div>
    </div>
    
    <div class="sidebar">
        <ul>
            <li><a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="products.php"><i class="fas fa-box"></i> Produtos</a></li>
            <li><a href="orders.php" class="active"><i class="fas fa-shopping-cart"></i> Pedidos</a></li>
            <li><a href="add_product.php"><i class="fas fa-plus"></i> Adicionar Produto</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <?php if (isset($message)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <div class="page-header">
            <h2>Pedidos</h2>
            <a href="add_order.php" class="btn btn-success">
                <i class="fas fa-plus"></i> Novo Pedido
            </a>
        </div>
        
        <div class="filters">
            <form method="GET">
                <div class="filters-row">
                    <div class="form-group">
                        <label for="search">Buscar:</label>
                        <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="ID, nome ou email do cliente">
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status">
                            <option value="">Todos os status</option>
                            <option value="pending" <?php echo $status === 'pending' ? 'selected' : ''; ?>>Pendente</option>
                            <option value="processing" <?php echo $status === 'processing' ? 'selected' : ''; ?>>Processando</option>
                            <option value="shipped" <?php echo $status === 'shipped' ? 'selected' : ''; ?>>Enviado</option>
                            <option value="completed" <?php echo $status === 'completed' ? 'selected' : ''; ?>>Concluído</option>
                            <option value="cancelled" <?php echo $status === 'cancelled' ? 'selected' : ''; ?>>Cancelado</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3>Lista de Pedidos (<?php echo count($orders); ?>)</h3>
            </div>
            <div class="card-body">
                <?php if (empty($orders)): ?>
                    <div style="padding: 2rem; text-align: center; color: #666;">
                        <i class="fas fa-shopping-cart" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                        <p>Nenhum pedido encontrado.</p>
                    </div>
                <?php else: ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Número do Pedido</th>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Total</th>
                                <th>Itens</th>
                                <th>Status</th>
                                <th>Data</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order["order_number"]); ?></td>
                                <td><strong>#<?php echo $order["id"]; ?></strong></td>
                                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['customer_email']); ?></td>
                                <td><?php echo htmlspecialchars($order['customer_phone'] ?: '-'); ?></td>
                                <td><?php echo formatPrice($order['total_amount']); ?></td>
                                <td><?php echo $order['item_count']; ?> item(s)</td>
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
                                        <select name="status" class="status-select" onchange="this.form.submit()">
                                            <option value="pending" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>Pendente</option>
                                            <option value="processing" <?php echo $order['status'] === 'processing' ? 'selected' : ''; ?>>Processando</option>
                                            <option value="shipped" <?php echo $order['status'] === 'shipped' ? 'selected' : ''; ?>>Enviado</option>
                                            <option value="completed" <?php echo $order['status'] === 'completed' ? 'selected' : ''; ?>>Concluído</option>
                                            <option value="cancelled" <?php echo $order['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelado</option>
                                        </select>
                                    </form>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                <td>
                                    <div class="actions">
                                        <button onclick="viewOrder(<?php echo $order['id']; ?>)" class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="confirmDelete(<?php echo $order['id']; ?>)" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Modal de visualização do pedido -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <h3>Detalhes do Pedido</h3>
            <div id="orderDetails" class="order-details">
                <!-- Conteúdo será carregado via JavaScript -->
            </div>
            <div class="modal-buttons">
                <button onclick="closeModal('viewModal')" class="btn btn-primary">Fechar</button>
            </div>
        </div>
    </div>
    
    <!-- Modal de confirmação de exclusão -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h3>Confirmar Exclusão</h3>
            <p>Tem certeza que deseja excluir este pedido? Esta ação não pode ser desfeita.</p>
            <div class="modal-buttons">
                <button onclick="closeModal('deleteModal')" class="btn btn-primary">Cancelar</button>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" id="deleteId">
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function viewOrder(id) {
            // Fazer requisição AJAX para buscar detalhes do pedido
            fetch(`order_details.php?id=${id}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('orderDetails').innerHTML = data;
                    document.getElementById('viewModal').style.display = 'block';
                })
                .catch(error => {
                    alert('Erro ao carregar detalhes do pedido');
                });
        }
        
        function confirmDelete(id) {
            document.getElementById('deleteId').value = id;
            document.getElementById('deleteModal').style.display = 'block';
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        
        // Fechar modal ao clicar fora dele
        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
