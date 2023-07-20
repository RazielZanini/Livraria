<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Tela de Login</title>
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

    #login-form {
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
      background-color: #222;
      border: 1px solid #444;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    #login-form h2 {
      margin-top: 0;
      color: #fff;
      text-align: center;
    }

    #login-form input[type="text"],
    #login-form input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background-color: #333;
      color: #fff;
      box-sizing: border-box;
    }

    #login-form input[type="submit"] {
      width: 100%;
      padding: 10px;
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
    }.navbar {
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
        <a href="cadastro.php">Cadastro</a>
        <a href="relatorio.php">Relatório</a>
      </div>
    </div>
  </div>
  <h1>Tela de Login</h1>

  <form id="login-form" action="main.php" method="get">
    <h2>Fazer Login</h2>
    <input type="text" name="nome" placeholder="Nome" id="nome">
    <input type="text" name="telefone" placeholder="Telefone" id="telefone">
    <input type="submit" value="Entrar">
  </form>
</body>
</html>
