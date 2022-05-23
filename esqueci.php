<?php
require('config/conexao.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
                        
require 'config/PHPMailer/src/Exception.php';
require 'config/PHPMailer/src/PHPMailer.php';
require 'config/PHPMailer/src/SMTP.php';


if(isset($_POST['email']) && !empty($_POST['email'])){
    $email = limparPost($_POST['email']);
    $status = "confirmado";
    // VERIFICAR SE EXISTE O USUARIO
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email=? AND status=? LIMIT 1");
    $sql->execute(array($email,$status));
    $usuario = $sql->fetch(PDO::FETCH_ASSOC); 
    if($usuario){
        //EXISTE USUARIO
        // ENVIAR EMAIL PARA USUARIO FAZER NOVA SENHA
        $mail = new PHPMailer(true);
        $cod = sha1(uniqid());
        
        //ATUALIZAR O CODIGO DE RECUPERACAO DO USUARIO NO BANCO
        $sql = $pdo->prepare("UPDATE usuarios SET recupera_senha=? WHERE email=?");
        if($sql->execute(array($cod,$email))){
            try {
                $mail->setFrom('sistema@pumpking.online', 'Pombo Correio');
                $mail->addAddress($email, $nome); 
                //Content
                $mail->isHTML(true); //CORPO DO EMAIL COMO HTML
                $mail->Subject = 'Recuperar senha'; //TITULO DO EMAIL
                $mail->Body    = '<h1>Click abaixo para recuperar a senha:</h1><a 
                style="background:red; color:white; text-decoration:none; padding:20px; border-radius:10px" 
                href="https://pumpking.online/login/recuperar-senha.php?cod='.$cod.'">Recuperar senha</a><br><br><p>Equipe Login em PHP</p>';
            
                $mail->send();
                header('location: email-enviado-recupera.php');
                } catch (Exception $e) {
                    echo "Houve um problema ao enviar email de confirmação: {$mail->ErrorInfo}";
                }
        } else{
    $erro_usuario = "Falha ao buscar e-mail. Por favor tente novamente!";
}
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
    <title>Esqueceu a senha</title>
</head>
<body>
    <form method="post">
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
        <lottie-player src="https://assets9.lottiefiles.com/packages/lf20_wohcxlyr.json"  background="transparent"  speed="1"  style="width: 600px; height: 300px;"  loop  autoplay></lottie-player>
        <h1>Recuperar senha</h1>

        <?php 
            if(isset($erro_usuario)){ ?>
                <div style=text-align:center; class="erro-geral animate__animated animate__bounce">
                    <?php echo $erro_login; ?>
                    </div>
        <?php } ?>

        <p> Digite o e-mail cadastrado no sistema</p>

      
        <div class="input-group">
            <img class="input-icon" src="img/conecte-se.png">
            <input type="email" name="email" placeholder="Digite seu email" required>
        </div>
         
        
        <button class="btn-blue" type="submit">Enviar</button>
        <div class="input-link"><a href="index.php">Voltar para login</a></div>
    </form>   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</body>
</html>
