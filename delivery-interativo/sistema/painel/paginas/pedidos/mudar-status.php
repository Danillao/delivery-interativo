<?php
require_once("../../../config/conexao.php");

$tabela = 'tb_vendas';


$id = $_POST['id'];
$acao = $_POST['acao'];


if ($acao == 'Finalizado') {
  $pdo->query("UPDATE $tabela SET status = '$acao', pago = 'Sim' where id = '$id'");
} else {
  $pdo->query("UPDATE $tabela SET status = '$acao' where id = '$id'");
}

echo 'Alterado com Sucesso';
