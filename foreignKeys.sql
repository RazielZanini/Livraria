alter table Livro
add column idEstoque int;

alter table Livro 
add foreign key (idEstoque)
references Estoque (idEstoque);

alter table Fornecedor
add column codigoLivro int;

alter table Fornecedor
add foreign key (codigoLivro)
references Livro (codigoLivro);

alter table Compra 
add column codigoLivro int;

alter table Compra
add foreign key (codigoLivro)
references Livro (codigoLivro);

alter table recibo
add column idCompra int;

alter table recibo
add foreign key (idCompra)
references Compra (idCompra);

alter table cliente
add column idCompra int;

alter table cliente
add foreign key (idCompra)
references Compra (idCompra);

alter table pessoajuridica
add column idCliente int;

alter table pessoajuridica
add foreign key (idCliente)
references cliente (idCliente);

alter table pessoafisica
add column idCliente int;

alter table pessoafisica
add foreign key (idCliente)
references Cliente (idCliente);

alter table Compra
add column idcliente int;

alter table compra
add foreign key (idCliente)
references cliente (idcliente);
