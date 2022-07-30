<?php
require_once("../../sistema/config/conexao.php");

$tel = @$_POST['tel'];

if ($tel == "") {
  exit();
}

$query = $pdo->query("SELECT * FROM tb_clientes where telefone = '$tel' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if (@count($res) > 0) {
  $nome       = $res[0]['nome'];
  $id_cliente = $res[0]['id'];

  echo $nome;
}
