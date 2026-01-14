# Painel Administrativo E-Store Solutions

Sistema de gerenciamento administrativo para controle de estoque e pedidos da E-Store Solutions.

## 📋 Funcionalidades

### ✅ Sistema de Autenticação
- Login seguro para administradores
- Controle de sessão
- Proteção de páginas administrativas

### 📦 Gerenciamento de Produtos
- Listagem completa de produtos
- Adicionar novos produtos
- Editar produtos existentes
- Excluir produtos
- Controle de estoque
- Filtros por categoria e busca
- Alertas de baixo estoque

### 🛒 Gerenciamento de Pedidos
- Visualizar todos os pedidos
- Criar novos pedidos manualmente
- Atualizar status dos pedidos
- Visualizar detalhes completos dos pedidos
- Filtros por status e busca
- Excluir pedidos

### 📊 Dashboard
- Estatísticas gerais (produtos, pedidos, receita)
- Produtos com baixo estoque
- Pedidos recentes
- Indicadores visuais de status

## 🚀 Instalação

### Pré-requisitos
- PHP 8.1 ou superior
- SQLite3
- Extensões PHP: sqlite3, json, mbstring

### Passos de Instalação

1. **Extrair arquivos**
   ```bash
   # Os arquivos já estão no diretório /home/ubuntu/admin_panel/
   ```

2. **Inicializar banco de dados**
   ```bash
   cd /home/ubuntu/admin_panel
   php init_database.php
   ```

3. **Iniciar servidor**
   ```bash
   php -S localhost:8080
   ```

4. **Acessar o sistema**
   - Abra o navegador em: http://localhost:8080/login.php

## 🔐 Credenciais de Administrador

**Email:** admin@estore.com  
**Senha:** admin123

## 📁 Estrutura do Projeto

```
admin_panel/
├── config.php              # Configurações gerais e banco de dados
├── init_database.php       # Script de inicialização do banco
├── login.php              # Página de login
├── logout.php             # Script de logout
├── index.php              # Dashboard principal
├── products.php           # Gerenciamento de produtos
├── add_product.php        # Adicionar produto
├── edit_product.php       # Editar produto
├── orders.php             # Gerenciamento de pedidos
├── add_order.php          # Criar novo pedido
├── order_details.php      # Detalhes do pedido (AJAX)
├── database.sqlite        # Banco de dados SQLite
└── README.md              # Este arquivo
```

## 🗄️ Banco de Dados

O sistema utiliza SQLite com as seguintes tabelas:

### products
- `id` - ID único do produto
- `name` - Nome do produto
- `description` - Descrição detalhada
- `price` - Preço em centavos
- `image` - URL da imagem
- `category` - Categoria do produto
- `stock` - Quantidade em estoque
- `created_at` - Data de criação
- `updated_at` - Data da última atualização

### orders
- `id` - ID único do pedido
- `customer_name` - Nome do cliente
- `customer_email` - Email do cliente
- `customer_phone` - Telefone do cliente
- `total_amount` - Valor total em centavos
- `status` - Status do pedido (pending, processing, shipped, completed, cancelled)
- `created_at` - Data de criação
- `updated_at` - Data da última atualização

### order_items
- `id` - ID único do item
- `order_id` - Referência ao pedido
- `product_id` - Referência ao produto
- `quantity` - Quantidade do produto
- `price` - Preço unitário no momento da compra

## 🎨 Interface

- **Design Responsivo:** Interface adaptável para desktop e mobile
- **Tema Moderno:** Gradientes e sombras para visual profissional
- **Navegação Intuitiva:** Sidebar com menu de navegação
- **Feedback Visual:** Alertas de sucesso e erro
- **Modais Interativos:** Confirmações e visualizações detalhadas

## 🔧 Funcionalidades Técnicas

### Segurança
- Validação de entrada em todos os formulários
- Proteção contra SQL Injection usando prepared statements
- Controle de sessão para autenticação
- Sanitização de dados de saída

### Performance
- Consultas otimizadas ao banco de dados
- Carregamento assíncrono de detalhes de pedidos
- Interface responsiva com CSS Grid e Flexbox

### Usabilidade
- Filtros e busca em tempo real
- Atualização de estoque inline
- Cálculo automático de totais
- Validação de formulários no frontend

## 📱 Páginas Disponíveis

1. **Login** (`/login.php`) - Autenticação de administrador
2. **Dashboard** (`/index.php`) - Visão geral do sistema
3. **Produtos** (`/products.php`) - Lista e gerencia produtos
4. **Adicionar Produto** (`/add_product.php`) - Formulário para novos produtos
5. **Editar Produto** (`/edit_product.php?id=X`) - Edição de produtos existentes
6. **Pedidos** (`/orders.php`) - Lista e gerencia pedidos
7. **Novo Pedido** (`/add_order.php`) - Criação manual de pedidos

## 🚀 Próximos Passos

Para expandir o sistema, considere implementar:

- Sistema de usuários com diferentes níveis de acesso
- Relatórios e gráficos de vendas
- Integração com APIs de pagamento
- Sistema de notificações por email
- Backup automático do banco de dados
- API REST para integração com o site principal
- Sistema de categorias hierárquicas
- Controle de fornecedores
- Histórico de alterações de produtos

## 📞 Suporte

Para dúvidas ou problemas:
- Verifique se todas as extensões PHP estão instaladas
- Confirme se o banco de dados foi inicializado corretamente
- Verifique as permissões de escrita no diretório do projeto

---

**Desenvolvido para E-Store Solutions**  
Sistema de Painel Administrativo v1.0
