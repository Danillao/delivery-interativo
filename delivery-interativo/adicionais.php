<?php
require_once("components/header.php");

$url_completa = $_GET['url'];

$sessao = date('Y-m-d-H:i:s-') . rand(0, 1500);

if (@$_SESSION['sessao_usuario'] == "") {
  $_SESSION['sessao_usuario'] = $sessao;
}

$nova_sessao = $_SESSION['sessao_usuario'];

$separar_url = explode("_", $url_completa);
$url = $separar_url[0];
$item = @$separar_url[1];


$query = $pdo->query("SELECT * FROM tb_produtos where url = '$url'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {

  $id_prod    = $res[0]['id'];
  $nome       = $res[0]['nome'];
  $descricao  = $res[0]['descricao'];
  $foto       = $res[0]['foto'];
  $valor      = $res[0]['valor_venda'];
  $valorF     = number_format($valor, 2, ',', '.');
  $categoria  = $res[0]['categoria'];


  if ($item == "") {
    $valor_item = $valor;
  } else {
    $query = $pdo->query("SELECT * FROM tb_variacoes where produto = '$id_prod' and nome = '$item'");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $valor_item = $res[0]['valor'];
  }
}
?>

<div class="main-container">

  <nav class="navbar bg-light fixed-top" style="box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.20);">
    <div class="container-fluid">
      <div class="navbar-brand">
        <a href="produto-<?php echo $url ?>"><big><i class="fad fa-arrow-alt-left link-neutro"></i></big></a>
        <span class="titulo-responsivo " style="margin-left: 15px"><?php echo $nome ?> <?php echo $item ?></span>
      </div>

      <?php require_once("components/icone-carrinho.php") ?>

    </div>
  </nav>


  <div id="listar-adicionais" style='margin-top: 70px;'>



  </div>



  <div id="listar-ing">



  </div>


  <div class="d-grid gap-2 mt-4">
    <a href='observacoes-<?php echo $url_completa ?>' class="btn btn-primary">Avançar</a>
  </div>


</div>

</body>

</html>


<script type="text/javascript">
  $(document).ready(function() {
    listarAdicionais();
    listarIng();
  });



  function adicionar(id, acao) {

    $.ajax({
      url: 'js/ajax/adicionais.php',
      method: 'POST',
      data: {
        id,
        acao
      },
      dataType: "text",

      success: function(mensagem) {

        if (mensagem.trim() == "Alterado com Sucesso") {
          listarAdicionais();
        }

      },

    });
  }

  function adicionarIng(id, acao) {

    $.ajax({
      url: 'js/ajax/adicionar-ing.php',
      method: 'POST',
      data: {
        id,
        acao
      },
      dataType: "text",

      success: function(mensagem) {

        if (mensagem.trim() == "Alterado com Sucesso") {
          listarIng();
        }

      },

    });
  }



  function listarAdicionais() {
    var id = '<?= $id_prod ?>';
    var valor = '<?= $valor_item ?>';

    $.ajax({
      url: 'js/ajax/listar-adicionais.php',
      method: 'POST',
      data: {
        id,
        valor
      },
      dataType: "html",

      success: function(result) {
        $("#listar-adicionais").html(result);

      }
    });
  }

  function listarIng() {
    var id = '<?= $id_prod ?>';

    $.ajax({
      url: 'js/ajax/listar-ing.php',
      method: 'POST',
      data: {
        id
      },
      dataType: "html",

      success: function(result) {
        $("#listar-ing").html(result);

      }
    });
  }
</script>