<?php

// Inserindo o valor de compra
// Conexão com o banco de dados
$mysqli = new mysqli('localhost', 'root', 'root', 'livraria');
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  exit;
}

// Obter os dados enviados pelo formulário
$livroId = $_POST['livro_id'];
$livroTitulo = $_POST['livro_titulo'];
$cliente_id = $_POST['cliente_id'];
$id_estoque = $_POST['idEstoque'];

// Obter outras informações necessárias para a venda, se necessário

// Inserir o livro selecionado na tabela de vendas
$query = "INSERT INTO compra(dataCompra,codigoLivro,idCliente) VALUES(CURDATE(),'$livroId','$cliente_id')";

if ($mysqli->query($query)) {
  $mensagem_venda = "Venda realizada com sucesso!\n";
} else {
    $mensagem_venda =  "Erro ao realizar a venda: " . $mysqli->error;
}

//atualizando o valor no estoque
//buscando o estoque antigo
$query = "SELECT e.quantidade FROM estoque e
    LEFT JOIN livro l ON l.idEstoque = e.idEstoque
    WHERE l.codigoLivro = '$livroId';";

$result = $mysqli->query($query);
while($estoque = $result->fetch_assoc()){
    $quantidade = $estoque['quantidade'];
}

$quantidade = ($quantidade - 1);

$query = "UPDATE livraria.estoque SET quantidade = $quantidade WHERE idEstoque = '$id_estoque'";
if ($mysqli->query($query)) {
    $mensagem_estoque =  "Estoque atualizado com sucesso!";
  } else {
    $mensagem_estoque =  "Erro ao realizar o estoque: " . $mysqli->error;
  }
// Fechar a conexão com o banco de dados
$mysqli->close();   
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Confirmação de Venda</title>
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

    .message {
      margin-bottom: 20px;
    }

    .button-container {
      text-align: center;
    }

    .back-button {
      padding: 10px 20px;
      font-size: 16px;
      background-color: #333;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <h1>Confirmação de Venda</h1>

  <div class="message">
    <p><?php echo $mensagem_venda; ?></p>
    <p><?php echo $mensagem_estoque; ?></p>
  </div>

  <div class="button-container">
    <button class="back-button" onclick="history.go(-1);">Voltar</button>
  </div>
</body>
</html>