<?php
require_once("../../../config/conexao.php");

$tabela = 'tb_adicionais';

$id = $_POST['id'];
$acao = $_POST['acao'];

$pdo->query("UPDATE $tabela SET ativo = '$acao' where id = '$id'");
echo 'Alterado com Sucesso';
