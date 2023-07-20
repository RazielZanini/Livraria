<?php
// Conexão com o banco de dados
$mysqli = new mysqli('localhost', 'root', 'root', 'livraria');
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  exit;
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obter os dados do formulário
  $editora = $_POST["editora"];
  $autor = $_POST["autor"];
  $titulo = $_POST["titulo"];
  $valor = $_POST["valor"];
  $imagem = $_POST["imagem"];
  $estoque = $_POST["estoque"];

  
  $queryInserirEstoque = "INSERT INTO estoque (quantidade) VALUES ($estoque)";

  // Executa a consulta SQL
  if ($mysqli->query($queryInserirEstoque) === TRUE) {
    echo "estoque com sucesso!";
    $id_estoque = $mysqli->insert_id;
  } else {
    echo "Erro ao inserir o livro: " . $mysqli->error;
  }

  // Prepara a consulta SQL para inserir o livro na tabela 'livro'
  $queryInserirLivro = "INSERT INTO livro (editora, autor, titulo, valor, link, idEstoque) 
                        VALUES ('$editora', '$autor', '$titulo', $valor, '$imagem', $id_estoque)";

  // Executa a consulta SQL
  if ($mysqli->query($queryInserirLivro) === TRUE) {
    echo "Livro inserido com sucesso!";
    $id_estoque = $mysqli->insert_id;
  } else {
    echo "Erro ao inserir o livro: " . $mysqli->error;
  }


}

// Fechar a conexão com o banco de dados
$mysqli->close();
?>
