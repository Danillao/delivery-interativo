<?php
require_once("../../sistema/config/conexao.php");


$id = $_POST['id'];


$pdo->query("DELETE FROM tb_carrinho WHERE id = '$id'");

echo 'Excluido com Sucesso';
