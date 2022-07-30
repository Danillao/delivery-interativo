<?php
require_once("../../../config/conexao.php");

$tabela = 'tb_dias';

$id 	= $_POST['id'];
$dia 	= $_POST['dia'];


//VALIDAR DIA
$query = $pdo->query("SELECT * from $tabela where dia = '$dia'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0 and $id != $res[0]['id']){
	echo 'Dia já Cadastrado, escolha outro!!';
	exit();
}


if($id == ""){
	$query = $pdo->prepare("INSERT INTO $tabela SET dia = :dia");
}else{
	$query = $pdo->prepare("UPDATE $tabela SET dia = :dia WHERE id = '$id'");
}

$query->bindValue(":dia", "$dia");
$query->execute();

echo 'Salvo com Sucesso';
