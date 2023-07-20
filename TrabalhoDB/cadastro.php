<?php
// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obter os dados do formulário
  $nome = $_POST['nome'];
  $telefone = $_POST['telefone'];
  $endereco = $_POST['endereco'];
  $cep = $_POST['cep'];
  $documento = $_POST['documento'];

  // Conexão com o banco de dados
  $mysqli = new mysqli('localhost', 'root', 'root', 'livraria');
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit;
  }

  // Inserir o novo cliente na tabela
  $query = "INSERT INTO cliente (nome, tel, endereço, cep) VALUES ('$nome', '$telefone', '$endereco', '$cep')";

  
  if ($mysqli->query($query)) {
    $mensagem = "Cliente cadastrado com sucesso! ID = '$mysqli->insert_id'";
    $insert_id = $mysqli->insert_id;
  } else {
    $mensagem = "Erro ao cadastrar o cliente: " . $mysqli->error;
  }

  if(strlen($documento) > 11){
    $query = "INSERT INTO pessoajuridica(CNPJ, nomeFantasia, idCliente) VALUES ('$documento','$nome','$insert_id')";
    $mysqli->query($query);
  }else{
    $query = "INSERT INTO pessoafisica(CPF, nome, idCliente) VALUES ('$documento','$nome','$insert_id')";
    $mysqli->query($query);
  }

  // Fechar a conexão com o banco de dados
  $mysqli->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Cadastro de Cliente</title>
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

    form {
      max-width: 400px;
      margin: 0 auto;
    }

    label {
      display: block;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="tel"],
    input[type="submit"] {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background-color: #333;
      color: #fff;
    }

    input[type="submit"] {
      margin-top: 10px;
      background-color: #555;
      cursor: pointer;
      display: block;
      margin-left: 10px;
    }

    .message {
      margin-top: 20px;
      text-align: center;
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
  </style>
</head>
<body>

<div class="navbar">
    <div class="dropdown">
      <div class="dropdown-button">&#9776;</div>
      <div class="dropdown-content">
        <a href="login.php">Login</a>
        <a href="inserir_livro.php">Inserir Livro</a>
        <a href="relatorio.php">Relatório</a>
      </div>
    </div>
  </div>
  <h1>Cadastro de Cliente</h1>

  <form method="POST">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" required>

    <label for="telefone">Telefone:</label>
    <input type="tel" name="telefone" id="telefone" required>

    <label for="endereco">Endereço:</label>
    <input type="text" name="endereco" id="endereco" required>

    <label for="cep">CEP:</label>
    <input type="text" name="cep" id="cep" required>

    <label for="documento">Documento:</label>
    <input type="text" name="documento" id="documento" required>

    <input type="submit" value="Cadastrar" onclick="login.php">

    <?php if (isset($mensagem)) : ?>
      <p class="message"><?php echo $mensagem; ?></p>
    <?php endif; ?>
  </form>
</body>
</html>
