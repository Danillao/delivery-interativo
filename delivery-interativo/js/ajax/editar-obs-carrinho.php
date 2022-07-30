<?php
require_once("../../sistema/config/conexao.php");

$id   = $_POST['id'];
$obs  = $_POST['obs'];


$query = $pdo->prepare("UPDATE tb_carrinho set obs = :obs WHERE id = '$id'");
$query->bindValue(":obs", "$obs");
$query->execute();

echo 'Salvo com Sucesso';
