<?php
require_once("../../../config/conexao.php");

$tabela     = 'tb_entradas';

$id_usuario = $_SESSION['id'];

$id_produto         = $_POST['id'];
$estoque            = $_POST['estoque'];
$quantidade_entrada = $_POST['quantidade_entrada'];
$motivo_entrada     = $_POST['motivo_entrada'];

$novo_estoque = $estoque + $quantidade_entrada;

$query = $pdo->prepare("INSERT INTO $tabela SET produto = '$id_produto', quantidade = '$quantidade_entrada', motivo = :motivo, usuario = '$id_usuario', data = '$data_atual'");


$query->bindValue(":motivo", "$motivo_entrada");
$query->execute();


//ATUALIZAR O TOTAL NO ESTOQUE DO PRODUTO
$pdo->query("UPDATE tb_produtos SET estoque = '$novo_estoque' WHERE id = '$id_produto'");

echo 'Salvo com Sucesso';
