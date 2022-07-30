<?php
require_once("../../../config/conexao.php");

$tabela = 'tb_bairros';

$id = $_POST['id'];

$pdo->query("DELETE from $tabela where id = '$id'");
echo 'Excluído com Sucesso';
