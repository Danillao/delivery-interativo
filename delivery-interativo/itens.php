<?php
require_once("components/header.php");

$url = $_GET['url'];

$query = $pdo->query("SELECT * FROM tb_categorias where url = '$url'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {
  $id         = $res[0]['id'];
  $nome       = $res[0]['nome'];
  $descricao  = $res[0]['descricao'];
}
?>

<div class="main-container">

  <nav class="navbar bg-light fixed-top" style="box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.20);">
    <div class="container-fluid">
      <div class="navbar-brand">
        <a href="index"><big><i class="fad fa-arrow-alt-left link-neutro"></i></big></a>
        <span style="margin-left: 15px"><?php echo strtoupper($nome) ?></span>
      </div>

      <?php require_once("components/icone-carrinho.php"); ?>

    </div>
  </nav>




  <ol class="list-group " style="margin-top: 65px">

    <?php
    $query = $pdo->query("SELECT * FROM tb_produtos where categoria = '$id' and ativo = 'Sim'");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_reg = @count($res);
    if ($total_reg > 0) {
      for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }

        $id           = $res[$i]['id'];
        $foto         = $res[$i]['foto'];
        $nome         = $res[$i]['nome'];
        $url          = $res[$i]['url'];
        $estoque      = $res[$i]['estoque'];
        $tem_estoque  = $res[$i]['tem_estoque'];
        $valor        = $res[$i]['valor_venda'];
        $valorF       = number_format($valor, 2, ',', '.');

        if ($tem_estoque == 'Sim' and $estoque <= 0) {
          $mostrar = 'ocultar';
        } else {
          $mostrar = '';
        }
    ?>

        <a href="produto-<?php echo $url ?>" class="link-neutro <?php echo $mostrar ?>">
          <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="me-auto">
              <div class="fw-bold titulo-item"><?php echo $nome ?></div>
              <span class="valor-item">
                <?php
                $query2 = $pdo->query("SELECT * FROM tb_variacoes where produto = '$id' and ativo = 'Sim'");
                $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                $total_reg2 = @count($res2);
                if ($total_reg2 > 0) {
                  for ($i2 = 0; $i2 < $total_reg2; $i2++) {
                    foreach ($res2[$i2] as $key => $value) {
                    }

                    $sigla      = $res2[$i2]['sigla'];
                    $valorvar   = $res2[$i2]['valor'];
                    $valorvarF  = number_format($valorvar, 2, ',', '.');

                    echo '(' . $sigla . ') R$ ' . $valorvarF;
                    if ($i2 < $total_reg2 - 1) {
                      echo ' / ';
                    }
                  }
                } else {
                  echo 'R$ ' . $valorF;
                }
                ?>
              </span>
            </div>

          </li>
        </a>

    <?php
      }
    };
    ?>

  </ol>


</div>

</body>

</html>