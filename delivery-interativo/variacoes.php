<?php
require_once("components/header.php");

$url = $_GET['url'];

$query = $pdo->query("SELECT * FROM tb_produtos where url = '$url'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {

  $nome       = $res[0]['nome'];
  $descricao  = $res[0]['descricao'];
  $foto       = $res[0]['foto'];
  $id         = $res[0]['id'];
  $valor      = $res[0]['valor_venda'];
  $valorF     = number_format($valor, 2, ',', '.');
  $categoria  = $res[0]['categoria'];

  $query = $pdo->query("SELECT * FROM tb_categorias where id = '$categoria'");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  $url_cat = $res[0]['url'];

  // Verificar se o produto tem variações ou ingredientes 
  $query = $pdo->query("SELECT * FROM tb_adicionais where produto = '$id'");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  $total_adc = @count($res);

  $query = $pdo->query("SELECT * FROM tb_ingredientes where produto = '$id'");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  $total_ing = @count($res);
}
?>

<div class="main-container">

  <nav class="navbar bg-light fixed-top" style="box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.20);">
    <div class="container-fluid">
      <div class="navbar-brand">
        <a href="categoria-<?php echo $url_cat; ?>"><big><i class="fad fa-arrow-alt-left link-neutro"></i></big></a>
        <span class="titulo-responsivo" style="margin-left: 15px"><?php echo mb_strtoupper($nome) ?></span>
      </div>

      <?php require_once("components/icone-carrinho.php"); ?>

    </div>
  </nav>




  <ol class="list-group " style="margin-top: 65px">

    <?php
    $query = $pdo->query("SELECT * FROM tb_variacoes where produto = '$id' and ativo = 'Sim'");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_reg = @count($res);
    if ($total_reg > 0) {
      for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }

        $id         = $res[$i]['id'];
        $sigla      = $res[$i]['sigla'];
        $descricao  = $res[$i]['descricao'];
        $nome_var   = $res[$i]['nome'];
        $valorvar   = $res[$i]['valor'];
        $valorvarF  = number_format($valorvar, 2, ',', '.');

    ?>

        <?php
        if ($total_adc > 0 || $total_ing > 0) { ?>
          <a href="adicionais-<?php echo $url ?>_<?php echo $nome_var ?>" class="link-neutro">
          <?php } else { ?>

            <a href="observacoes-<?php echo $url ?>_<?php echo $nome_var ?>" class="link-neutro">
            <?php } ?>

            <li class="list-group-item d-flex justify-content-between align-items-start">
              <div class="me-auto">
                <div class="fw-bold titulo-item"><?php echo $nome_var ?> <span class="subtitulo-item">(<?php echo $descricao ?>)</span></div>
                <span class="valor-item">R$ <?php echo $valorvarF ?></span>
              </div>

            </li>
            </a>

          <?php }
      } else { ?>

          <?php
          if ($total_adc > 0 || $total_ing > 0) { ?>
            <a href="adicionais-<?php echo $url ?>" class="link-neutro">
            <?php } else { ?>

              <a href="observacoes-<?php echo $url ?>" class="link-neutro">
              <?php } ?>

              <li class="list-group-item">

                <i class="bi bi-circle"></i>
                <?php echo $nome ?> <span class="valor-item">(R$ <?php echo $valorF ?>)</span>
                <big><big><i class="bi bi-check direita text-success"></i></big></big>
              </li>
              </a>
            <?php } ?>



  </ol>

  <hr>
  <div class="conteudo-descricao-item">
    <div class="titulo-descricao-item"><b>Descrição <?php echo $nome ?></b></div>
    <p class="descricao-item"><?php echo $descricao ?></p>
  </div>
  <div>
    <img class="imagem-produto" src="sistema/painel/images/produtos/<?php echo $foto ?>">
  </div>

</div>

</body>

</html>