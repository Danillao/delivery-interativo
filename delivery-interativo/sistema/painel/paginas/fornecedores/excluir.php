<?php
require_once("../../../config/conexao.php");

$tabela = 'tb_fornecedores';

$id = $_POST['id'];

$pdo->query("DELETE from $tabela where id = '$id'");
echo 'Excluído com Sucesso';
