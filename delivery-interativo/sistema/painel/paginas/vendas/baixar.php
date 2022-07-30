<?php
require_once("../../../config/conexao.php");

$tabela = 'tb_vendas';

$id_usuario = $_SESSION['id'];


$id = $_POST['id'];

$pdo->query("UPDATE $tabela SET pago = 'Sim', usuario_baixa = '$id_usuario' where id = '$id'");

echo 'Baixado com Sucesso';
