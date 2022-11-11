<?php
require_once("pessoa.php");


$conn = new pessoa("crud_01","localhost","root", "");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>

<?php

$sucesso = array();
$erros = array();
$avisos = array();

if(isset($_POST['enviar'])){


    if(isset($_GET['up_id']) && !empty($_GET['up_id'])){

        $upid = addslashes($_GET['up_id']);
        $mUsuario = addslashes($_POST['usuario']);
        $mEmail = addslashes($_POST['email']);
        $mSenha = addslashes($_POST['senha']);
    
        if(!empty($mUsuario) && !empty($mEmail) && !empty($mSenha)){
    
    
            $conn->atualizar($upid, $mUsuario, $mEmail, $mSenha);
                header("location: index.php");
    
        }else{
            $avisos = "<div class='todoscampos'><h4>Preencha todos os campos!</h4></div>";          
        
        }


    }else{

        $mUsuario = addslashes($_POST['usuario']);
        $mEmail = addslashes($_POST['email']);
        $mSenha = addslashes($_POST['senha']);
    
        if(!empty($mUsuario) && !empty($mEmail) && !empty($mSenha)){
    
    
            if(!$conn->cadastrar($mUsuario, $mEmail, $mSenha)){

            ?>  
            <div class="emailexiste">

                <h4>O e-mail ja existe.</h4>
                </div> 
            <?php

}else{
          
          $sucesso = "<div class='foicadastrado'><h4>O usuario foi cadastrado</h4></div>";          
          
          ?>


<?php
            }
    
    
        }else{
            $sucesso = "<div class='todoscampos'><h4>Preencha todos os campos.</h4></div>";          
            ?>

            
        <?php
        }
    }


   


}

if(isset($_GET['up_id'])){
    $idupdate = addslashes($_GET['up_id']);
    $updated = $conn->pEsp($idupdate);
}
?>

    <section id="esquerda">
        <h2>Formulario de cadastro</h2>
        <form method="POST" action="">
        
        <label for="usuario">Usuário: </label>
        <input type="text" name="usuario" value="<?php if(isset($updated)){ 
            echo $updated['usuario'];        
        }
         ?>">
        <br>

        <label for="email">E-mail: </label>
        <input type="email" name="email" value="<?php if(isset($updated)){ 
            echo $updated['email'];        
        }
         ?>">
        <br>

        <label for="senha">Senha: </label>
        <input type="text" name="senha" value="<?php if(isset($updated)){ 
            echo $updated['senha'];        
        }
         ?>">
        <br>
        
        <input type="submit" name="enviar" id="enviar" value="<?php if(isset($updated)){
            echo "Atualizar dados";
            
        }else{
            echo "Cadastrar";
            
            
        }
        ?>">
        
        <?php if(!empty($sucesso)){echo $sucesso;}?>
    </form>
    <?php if(!empty($avisos)){echo $avisos;}?>
    </section>

    <section id="direita">

    <table>
            <tr id="hd">
                <td>Usuario</td>
                <td>E-mail</td>
                <td colspan="3">Senha</td>
            <!-- </tr> -->

    <?php

    $usuarios = $conn->buscar();
    // $recebe = count($usuarios);
        if(count($usuarios) > 0){

            for($i = 0; $i < count($usuarios); $i++){

                echo "<tr>";
                foreach($usuarios[$i] as $key => $value){


                    if($key != "id"){
                        echo "<td>" . $value . "</td>";
                    }
                    
                    
                }
                ?>
                
                <td>             
                <a href="index.php?up_id=<?php echo $usuarios[$i]['id'];?>">Editar</a><a href="index.php?id=<?php echo $usuarios[$i]['id'];?>">Excluir</a></td>
                <?php
                echo "</tr>";
            }
            
        }else{
            ?>
            <!--Aviso-->
            <div class="aviso">
               <h4>Não há usuarios cadastrados.</h4>
            </div>

            <?php
        }

    ?>
                
        </table>
    </section>
   


</body>
</html>

<?php

if(isset($_GET['id'])){

    $getId = addslashes($_GET['id']);
    $conn->excluir($getId);
    // $conn->execute();

    header("Location: index.php");
}


?>