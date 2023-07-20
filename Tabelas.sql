create database Livraria;
use Livraria;
create table Livro (
codigoLivro int not null auto_increment,
editora varchar(30) not null,
autor varchar(30) not null,
titulo varchar(30),
link varchar(200),
valor double,
primary key (codigoLivro)
);
create table Fornecedor (
idFornecedor int not null auto_increment,
tel varchar(14),
nomeFornecedor varchar(30),
endereço varchar(50),
primary key (idFornecedor)
);
create table Estoque (
idEstoque int not null auto_increment,
quantidade int,
primary key (idEstoque)
);
create table Cliente (
idCliente int not null auto_increment,
nome varChar(20),
tel varChar(14),
endereço varChar(50),
CEP varChar(10),
primary key (idCliente)
);
create table pessoaJuridica (
CNPJ varChar(14) not null,
nomeFantasia varChar(20),
primary key (CNPJ)
);
create table pessoaFisica (
CPF varChar(11),
nome varChar(20),
primary key (CPF)
);
create table Compra (
idCompra int not null auto_increment,
dataCompra datetime,
primary key(idCompra)
);
create table recibo (
idRecibo int not null auto_increment,
primary key (idRecibo)
);
