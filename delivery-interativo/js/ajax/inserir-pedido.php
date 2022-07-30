<?php
require_once("../../sistema/config/conexao.php");


$pagamento    = $_POST['pagamento'];
$entrega      = $_POST['entrega'];
$rua          = $_POST['rua'];
$numero       = $_POST['numero'];
$bairro       = $_POST['bairro'];
$complemento  = $_POST['complemento'];
$total_pago   = $_POST['troco'];
$obs          = $_POST['obs'];
$sessao       = @$_SESSION['sessao_usuario'];
$total_pago   = str_replace(',', '.', $total_pago);


if ($entrega == "Delivery") {
  $query = $pdo->query("SELECT * FROM tb_bairros where nome = '$bairro'");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  $taxa_entrega = $res[0]['valor'];
} else {
  $taxa_entrega = 0;
}



$total_carrinho = 0;
$query = $pdo->query("SELECT * FROM tb_carrinho where sessao = '$sessao'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
$cliente = $res[0]['cliente'];

for ($i = 0; $i < $total_reg; $i++) {
  foreach ($res[$i] as $key => $value) {
  }

  $id         = $res[$i]['id'];
  $total_item = $res[$i]['total_item'];
  $produto    = $res[$i]['produto'];

  $total_carrinho += $total_item;
}




$total_com_frete = $total_carrinho + $taxa_entrega;
if ($total_pago == "") {
  $total_pago = $total_com_frete;
}
$troco = $total_pago - $total_com_frete;


//ATUALIZA DADOS DO CLIENTE
$query = $pdo->prepare("UPDATE tb_clientes SET rua = :rua, numero = :numero, complemento = :complemento, bairro = :bairro where id = '$cliente'");
$query->bindValue(":rua", "$rua");
$query->bindValue(":numero", "$numero");
$query->bindValue(":complemento", "$complemento");
$query->bindValue(":bairro", "$bairro");
$query->execute();


$query = $pdo->prepare("INSERT INTO tb_vendas SET cliente = '$cliente', valor = '$total_com_frete', total_pago = '$total_pago', troco = '$troco', data = '$data_atual', hora = '$hora_atual', status = 'Iniciado', pago = 'Não', obs = :obs, taxa_entrega = '$taxa_entrega', tipo_pgto = '$pagamento', usuario_baixa = '0', entrega = '$entrega'");
$query->bindValue(":obs", "$obs");
$query->execute();
$id_pedido = $pdo->lastInsertId();



//RELACIONAR ITENS DO CARRINHO COM O PEDIDO 
$pdo->query("UPDATE tb_carrinho SET pedido = '$id_pedido' where sessao = '$sessao' and pedido = '0'");

//LIMPAR SESSAO ABERTA
@$_SESSION['sessao_usuario'] = "";
session_destroy();

$hora_pedido = date('H:i', strtotime("+$previsao_entrega minutes", strtotime(date('H:i'))));
echo $hora_pedido;
