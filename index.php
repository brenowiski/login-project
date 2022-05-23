<?php
require('config/conexao.php');

if(isset($_POST['email']) && isset($_POST['senha']) && !empty($_POST['email']) && !empty($_POST['senha'])){ 
    // RECEBER OS DADOS VINDOS DO POST E LIMPAR
    $email = limparPost($_POST['email']);
    $senha = limparPost($_POST['senha']);
    $senha_cript = sha1($senha);


    // VERIFICAR SE EXISTE O USUARIO

    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email=? AND senha=? LIMIT 1");
    $sql->execute(array($email,$senha_cript));
    $usuario = $sql->fetch(PDO::FETCH_ASSOC); 
    if($usuario){
        //EXISTE O USUARIO
        //VERIFICAR SE O CADASTRO FOI CONFIRMADO   

        if($usuario['status'] == "confirmado"){
             //CRIAR TOKEN
        $token = sha1(uniqid().date('d-m-Y-H-i-s'));

        //ATUALIZAR TOKEN DO USUARIO NO BANCO
        $sql = $pdo->prepare("UPDATE usuarios SET token=? WHERE email=? AND senha=? ");
        if($sql->execute(array($token,$email,$senha_cript))){
            // ARMAZENAR TOKEN NA SESSÃO (SESSION)
            $_SESSION['TOKEN'] = $token;
            header('location: restrita.php');
        }         
    }else{
        $erro_login = "Por favor, confirme seu cadastro no email para fazer login!";
    }
}else{
    $erro_login = "Usuário ou senha incorretos!";
}
    
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
    <title>Login</title>
</head>
<body>
    <form method="post">
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
        <lottie-player src="https://assets9.lottiefiles.com/packages/lf20_wohcxlyr.json"  background="transparent"  speed="1"  style="width: 600px; height: 300px;"  loop  autoplay></lottie-player>
        <h1>Login</h1>

        <?php if (isset($_GET['result']) && $_GET['result'] == "ok"){?>
            <div class="sucesso animate__animated animate__rubberBand">
                Cadastrado com sucesso!
            </div>            
        <?php }?>       

        <?php 
            if(isset($erro_login)){ ?>
                <div style=text-align:center; class="erro-geral animate__animated animate__bounce">
                    <?php echo $erro_login; ?>
                    </div>
        <?php } ?>

        <div class="input-group">
            <img class="input-icon" src="img/conecte-se.png">
            <input type="email" name="email" placeholder="Digite seu email" required>
        </div>

        <div class="input-group">
            <img class="input-icon" src="img/senha.png">
            <input type="password" name="senha" placeholder="Digite sua senha" required>
        </div>     
        <div class="input-link"><a href="esqueci.php">Esqueceu a senha? </a></div>
        <button class="btn-blue" type="submit">Login</button>
        <div class="input-link"><a href="cadastrar.php">Não tenho cadastro</a></div>
    </form>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?php if (isset($_GET['result']) && $_GET['result'] == "ok"){?>   
    <script>
        setTimeout(() => {
                   window.location.replace("index.php");
        }, 3000);
    </script>
    <?php }?>
</body>
</html>
