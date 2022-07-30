<?php
require_once("../../config/conexao.php");


$id         = $_POST['id_usuario'];
$nome       = $_POST['nome'];
$email      = $_POST['email'];
$cpf        = $_POST['cpf'];
$telefone   = $_POST['telefone'];
$senha      = $_POST['senha'];
$conf_senha = $_POST['conf_senha'];

$hash = md5($senha);

//VERIFICANDO IGUALDADE ENTRE SENHA E CONFIRMAR SENHA
if ($senha != $conf_senha) {
  echo 'As senhas não se coincidem!!';
  exit();
}


//VALIDAR PELO EMAIL
$query = $pdo->query("SELECT * from tb_usuarios where email = '$email'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if (@count($res) > 0 and $id != $res[0]['id']) {
  echo 'Email já Cadastrado, escolha outro!!';
  exit();
}


//VALIDAR PELO CPF
$query = $pdo->query("SELECT * from tb_usuarios where cpf = '$cpf'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if (@count($res) > 0 and $id != $res[0]['id']) {
  echo 'CPF já Cadastrado, escolha outro!!';
  exit();
}


//VALIDAR TROCA DE FOTO
$query = $pdo->query("SELECT * FROM tb_usuarios where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {
  $foto = $res[0]['foto'];
} else {
  $foto = 'sem-foto.jpg';
}




//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') . '-' . @$_FILES['foto']['name'];
$nome_img = preg_replace('/[ :]+/', '-', $nome_img);

$caminho = 'images/perfil/' . $nome_img;

$imagem_temp = @$_FILES['foto']['tmp_name'];

if (@$_FILES['foto']['name'] != "") {
  $ext = pathinfo($nome_img, PATHINFO_EXTENSION);
  if ($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif') {

    //EXCLUO A FOTO ANTERIOR
    if ($foto != "sem-foto.jpg") {
      @unlink('images/perfil/' . $foto);
    }

    $foto = $nome_img;

    move_uploaded_file($imagem_temp, $caminho);
  } else {
    echo 'Extensão de Imagem não permitida!';
    exit();
  }
}


$query = $pdo->prepare("UPDATE tb_usuarios SET nome = :nome, email = :email, cpf = :cpf, senha = :senha, hash = '$hash', foto = '$foto', telefone = :telefone ");

$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":cpf", "$cpf");
$query->bindValue(":senha", "$senha");
$query->bindValue(":telefone", "$telefone");
$query->execute();

echo 'Editado com Sucesso';
