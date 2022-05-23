<?php

require('config/conexao.php');
?>
<?php 
    //VERIFICAÇÃO DE AUTENTICAÇÃO
    $user = auth($_SESSION['TOKEN']);
    if ($user){
        echo "<h1> SEJA BEM-VINDO <b style='color:red'>".$user['nome_completo']."!</b></h1>";   
        
    }else{
        header('location:index.php');
    }
    /*
    VERIFICAR SE TE AUTORIZAÇÃO
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE token=? LIMIT 1")
    $sql->execute(array($_SESSION['TOKEN']));
    $usuario = $sql->fetch(PDO::FETCH_ASSOC)
    //SE NÃO ENCONTRAR O USUÁRIO
    if(!$usuario){
        header('location:index.php');
    }else{
        echo "<h1> SEJA BEM-VINDO <b style='color:red'>".$usuario['nome_completo']."!</b></h1>";   echo "<br><br><a style='background:red; color:white; text-decoration:none; padding:20px; border-radius:10px' href='logout.php'>Sair</a>";
    */ 
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restrita</title>
    <link href="css/estilo.css" rel="stylesheet">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="restrira-body">
    
    <div class="restrira-container" > 
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <lottie-player src="https://assets6.lottiefiles.com/packages/lf20_lgsx862o.json"  background="transparent"  speed="1"  style="width: 900px; height: 500px;"  loop  autoplay></lottie-player>
    </div>
    
   
        <h1>Esta é a área restrita!</h1>
        <p class="p-restrita">Por enquanto tudo que você pode fazer é sair, é só clicar no botão:</p>
    
    <div><a class="sair-btn" href="logout.php">Sair</a></div>   

</body>
</html>





