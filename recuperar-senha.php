<?php
require('config/conexao.php');


if(isset($_GET['cod']) && !empty($_GET['cod']) ){

    //LIMPAR O _GET
    $cod = limparPost($_GET['cod']);


    // VERIFICAR SE A POSTAGEM EXISTE DE ACORDO COM OS CAMPOS
    if(isset($_POST['senha']) && isset($_POST['repete_senha'])){  

    // VERIFICAR SE TODOS OS CAMPOS FORAM PREENCHIDOS
    if(empty($_POST['senha']) || empty($_POST['repete_senha'])){
        $erro_geral = "Todos os campos são obrigatórios!";
        }else{
        //RECEBER VALROES VINDOS DO POST E LIMPAR      
        $senha = limparPost($_POST['senha']);
        $senha_cript = sha1($senha);
        $repete_senha = limparPost($_POST['repete_senha']);                    

        // VERIFICAR SE SENHA TEM MAIS DE 6 DIGITOS

        if(strlen($senha) <= 6){
            $erro_senha = "Senha deve ter mais de 6 caracteres!";
        }

        //VERIFICAR SE REPETE SENHA É IGUAL A SENHA

        if($senha !== $repete_senha){
            $erro_repete_senha = "As senhas não coincidem!";
        }
        

        if(!isset($erro_geral) && !isset($erro_senha) && !isset($erro_repete_senha)){
            //VERIFICAR SE ESTA RECUPERAÇÃO DE SENHA EXISTE
            $sql = $pdo->prepare("SELECT * FROM usuarios WHERE recupera_senha=? LIMIT 1");
            $sql->execute(array($cod));

            $usuario = $sql->fetch();
            // SE NÃO EXISTIR O USUARIO - ADICIONAR NO BANCOS
            if(!$usuario){
               echo "Recuperação de senha inválida!";
            }else{
                // JÁ EXISTE USUARIO COM ESSE CODIGO DE RECUPERAÇÃO
                //ATUALIZAR TOKEN DO USUARIO NO BANCO
            $sql = $pdo->prepare("UPDATE usuarios SET senha=? WHERE recupera_senha=? ");
            if($sql->execute(array($senha_cript, $cod))){
                // REDIRECIONAR PARA LOGIN
                header('location: index.php');
            }        
    }

}
}
}
}else{
    header('location:index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/estilo.css" rel="stylesheet">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <title>Trocar senha</title>
</head>
<body>
    <form method="post">
        <h1>Trocar senha</h1>

            <?php 
                if(isset($erro_geral)){?>
                    <div class="erro-geral animate__animated animate__bounce">
                        <?php echo $erro_geral; ?>
                    </div>
            <?php } ?>            
        
        

        <div class="input-group">
            <img class="input-icon" src="img/senha2.png">
            <input type="password" <?php if(isset($erro_geral) or isset($erro_senha)){echo 'class="erro-input"';} ?> 
            name="senha" placeholder="Digite uma nova senha" <?php if(isset($_POST['repete_senha'])){ echo "value='".$_POST['senha']."'";}?> required>
            <?php if(isset($erro_senha)){ ?> 
                <div class="erro"><?php echo $erro_senha; ?></div>
            <?php } ?>
        </div>

        <div class="input-group">
            <img class="input-icon" src="img/senha2.png">
            <input type="password" <?php if(isset($erro_geral) or isset($erro_repete_senha)){echo 'class="erro-input"';} ?>  
            name="repete_senha" placeholder="Repita a senha" <?php if(isset($_POST['repete_senha'])){ echo "value='".$_POST['repete_senha']."'";}?> required>
            <?php if(isset($erro_repete_senha)){ ?> 
                <div class="erro"><?php echo $erro_repete_senha; ?></div>
            <?php } ?>
        </div>        
               
        <button class="btn-blue" type="submit">Enviar</button>       
        
        <div><br></div>   
        
    </form>    
</body>
</html>