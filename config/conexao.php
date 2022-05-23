<?php
session_start();



//DOIS MODOS POSSIVEIS  -> local, produção
$modo = 'local';

if($modo =='local'){
    $servidor ="localhost";
    $usuario = "root";
    $senha = "";
    $banco = "login";
}

if($modo =='producao'){
    $servidor ="localhost";
    $usuario = "";
    $senha = "";
    $banco = "";
}

try{
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco",$usuario,$senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
}catch(PDOException $erro){
    echo "Falha ao se conectar com o banco!";
}

function limparPost($dados){
    $dados = trim($dados);
    $dados = stripslashes($dados);
    $dados = htmlspecialchars($dados);
    return $dados;
}

function auth($tokenSessao){
    global $pdo;

    //VERIFICAR SE TE AUTORIZAÇÃO
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE token=? LIMIT 1");
    $sql->execute(array($tokenSessao));
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);

    //SE NÃO ENCONTRAR O USUÁRIO
    if(!$usuario){
        return false;
    }else{
        return $usuario;
    }
}

