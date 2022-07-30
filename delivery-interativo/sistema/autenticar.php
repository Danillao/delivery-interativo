<?php
require_once("config/conexao.php");

$email  = $_POST['email'];
$senha  = $_POST['senha'];
$hash   = md5($senha);

$query = $pdo->prepare("SELECT * FROM tb_usuarios WHERE (email = :email or cpf = :email) and hash= :senha ");
$query->bindValue(":email", "$email");
$query->bindValue(":senha", "$hash");
$query->execute();
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
  $_SESSION['id']     = $res[0]['id'];
  $_SESSION['nome']   = $res[0]['nome'];
  $_SESSION['nivel']  = $res[0]['nivel'];
  $_SESSION['ativo']  = $res[0]['ativo'];

  if ($_SESSION['ativo'] == 'Sim') {
    echo "<script>window.location = 'painel'</script>";
  } else {
    echo "<script>window.alert('Usuário Inativo!')</script>";
    echo "<script>window.location = 'index.php'</script>";
  }
} else {
  echo "<script>window.alert('Usuário ou Senha Incorretos!')</script>";
  echo "<script>window.location = 'index.php'</script>";
}
