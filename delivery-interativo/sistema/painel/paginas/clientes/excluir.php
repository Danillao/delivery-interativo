<?php
require_once("../../../config/conexao.php");

$tabela = 'tb_clientes';

$id = $_POST['id'];

$pdo->query("DELETE from $tabela where id = '$id'");
echo 'Excluído com Sucesso';
