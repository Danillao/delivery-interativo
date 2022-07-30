<?php
require_once("../../../config/conexao.php");

$tabela = 'tb_usuarios';

$id         = $_POST['id'];
$nome       = $_POST['nome'];
$email      = $_POST['email'];
$telefone   = $_POST['telefone'];
$cpf        = $_POST['cpf'];
$cargo      = $_POST['cargo'];
$tipo_chave = $_POST['tipo_chave'];
$chave_pix  = $_POST['chave_pix'];
$senha      = '123';
$hash       = md5($senha);


//VALIDAR EMAIL
$query = $pdo->query("SELECT * from $tabela where email = '$email'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if (@count($res) > 0 and $id != $res[0]['id']) {
  echo 'Email já Cadastrado, escolha outro!!';
  exit();
}


//VALIDAR CPF
$query = $pdo->query("SELECT * from $tabela where cpf = '$cpf'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if (@count($res) > 0 and $id != $res[0]['id']) {
  echo 'CPF já Cadastrado, escolha outro!!';
  exit();
}



//VALIDAR TROCA DA FOTO
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
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

$caminho = '../../images/perfil/' . $nome_img;

$imagem_temp = @$_FILES['foto']['tmp_name'];

if (@$_FILES['foto']['name'] != "") {
  $ext = pathinfo($nome_img, PATHINFO_EXTENSION);
  if ($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif') {

    //EXCLUO A FOTO ANTERIOR
    if ($foto != "sem-foto.jpg") {
      @unlink('../../images/perfil/' . $foto);
    }

    $foto = $nome_img;

    move_uploaded_file($imagem_temp, $caminho);
  } else {
    echo 'Extensão de Imagem não permitida!';
    exit();
  }
}




if ($id == "") {
  $query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, email = :email, cpf = :cpf, senha = '$senha', hash = '$hash', nivel = '$cargo', data = '$data_atual', ativo = 'Sim', telefone = :telefone, foto = '$foto', tipo_chave = '$tipo_chave', chave_pix = :chave_pix");
} else {
  $query = $pdo->prepare("UPDATE $tabela SET nome = :nome, email = :email, cpf = :cpf, nivel = '$cargo', telefone = :telefone, foto = '$foto', tipo_chave = '$tipo_chave', chave_pix = :chave_pix WHERE id = '$id'");
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":cpf", "$cpf");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":chave_pix", "$chave_pix");
$query->execute();

echo 'Salvo com Sucesso';
