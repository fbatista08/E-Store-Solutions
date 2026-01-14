<?php
require_once 'config.php';
requireLogin();

$pdo = getDatabase();
$message = '';
$error = '';
$productId = (int)($_GET['id'] ?? 0);

if (!$productId) {
    header('Location: products.php');
    exit;
}

// Buscar produto
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$productId]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: products.php');
    exit;
}

if ($_POST) {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $category = trim($_POST['category'] ?? '');
    $stock = intval($_POST['stock'] ?? 0);
    $image = trim($_POST['image'] ?? '');
    
    // Validações
    if (empty($name)) {
        $error = 'Nome do produto é obrigatório.';
    } elseif ($price <= 0) {
        $error = 'Preço deve ser maior que zero.';
    } elseif (empty($category)) {
        $error = 'Categoria é obrigatória.';
    } elseif ($stock < 0) {
        $error = 'Estoque não pode ser negativo.';
    } else {
        try {
            $stmt = $pdo->prepare("
                UPDATE products 
                SET name = ?, description = ?, price = ?, category = ?, stock = ?, image = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?
            ");
            
            $stmt->execute([
                $name,
                $description,
                priceToCents($price),
                $category,
                $stock,
                $image,
                $productId
            ]);
            
            $message = 'Produto atualizado com sucesso!';
            
            // Atualizar dados do produto
            $product['name'] = $name;
            $product['description'] = $description;
            $product['price'] = priceToCents($price);
            $product['category'] = $category;
            $product['stock'] = $stock;
            $product['image'] = $image;
            
        } catch (PDOException $e) {
            $error = 'Erro ao atualizar produto: ' . $e->getMessage();
        }
    }
}

// Buscar categorias existentes
$categories = $pdo->query("SELECT DISTINCT category FROM products ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto - Painel Administrativo</title>
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
        
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 800px;
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
            grid-template-columns: 1fr 1fr;
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
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e1e5e9;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
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
        
        .btn-logout {
            background: #dc3545;
            color: white;
        }
        
        .btn-logout:hover {
            background: #c82333;
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
        
        .help-text {
            font-size: 0.9rem;
            color: #666;
            margin-top: 0.25rem;
        }
        
        .product-preview {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1.5rem;
        }
        
        .product-preview img {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-edit"></i> Editar Produto</h1>
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
        <div class="page-header">
            <h2>Editar Produto #<?php echo $product['id']; ?></h2>
            <a href="products.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar para Produtos
            </a>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3>Informações do Produto</h3>
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
                
                <?php if ($product['image']): ?>
                <div class="product-preview">
                    <strong>Imagem Atual:</strong><br>
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Produto">
                </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Nome do Produto <span class="required">*</span></label>
                            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="category">Categoria <span class="required">*</span></label>
                            <select id="category" name="category" required>
                                <option value="">Selecione uma categoria</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo $product['category'] === $cat ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cat); ?>
                                    </option>
                                <?php endforeach; ?>
                                <option value="Nova Categoria">+ Nova Categoria</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="price">Preço (R$) <span class="required">*</span></label>
                            <input type="number" id="price" name="price" step="0.01" min="0" value="<?php echo number_format($product['price'] / 100, 2, '.', ''); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="stock">Estoque</label>
                            <input type="number" id="stock" name="stock" min="0" value="<?php echo $product['stock']; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row full">
                        <div class="form-group">
                            <label for="description">Descrição</label>
                            <textarea id="description" name="description" placeholder="Descreva as características do produto..."><?php echo htmlspecialchars($product['description']); ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-row full">
                        <div class="form-group">
                            <label for="image">URL da Imagem</label>
                            <input type="url" id="image" name="image" value="<?php echo htmlspecialchars($product['image']); ?>" placeholder="https://exemplo.com/imagem.jpg">
                            <div class="help-text">URL completa da imagem do produto (opcional)</div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar Alterações
                        </button>
                        <a href="products.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Permitir criar nova categoria
        document.getElementById('category').addEventListener('change', function() {
            if (this.value === 'Nova Categoria') {
                const newCategory = prompt('Digite o nome da nova categoria:');
                if (newCategory && newCategory.trim()) {
                    const option = new Option(newCategory.trim(), newCategory.trim(), true, true);
                    this.add(option, this.options.length - 1);
                } else {
                    this.value = '<?php echo htmlspecialchars($product['category']); ?>';
                }
            }
        });
    </script>
</body>
</html>
