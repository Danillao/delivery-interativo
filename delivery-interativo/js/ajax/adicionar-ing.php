<?php
require_once("../../sistema/config/conexao.php");


$id     = $_POST['id'];
$acao   = $_POST['acao'];
$sessao = @$_SESSION['sessao_usuario'];


if ($acao == 'Não') {
  $pdo->query("INSERT INTO tb_temp SET sessao = '$sessao', tabela = 'tb_ingredientes', id_item = '$id', carrinho = '0'");
} else {
  $pdo->query("DELETE FROM tb_temp WHERE id_item = '$id' and sessao = '$sessao' and tabela = 'tb_ingredientes' and carrinho = '0'");
}

echo 'Alterado com Sucesso';
