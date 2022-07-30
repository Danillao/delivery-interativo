<?php
require_once("../../sistema/config/conexao.php");

@session_start();


$produto = $_POST['produto'];
$telefone = $_POST['telefone'];
$nome = $_POST['nome'];
$quantidade = $_POST['quantidade'];
$total_item = $_POST['total_item'];
$obs = $_POST['obs'];
$sessao = @$_SESSION['sessao_usuario'];



$query = $pdo->query("SELECT * FROM tb_clientes where telefone = '$telefone' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if (@count($res) > 0) {
  $id_cliente = $res[0]['id'];
} else {
  $query = $pdo->prepare("INSERT INTO tb_clientes SET nome = :nome, telefone = :telefone, data = '$data_atual'");
  $query->bindValue(":nome", "$nome");
  $query->bindValue(":telefone", "$telefone");
  $query->execute();
  $id_cliente = $pdo->lastInsertId();
}


$query = $pdo->prepare("INSERT INTO tb_carrinho SET sessao = '$sessao', cliente = '$id_cliente', produto = '$produto', quantidade = '$quantidade', total_item = '$total_item', obs = :obs, pedido = '0'");
$query->bindValue(":obs", "$obs");
$query->execute();
$id_carrinho = $pdo->lastInsertId();
echo 'Inserido com Sucesso';


//limpar os ingredientes e adicionais
$pdo->query("UPDATE tb_temp SET carrinho = '$id_carrinho' where sessao = '$sessao' and carrinho = '0'");
