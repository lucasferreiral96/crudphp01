<?php

class pessoa{

private $pdo;
public function __construct($dbname, $host, $user, $senha){

    try{

        $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host, $user, $senha);
        // echo "Passou!!";

    } catch (PDOException $e){

        echo "erro de conexão: " . $e->getMessage();
    } catch (PDOException $err){
        echo "Erro generico ".$err->getMessage();
    }


}

public function buscar(){
    $validar = array();
    $cmd = $this->pdo->query("SELECT * FROM dados ORDER BY id DESC");
    $validar = $cmd->fetchAll(PDO::FETCH_ASSOC);
    return $validar;
}

public function cadastrar($mUsuario, $mEmail, $mSenha){

    $cmd = $this->pdo->prepare("SELECT id FROM `dados` WHERE email = :email");
    $cmd->bindValue(":email", $mEmail);
    $cmd->execute();

    if($cmd->rowCount() > 0){
        return false;
        echo "E-mail ja cadastrado";
    }else{
    $cmd = $this->pdo->prepare("INSERT INTO `dados`(usuario, email, senha) VALUES (:usuario, :email, :senha)");
        $cmd->bindValue(':usuario', $mUsuario);
        $cmd->bindValue(':email', $mEmail);
        $cmd->bindValue(':senha', $mSenha);
        $cmd->execute();

        return true;
    }
}

public function excluir($id){

    $cmd = $this->pdo->prepare("DELETE FROM dados WHERE id = :id");
    $cmd->bindValue(":id", $id);
    $cmd->execute();
}

public function pEsp($id){
    $idRes = array();

$cmd = $this->pdo->prepare("SELECT * FROM dados WHERE id = :id");
$cmd->bindValue(":id", $id);
$cmd->execute();

$idRes = $cmd->fetch(PDO::FETCH_ASSOC);
return $idRes;

}

public function atualizar($id, $mUsuario, $mEmail, $mSenha){

        $cmd = $this->pdo->prepare("UPDATE dados SET usuario = :usr, email = :email, senha = :pass WHERE id = :id");
        $cmd->bindValue(":usr", $mUsuario);
        $cmd->bindValue(":email", $mEmail);
        $cmd->bindValue(":pass", $mSenha);
        $cmd->bindValue(":id", $id);
        $cmd->execute();

        return true;
        
    // }

}


}


?>