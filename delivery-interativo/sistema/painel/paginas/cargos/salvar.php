<?php
require_once("../../../config/conexao.php");

$tabela = 'tb_cargos';


$id   = $_POST['id'];
$nome = $_POST['nome'];

//VALIDAR NOME
$query = $pdo->query("SELECT * from $tabela where nome = '$nome'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if (@count($res) > 0 and $id != $res[0]['id']) {
  echo 'Cargo já Cadastrado, escolha outro!!';
  exit();
}


if ($id == "") {
  $query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome");
} else {
  $query = $pdo->prepare("UPDATE $tabela SET nome = :nome WHERE id = '$id'");
}

$query->bindValue(":nome", "$nome");
$query->execute();

echo 'Salvo com Sucesso';
