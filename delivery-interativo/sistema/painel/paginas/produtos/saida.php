<?php
require_once("../../../config/conexao.php");

$tabela     = 'tb_saidas';

$id_usuario = $_SESSION['id'];

$id_produto       = $_POST['id'];
$estoque          = $_POST['estoque'];
$quantidade_saida = $_POST['quantidade_saida'];
$motivo_saida     = $_POST['motivo_saida'];


$novo_estoque = $estoque - $quantidade_saida;


$query = $pdo->prepare("INSERT INTO $tabela SET produto = '$id_produto', quantidade = '$quantidade_saida', motivo = :motivo, usuario = '$id_usuario', data = '$data_atual'");


$query->bindValue(":motivo", "$motivo_saida");
$query->execute();


//atualizar o total no estoque do produto
$pdo->query("UPDATE tb_produtos SET estoque = '$novo_estoque' WHERE id = '$id_produto'");

echo 'Salvo com Sucesso';
