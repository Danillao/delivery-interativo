<?php
require_once("../../sistema/config/conexao.php");


$id         = $_POST['id'];
$acao       = $_POST['acao'];
$quantidade = $_POST['quantidade'];


if ($acao == 'menos') {
  if ($quantidade > 1) {
    $quant = $quantidade - 1;
  } else {
    $quan = 1;
  }
} else {
  $quant = $quantidade + 1;
}


$query = $pdo->query("SELECT * FROM tb_carrinho where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$total_item = $res[0]['total_item'];
$quantidade = $res[0]['quantidade'];
$valor_unit = $total_item / $quantidade;

$novo_valor = $quant * $valor_unit;

$pdo->query("UPDATE tb_carrinho set quantidade = '$quant', total_item = '$novo_valor' WHERE id = '$id'");

echo 'Alterado com Sucesso';
