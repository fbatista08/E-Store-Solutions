<?php
require_once 'config.php';
requireLogin();

if (!isAdmin()) {
    header("Location: ../index.php");
    exit;
}

$pdo = getDatabase();

// Estatísticas do dashboard
$totalProducts = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalOrders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$pendingOrders = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'")->fetchColumn();
$totalRevenue = $pdo->query("SELECT SUM(total_amount) FROM orders WHERE status = 'completed'")->fetchColumn() ?: 0;

// Produtos com baixo estoque
$lowStockProducts = $pdo->query("SELECT * FROM products WHERE stock <= 10 ORDER BY stock ASC LIMIT 5")->fetchAll();

// Pedidos recentes
$recentOrders = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Painel Administrativo</title>
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
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }
        
        .stat-icon.products { background: #4CAF50; }
        .stat-icon.orders { background: #2196F3; }
        .stat-icon.pending { background: #FF9800; }
        .stat-icon.revenue { background: #9C27B0; }
        
        .stat-info h3 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 0.25rem;
        }
        
        .stat-info p {
            color: #666;
            font-size: 0.9rem;
        }
        
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
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
        }
        
        .card-header h3 {
            color: #333;
            font-size: 1.1rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th,
        .table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        
        .badge {
            padding: 0.25rem 0.5rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .badge.low { background: #ffebee; color: #c62828; }
        .badge.pending { background: #fff3e0; color: #ef6c00; }
        .badge.completed { background: #e8f5e8; color: #2e7d32; }
        
        .btn {
            padding: 0.5rem 1rem;
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
        
        .btn-logout {
            background: #dc3545;
            color: white;
        }
        
        .btn-logout:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-tachometer-alt"></i> Painel Administrativo</h1>
        <div class="user-info">
            <span>Bem-vindo, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            <a href="logout.php" class="btn btn-logout">
                <i class="fas fa-sign-out-alt"></i> Sair
            </a>
        </div>
    </div>
    
    <div class="sidebar">
        <ul>
            <li><a href="index.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="products.php"><i class="fas fa-box"></i> Produtos</a></li>
            <li><a href="orders.php"><i class="fas fa-shopping-cart"></i> Pedidos</a></li>
            <li><a href="add_product.php"><i class="fas fa-plus"></i> Adicionar Produto</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon products">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $totalProducts; ?></h3>
                    <p>Total de Produtos</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon orders">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $totalOrders; ?></h3>
                    <p>Total de Pedidos</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon pending">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $pendingOrders; ?></h3>
                    <p>Pedidos Pendentes</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon revenue">
                    <i class="fas fa-dollar-sign"></i>
                </div> 
                <div class="stat-info">
                    <h3><?php echo formatPrice($totalRevenue); ?></h3>
                    <p>Receita Total</p>
                </div>
            </div>
        </div>
        
        <div class="content-grid">
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-exclamation-triangle"></i> Produtos com Baixo Estoque</h3>
                </div>
                <div class="card-body">
                    <?php if (empty($lowStockProducts)): ?>
                        <p>Nenhum produto com baixo estoque.</p>
                    <?php else: ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Estoque</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lowStockProducts as $product): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td><?php echo $product['stock']; ?></td>
                                    <td>
                                        <span class="badge low">Baixo Estoque</span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-clock"></i> Pedidos Recentes</h3>
                </div>
                <div class="card-body">
                    <?php if (empty($recentOrders)): ?>
                        <p>Nenhum pedido encontrado.</p>
                    <?php else: ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentOrders as $order): ?>
                                <tr>
                                    <td>#<?php echo $order['id']; ?></td>
                                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                    <td><?php echo formatPrice($order['total_amount']); ?></td>
                                    <td>
                                        <span class="badge <?php echo $order['status']; ?>">
                                            <?php echo ucfirst($order['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
