<?php
require('config/conexao.php');

if(isset($_GET['cod_confirm']) && !empty($_GET['cod_confirm']) ){
    
    //LIMPAR O _GET

    $cod = limparPost($_GET['cod_confirm']);
    
    //CONSULTAR SE ALGUM USUARIO POSSUI ESSE CODIGO DE CONFIRMACÃO
    // VERIFICAR SE EXISTE O USUARIO
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE codigo_confirmacao=? LIMIT 1");
    $sql->execute(array($cod));
    $usuario = $sql->fetch(PDO::FETCH_ASSOC); 

    if($usuario){
        //ATUALIZAR STATUS DO USUARIO NO BANCO PARA CONFIRMADO
        $status = "confirmado";
        $sql = $pdo->prepare("UPDATE usuarios SET status=? WHERE codigo_confirmacao=? ");
        if($sql->execute(array($status,$cod))){
            // ARMAZENAR TOKEN NA SESSÃO (SESSION)            
            header('location: index.php?result=ok');
        }else{
            echo "<h1>Código de confirmação inválido!</h1>";
        }      
    }
}



?>