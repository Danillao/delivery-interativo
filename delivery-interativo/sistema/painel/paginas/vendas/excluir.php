<?php
require_once("../../../config/conexao.php");

$tabela = 'tb_vendas';

$id = $_POST['id'];

$pdo->query("UPDATE $tabela SET status = 'Cancelado' where id = '$id'");
echo 'Excluído com Sucesso';
