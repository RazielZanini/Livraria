<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Inserir Livro</title>
  <style>
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

    #report {
      margin: 0 auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table th,
    table td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #444;
    }

    table th {
      background-color: #222;
      color: #fff;
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

    /* Estilos para o formulário */
    form {
      max-width: 500px;
      margin: 0 auto;
    }

    form label,
    form input,
    form select,
    form textarea {
      display: block;
      margin-bottom: 10px;
    }

    form input,
    form select,
    form textarea {
      width: 100%;
      padding: 10px;
      font-size: 16px;
    }

    form button {
      padding: 10px 20px;
      font-size: 16px;
      background-color: #444;
      color: #fff;
      border: none;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="navbar">
    <div class="dropdown">
      <div class="dropdown-button">&#9776;</div>
      <div class="dropdown-content">
        <a href="login.php">Login</a>
        <a href="cadastro.php">Cadastro</a>
        <a href="relatorio.php">Relatório</a>
      </div>
    </div>
  </div>

  <!-- Formulário de inserção de livros -->
  <h1>Inserir Livro</h1>
  <form action="processar_livro.php" method="post">
    <label for="editora">Editora:</label>
    <input type="text" id="editora" name="editora" required>

    <label for="autor">Autor:</label>
    <input type="text" id="autor" name="autor" required>

    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="titulo" required>

    <label for="valor">Valor:</label>
    <input type="number" id="valor" name="valor" step="0.01" required>

    <label for="imagem">Link da imagem:</label>
    <input type="text" id="imagem" name="imagem" required>

    <label for="estoque">Quantidade de estoque:</label>
    <input type="number" id="estoque" name="estoque" required>

    <button type="submit">Inserir Livro</button>
  </form>
  <script>
    function toggleMenu() {
      var menuContainer = document.getElementById("menu-container");
      menuContainer.classList.toggle("show");
    }
  </script>
</body>
</html>
