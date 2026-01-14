<?php
require_once 'config.php';
requireLogin();

$pdo = getDatabase();

// Processar ações
if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'delete':
                $id = (int)$_POST['id'];
                $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
                $stmt->execute([$id]);
                $message = "Produto excluído com sucesso!";
                break;
                
            case 'update_stock':
                $id = (int)$_POST['id'];
                $stock = (int)$_POST['stock'];
                $stmt = $pdo->prepare("UPDATE products SET stock = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
                $stmt->execute([$stock, $id]);
                $message = "Estoque atualizado com sucesso!";
                break;
        }
    }
}

// Filtros
$category = $_GET['category'] ?? '';
$search = $_GET['search'] ?? '';

// Construir query
$where = [];
$params = [];

if ($category) {
    $where[] = "category = ?";
    $params[] = $category;
}

if ($search) {
    $where[] = "(name LIKE ? OR description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$whereClause = $where ? "WHERE " . implode(" AND ", $where) : "";

// Buscar produtos
$stmt = $pdo->prepare("SELECT * FROM products $whereClause ORDER BY name");
$stmt->execute($params);
$products = $stmt->fetchAll();

// Buscar categorias para o filtro
$categories = $pdo->query("SELECT DISTINCT category FROM products ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Painel Administrativo</title>
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
            justify-content: between;
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
        
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .badge {
            padding: 0.25rem 0.5rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .badge.low { background: #ffebee; color: #c62828; }
        .badge.medium { background: #fff3e0; color: #ef6c00; }
        .badge.high { background: #e8f5e8; color: #2e7d32; }
        
        .actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .stock-input {
            width: 80px;
            padding: 0.25rem;
            border: 1px solid #ddd;
            border-radius: 3px;
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
            margin: 15% auto;
            padding: 2rem;
            border-radius: 10px;
            width: 400px;
            text-align: center;
        }
        
        .modal h3 {
            margin-bottom: 1rem;
            color: #333;
        }
        
        .modal-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-box"></i> Gerenciar Produtos</h1>
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
            <li><a href="products.php" class="active"><i class="fas fa-box"></i> Produtos</a></li>
            <li><a href="orders.php"><i class="fas fa-shopping-cart"></i> Pedidos</a></li>
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
            <h2>Produtos</h2>
        </div>
        
        <div class="filters">
            <form method="GET">
                <div class="filters-row">
                    <div class="form-group">
                        <label for="search">Buscar:</label>
                        <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Nome ou descrição do produto">
                    </div>
                    
                    <div class="form-group">
                        <label for="category">Categoria:</label>
                        <select id="category" name="category">
                            <option value="">Todas as categorias</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo $category === $cat ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat); ?>
                                </option>
                            <?php endforeach; ?>
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
                <h3>Lista de Produtos (<?php echo count($products); ?>)</h3>
                <a href="add_product.php" class="btn btn-success">
                    <i class="fas fa-plus"></i> Adicionar Produto
                </a>
            </div>
            <div class="card-body">
                <?php if (empty($products)): ?>
                    <div style="padding: 2rem; text-align: center; color: #666;">
                        <i class="fas fa-box" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                        <p>Nenhum produto encontrado.</p>
                    </div>
                <?php else: ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Imagem</th>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo $product['id']; ?></td>
                                <td>
                                    <?php if ($product['image']): ?>
                                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Produto" class="product-image">
                                    <?php else: ?>
                                        <div style="width: 50px; height: 50px; background: #eee; border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-image" style="color: #999;"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($product['name']); ?></strong>
                                    <br>
                                    <small style="color: #666;"><?php echo htmlspecialchars(substr($product['description'], 0, 50)) . '...'; ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($product['category']); ?></td>
                                <td><?php echo formatPrice($product['price']); ?></td>
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="update_stock">
                                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                        <input type="number" name="stock" value="<?php echo $product['stock']; ?>" class="stock-input" min="0">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <?php
                                    $stockClass = 'high';
                                    $stockText = 'Em Estoque';
                                    if ($product['stock'] <= 5) {
                                        $stockClass = 'low';
                                        $stockText = 'Baixo Estoque';
                                    } elseif ($product['stock'] <= 15) {
                                        $stockClass = 'medium';
                                        $stockText = 'Estoque Médio';
                                    }
                                    ?>
                                    <span class="badge <?php echo $stockClass; ?>"><?php echo $stockText; ?></span>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="confirmDelete(<?php echo $product['id']; ?>, '<?php echo htmlspecialchars($product['name']); ?>')" class="btn btn-danger btn-sm">
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
    
    <!-- Modal de confirmação de exclusão -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h3>Confirmar Exclusão</h3>
            <p>Tem certeza que deseja excluir o produto "<span id="productName"></span>"?</p>
            <div class="modal-buttons">
                <button onclick="closeModal()" class="btn btn-primary">Cancelar</button>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" id="deleteId">
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function confirmDelete(id, name) {
            document.getElementById('deleteId').value = id;
            document.getElementById('productName').textContent = name;
            document.getElementById('deleteModal').style.display = 'block';
        }
        
        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }
        
        // Fechar modal ao clicar fora dele
        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
