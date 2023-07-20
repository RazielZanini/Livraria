<?php
// Conexão com o banco de dados
$mysqli = new mysqli('localhost', 'root', 'root', 'livraria');
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  exit;
}

// Consulta SQL para buscar as vendas
$queryVendas = "SELECT 
DATE(c.dataCompra) AS data_compra,
COUNT(DISTINCT c.idCompra) as numero_vendas,
COUNT(DISTINCT cl.idCliente) AS numero_clientes,
SUM(l.valor) as valor_agregado
FROM compra c
LEFT JOIN livro l ON c.codigoLivro = l.codigoLivro
JOIN cliente cl ON cl.idCliente = c.idcliente
GROUP BY DATE(c.dataCompra)
ORDER BY COUNT(cl.idCliente) DESC;";

// Consulta SQL para obter o número de livros vendidos por data
$queryNumeroLivros = "SELECT 
l.titulo,
COUNT(c.idCompra) AS n_vendas,
SUM(l.valor) AS dinheiro
FROM livraria.compra c
LEFT JOIN livraria.livro l ON c.codigoLivro = l.codigoLivro
GROUP BY l.titulo
ORDER BY SUM(l.valor) DESC;";

// Consulta SQL para obter a quantidade de livros comprados por cliente
$queryLivrosPorCliente = "SELECT 
cl.nome,
cl.tel,
COUNT(c.idCompra) AS num_compras,
SUM(l.valor) AS valor_gasto
FROM cliente cl
RIGHT JOIN compra c ON c.idCliente = cl.idCliente
LEFT JOIN livro l ON l.codigoLivro = c.codigoLivro
GROUP BY cl.nome , cl.tel;";

$queryLivrosPorAutor = "SELECT c.nome, l.autor, count(distinct co.idCompra) as titulos_autor_comprados
from cliente c 
left join compra co on c.idCliente = co.idCliente
join livro l on co.codigoLivro = l.codigoLivro
group by c.nome,l.autor";

// Executar as consultas
$resultsVendas = $mysqli->query($queryVendas);
$resultsNumeroLivros = $mysqli->query($queryNumeroLivros);
$resultLivrosPorClientes = $mysqli->query($queryLivrosPorCliente);
$resultLivrosPorAutor = $mysqli->query($queryLivrosPorAutor);

// Fechar a conexão com o banco de dados
$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Relatório de Vendas</title>
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

    .coding{
      background-color: white;
      margin: 1px;
      padding-bottom: 4px;
      padding: 12px;
      box-shadow: inset 0px 0px 10px 10px #111;
      display: flex;
    }

    .prettyprint{
      font-size: 15px;
    }

    .titulo-coding{
      text-transform: capitalize;
      font-size: 19px;
      color: #000;
      font-weight: bold;
    }
  </style>
</head>
<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
<body>
<div class="navbar">
    <div class="dropdown">
      <div class="dropdown-button">&#9776;</div>
      <div class="dropdown-content">
        <a href="login.php">Login</a>
        <a href="cadastro.php">Cadastro</a>
        <a href="inserir_livro.php">Inserir Livro</a>
      </div>
    </div>
  </div>
  <h1>Relatório de Vendas</h1>

  <div id="report">
    <?php if ($resultsVendas->num_rows > 0) : ?>
      <h2>Vendas por Data</h2>
      <div class="coding">
        <p class="titulo-coding">Query utilizada para essa busca:</p>
        <pre class="prettyprint"> <?php echo $queryVendas; ?> </pre>
      </div>
      <br>
      <table>
        <thead>
          <tr>
            <th>Data da Compra</th>
            <th>Número de Vendas</th>
            <th>Número de Cliente Distintos que compraram</th>
            <th>Valor das Vendas no Dia</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $resultsVendas->fetch_assoc()) : ?>
            <tr>
              <td><?php echo date('d/m/Y', strtotime($row['data_compra'])); ?></td>
              <td><?php echo $row['numero_vendas']; ?></td>
              <td><?php echo $row['numero_clientes']; ?></td>
              <td>R$<?php echo number_format($row['valor_agregado'], 2, ',', '.'); ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else : ?>
      <p>Nenhum resultado encontrado.</p>
    <?php endif; ?>

    <?php if ($resultsNumeroLivros->num_rows > 0) : ?>
      <h2>Resultados de faturamento por livro</h2>
      <div class="coding">
        <p class="titulo-coding">Query utilizada para essa busca:</p>
        <pre class="prettyprint"> <?php echo $queryNumeroLivros; ?> </pre>
      </div>
      <table>
        <thead>
          <tr>
            <th>Livro</th>
            <th>Número Vendidos</th>
            <th>Valor Faturado</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $resultsNumeroLivros->fetch_assoc()) : ?>
            <tr>
              <td><?php echo $row['titulo']; ?></td>
              <td><?php echo $row['n_vendas']; ?></td>
              <td>R$<?php echo number_format($row['dinheiro'], 2, ',', '.'); ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <?php if ($resultLivrosPorClientes->num_rows > 0) : ?>
      <h2>Livros Vendidos por Cliente</h2>
      <div class="coding">
        <p class="titulo-coding">Query utilizada para essa busca:</p>
        <pre class="prettyprint"> <?php echo $queryLivrosPorCliente; ?> </pre>
      </div>
      <table>
        <thead>
          <tr>
            <th>Nome do Cliente</th>
            <th>Telefone de Contato</th>
            <th>Número de Livros Comprados</th>
            <th>Valor Gasto em Compras</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $resultLivrosPorClientes->fetch_assoc()) : ?>
            <tr>
              <td><?php echo $row['nome']; ?></td>
              <td><?php echo $row['tel']; ?></td>
              <td><?php echo $row['num_compras']; ?></td>
              <td>R$<?php echo number_format($row['valor_gasto'], 2, ',', '.'); ?></td>

            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <?php if ($resultLivrosPorAutor->num_rows > 0) : ?>
      <h2>Resultado de livros por autor</h2>
      <div class="coding">
        <p class="titulo-coding">Query utilizada para essa busca:</p>
        <pre class="prettyprint"> <?php echo $queryLivrosPorAutor; ?> </pre>
      </div>
      <table>
        <thead>
          <tr>
            <th>Nome Cliente</th>
            <th>Nome Autor</th>
            <th>Quantidade titulos comprados</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $resultLivrosPorAutor->fetch_assoc()) : ?>
            <tr>
              <td><?php echo $row['nome']; ?></td>
              <td><?php echo $row['autor']; ?></td>
              <td><?php echo $row['titulos_autor_comprados']; ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</body>
</html>
