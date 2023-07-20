<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Vendas de Livros</title>
  <style>
    /* Estilos CSS para melhorar a aparência */

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #111;
      color: #fff;
    }

    h1 {
      text-align: center;
      color: #fff;
    }

    #search-form {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }

    #search {
      width: 300px;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background-color: #333;
      color: #fff;
    }

    #book-list {
      margin: 0 auto;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    .book-item {
      margin: 10px;
      padding: 10px;
      background-color: #222;
      border: 1px solid #444;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
      width: 200px;
      display: flex;
      flex-direction: column;
      align-items: center;
      cursor: pointer;
    }

    .book-item img {
      width: 150px;
      height: 225px;
      object-fit: cover;
      border-radius: 5px;
    }

    .book-item h3 {
      margin: 10px 0 5px;
      color: #fff;
      text-align: center;
    }

    .book-item p {
      margin: 0;
      color: #ccc;
      text-align: center;
    }

    .book-item span {
      font-weight: bold;
      color: #fff;
      display: none;
    }

    .book-item.selected {
      background-color: #444;
    }

    /* Estilos para o modal */
    #modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: rgba(0, 0, 0, 0.7);
      z-index: 9999;
      visibility: hidden;
      opacity: 0;
      transition: visibility 0s, opacity 0.3s;
    }

    #modal.show {
      visibility: visible;
      opacity: 1;
    }

    #modal-content {
      max-width: 400px;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
      text-align: center;
    }

    #modal-content h2 {
      margin-top: 0;
      color: #333;
    }

    #modal-content p {
      color: #777;
    }

    #modal-content button {
      padding: 10px 20px;
      font-size: 16px;
      background-color: #333;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .navbar {
      background-color: #444;
      padding: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .navbar a {
      color: #fff;
      text-decoration: none;
      padding: 5px 10px;
    }

    .navbar a:hover {
      background-color: #333;
    }

    /* Styles for the dropdown menu content */
    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #444;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
    }

    .dropdown-content a {
      color: #fff;
      text-decoration: none;
      display: block;
      padding: 10px;
    }

    .dropdown-content a:hover {
      background-color: #333;
    }

    /* Show the dropdown menu when the button is clicked */
    .dropdown:hover .dropdown-content {
      display: block;
    }
  </style>
</head>
<body>
<div class="navbar">
    <div class="dropdown">
      <div class="dropdown-button">&#9776;</div>
      <div class="dropdown-content">
        <a href="inserir_livro.php">Inserir Livro</a>
        <a href="login.php">Login</a>
        <a href="cadastro.php">Cadastro</a>
        <a href="relatorio.php">Relatório</a>
      </div>
    </div>
  </div>
  <h1>Vendas de Livros</h1>

  <form id="search-form" method="GET">
    <input type="text" name="search" id="search" placeholder="Pesquisar por nome do livro" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
    <input type="submit" value="Pesquisar">
  </form>

  <div id="book-list">
    <?php

    
      $query = "
      SELECT l.codigoLivro, l.editora, l.autor, l.titulo, l.valor, l.idEstoque, l.link, e.quantidade FROM livraria.livro l
      JOIN livraria.estoque e ON l.idEstoque = e.idEstoque
      WHERE e.quantidade > 0;";

      $mysqli = new mysqli('localhost', 'root', 'root','livraria');
      if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      }

      $nome = $_GET['nome'];
      $telefone = $_GET['telefone'];
    
      $results = $mysqli->query($query);
      $books = array();
      while ($row = $results->fetch_assoc()) {
        $sub = [
          'id' => $row['codigoLivro'],
          'title' => $row['titulo'],
          'author' => $row['autor'],
          'image' => $row['link'],
          'value' => $row['valor'],
          'idEstoque' => $row['idEstoque']
        ];
        array_push($books, $sub);
      }

      //funcao para buscar o id do cliente pelo nome
      $query = "SELECT * FROM livraria.cliente WHERE nome LIKE \"". $nome . "%\" AND tel LIKE \"". $telefone ."%\";";
      $result_clientes = $mysqli->query($query);
      
      while($cliente = $result_clientes->fetch_assoc()) {
        $id_cliente = $cliente['idCliente'];
        
      }
      // Função para exibir a lista de livros
      function displayBooks($books, $id_cliente) {
        foreach ($books as $book) {
          $id = $book['id'];
          $id_estoque = $book['idEstoque'];
          $title = $book['title'];
          $author = $book['author'];
          $image = $book['image'];
          $value = $book['value'];
          ?>
          <div class="book-item" onclick="handleBookItemClick(this);">
            <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>">
            <h3><?php echo $title; ?></h3>
            <p>Autor: <?php echo $author; ?></p>
            <p><span>Valor:</span> <?php echo $value; ?></p>
            <form method="POST" action="inserir_venda.php">
              <!-- campos ocultos para passar os detalhes do livro -->
              <input type="hidden" name="livro_id" value="<?php echo $id; ?>">
              <input type="hidden" name="livro_titulo" value="<?php echo $title; ?>">
              <input type="hidden" name="cliente_id" value="<?php echo $id_cliente; ?>">
              <input type="hidden" name="idEstoque" value="<?php echo $id_estoque; ?>">

              <!-- outros campos ocultos, se necessário -->

              <button type="submit">Comprar</button>
            </form>
          </div>
          <?php
        }
      }

      // Verificar se foi feita uma pesquisa
      $searchTerm = isset($_GET['search']) ? strtolower($_GET['search']) : '';

      // Filtrar os livros de acordo com o termo de pesquisa
      $filteredBooks = array_filter($books, function($book) use ($searchTerm) {
        return strpos(strtolower($book['title']), $searchTerm) !== false;
      });

      // Exibir a lista de livros
      displayBooks($filteredBooks, $id_cliente);
    ?>
  </div>
</body>
</html>
