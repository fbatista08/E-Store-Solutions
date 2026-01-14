<?php
require_once 'config.php';

try {
    $pdo = getDatabase();
    
    // Criar tabela de produtos
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            description TEXT,
            price INTEGER NOT NULL,
            image TEXT,
            category TEXT NOT NULL,
            stock INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    // Criar tabela de pedidos
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS orders (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            customer_name TEXT NOT NULL,
            customer_email TEXT NOT NULL,
            customer_phone TEXT,
            total_amount INTEGER NOT NULL,
            status TEXT DEFAULT 'pending',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    // Criar tabela de itens do pedido
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS order_items (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            order_id INTEGER NOT NULL,
            product_id INTEGER NOT NULL,
            quantity INTEGER NOT NULL,
            price INTEGER NOT NULL,
            FOREIGN KEY (order_id) REFERENCES orders(id),
            FOREIGN KEY (product_id) REFERENCES products(id)
        )
    ");
    
    // Verificar se já existem produtos
    $stmt = $pdo->query("SELECT COUNT(*) FROM products");
    $count = $stmt->fetchColumn();
    
    if ($count == 0) {
        // Inserir produtos do arquivo JSON
        $productsJson = file_get_contents('../products.json');
        $products = json_decode($productsJson, true);
        
        $stmt = $pdo->prepare("
            INSERT INTO products (name, description, price, image, category, stock) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        foreach ($products as $product) {
            $stmt->execute([
                $product['name'],
                $product['description'],
                (int)($product['price'] * 100), // Converter para centavos
                $product['image'],
                $product['category'],
                rand(5, 50) // Stock aleatório entre 5 e 50
            ]);
        }
        
        echo "Banco de dados inicializado com " . count($products) . " produtos.\n";
    } else {
        echo "Banco de dados já contém produtos.\n";
    }
    
    // Adicionar coluna order_number à tabela orders se não existir (compatível com SQLite)
    $stmt = $pdo->query("PRAGMA table_info(orders)");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN, 1);
    if (!in_array('order_number', $columns)) {
        $pdo->exec("ALTER TABLE orders ADD COLUMN order_number TEXT");
    }

    // Adicionar colunas product_name e product_image à tabela order_items se não existirem (compatível com SQLite)
    $stmt = $pdo->query("PRAGMA table_info(order_items)");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN, 1);
    if (!in_array('product_name', $columns)) {
        $pdo->exec("ALTER TABLE order_items ADD COLUMN product_name TEXT");
    }
    if (!in_array('product_image', $columns)) {
        $pdo->exec("ALTER TABLE order_items ADD COLUMN product_image TEXT");
    }

    echo "Banco de dados inicializado com sucesso!\n";
    
} catch (PDOException $e) {
    echo "Erro ao inicializar banco de dados: " . $e->getMessage() . "\n";
}
?>
