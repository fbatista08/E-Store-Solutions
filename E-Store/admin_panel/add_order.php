<?php
require_once 'config.php';
requireLogin();

$pdo = getDatabase();
$message = '';
$error = '';

if ($_POST) {
    $customerName = trim($_POST['customer_name'] ?? '');
    $customerEmail = trim($_POST['customer_email'] ?? '');
    $customerPhone = trim($_POST['customer_phone'] ?? '');
    $products = $_POST['products'] ?? [];
    $quantities = $_POST['quantities'] ?? [];
    
    // Validações
    if (empty($customerName)) {
        $error = 'Nome do cliente é obrigatório.';
    } elseif (empty($customerEmail) || !filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email válido é obrigatório.';
    } elseif (empty($products)) {
        $error = 'Selecione pelo menos um produto.';
    } else {
        try {
            $pdo->beginTransaction();
            
            // Calcular total
            $totalAmount = 0;
            $validItems = [];
            
            foreach ($products as $index => $productId) {
                $quantity = (int)($quantities[$index] ?? 0);
                if ($quantity > 0) {
                    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
                    $stmt->execute([$productId]);
                    $product = $stmt->fetch();
                    
                    if ($product) {
                        $validItems[] = [
                            'product_id' => $productId,
                            'quantity' => $quantity,
                            'price' => $product['price']
                        ];
                        $totalAmount += $product['price'] * $quantity;
                    }
                }
            }
            
            if (empty($validItems)) {
                throw new Exception('Nenhum item válido encontrado.');
            }
            
            // Inserir pedido
            $stmt = $pdo->prepare("
                INSERT INTO orders (customer_name, customer_email, customer_phone, total_amount, status) 
                VALUES (?, ?, ?, ?, 'pending')
            ");
            
            $stmt->execute([
                $customerName,
                $customerEmail,
                $customerPhone,
                $totalAmount
            ]);
            
            $orderId = $pdo->lastInsertId();
            
            // Inserir itens do pedido
            $stmt = $pdo->prepare("
                INSERT INTO order_items (order_id, product_id, quantity, price) 
                VALUES (?, ?, ?, ?)
            ");
            
            foreach ($validItems as $item) {
                $stmt->execute([
                    $orderId,
                    $item['product_id'],
                    $item['quantity'],
                    $item['price']
                ]);
            }
            
            $pdo->commit();
            $message = "Pedido #$orderId criado com sucesso!";
            
            // Limpar campos
            $customerName = $customerEmail = $customerPhone = '';
            
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = 'Erro ao criar pedido: ' . $e->getMessage();
        }
    }
}

// Buscar produtos disponíveis
$products = $pdo->query("SELECT * FROM products WHERE stock > 0 ORDER BY name")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Pedido - Painel Administrativo</title>
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
            top: 70px;
            width: 250px;
            height: calc(100vh - 70px);
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
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
            margin-left: 250px;
            padding: 2rem;
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
        
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 1000px;
        }
        
        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            background: #f8f9fa;
        }
        
        .card-header h3 {
            color: #333;
            font-size: 1.1rem;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .form-row.full {
            grid-template-columns: 1fr;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
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
            transition: border-color 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 1rem;
            transition: background-color 0.3s;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
        }
        
        .btn-primary:hover {
            background: #5a6fd8;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .btn-success {
            background: #28a745;
            color: white;
        }
        
        .btn-success:hover {
            background: #218838;
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
        
        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1.5rem;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .required {
            color: #dc3545;
        }
        
        .products-section {
            border: 2px solid #e1e5e9;
            border-radius: 5px;
            padding: 1.5rem;
            margin: 1.5rem 0;
        }
        
        .products-section h4 {
            margin-bottom: 1rem;
            color: #333;
        }
        
        .product-item {
            display: grid;
            grid-template-columns: 2fr 1fr 100px;
            gap: 1rem;
            align-items: end;
            margin-bottom: 1rem;
            padding: 1rem;
            border: 1px solid #eee;
            border-radius: 5px;
            background: #f8f9fa;
        }
        
        .product-info {
            display: flex;
            flex-direction: column;
        }
        
        .product-info strong {
            color: #333;
        }
        
        .product-info small {
            color: #666;
            margin-top: 0.25rem;
        }
        
        .quantity-input {
            width: 80px;
        }
        
        .total-section {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 5px;
            margin-top: 1.5rem;
            text-align: right;
        }
        
        .total-section h4 {
            color: #333;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-plus"></i> Novo Pedido</h1>
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
            <li><a href="orders.php"><i class="fas fa-shopping-cart"></i> Pedidos</a></li>
            <li><a href="add_product.php"><i class="fas fa-plus"></i> Adicionar Produto</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="page-header">
            <h2>Criar Novo Pedido</h2>
            <a href="orders.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar para Pedidos
            </a>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3>Informações do Pedido</h3>
            </div>
            <div class="card-body">
                <?php if ($message): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" id="orderForm">
                    <h4>Dados do Cliente</h4>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="customer_name">Nome do Cliente <span class="required">*</span></label>
                            <input type="text" id="customer_name" name="customer_name" value="<?php echo htmlspecialchars($customerName ?? ''); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="customer_email">Email <span class="required">*</span></label>
                            <input type="email" id="customer_email" name="customer_email" value="<?php echo htmlspecialchars($customerEmail ?? ''); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="customer_phone">Telefone</label>
                            <input type="tel" id="customer_phone" name="customer_phone" value="<?php echo htmlspecialchars($customerPhone ?? ''); ?>">
                        </div>
                    </div>
                    
                    <div class="products-section">
                        <h4>Produtos</h4>
                        <div id="productsContainer">
                            <?php if (!empty($products)): ?>
                                <?php foreach ($products as $product): ?>
                                <div class="product-item">
                                    <div class="product-info">
                                        <strong><?php echo htmlspecialchars($product['name']); ?></strong>
                                        <small><?php echo formatPrice($product['price']); ?> - Estoque: <?php echo $product['stock']; ?></small>
                                    </div>
                                    <div class="form-group">
                                        <label>Quantidade</label>
                                        <input type="number" name="quantities[]" min="0" max="<?php echo $product['stock']; ?>" value="0" class="quantity-input" onchange="calculateTotal()">
                                        <input type="hidden" name="products[]" value="<?php echo $product['id']; ?>">
                                        <input type="hidden" class="product-price" value="<?php echo $product['price']; ?>">
                                    </div>
                                    <div>
                                        <span class="item-total">R$ 0,00</span>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Nenhum produto disponível em estoque.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="total-section">
                        <h4>Total do Pedido: <span id="orderTotal">R$ 0,00</span></h4>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Criar Pedido
                        </button>
                        <a href="orders.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function calculateTotal() {
            let total = 0;
            const productItems = document.querySelectorAll('.product-item');
            
            productItems.forEach(item => {
                const quantityInput = item.querySelector('input[name="quantities[]"]');
                const priceInput = item.querySelector('.product-price');
                const itemTotalSpan = item.querySelector('.item-total');
                
                const quantity = parseInt(quantityInput.value) || 0;
                const price = parseInt(priceInput.value) || 0;
                const itemTotal = quantity * price;
                
                // Atualizar total do item
                itemTotalSpan.textContent = formatPrice(itemTotal);
                
                // Adicionar ao total geral
                total += itemTotal;
            });
            
            // Atualizar total do pedido
            document.getElementById('orderTotal').textContent = formatPrice(total);
        }
        
        function formatPrice(cents) {
            return 'R$ ' + (cents / 100).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
        
        // Calcular total inicial
        calculateTotal();
    </script>
</body>
</html>
