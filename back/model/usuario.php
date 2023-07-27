<?php

use \Connection\Conexao;

class Usuario{


    public function createUser($dado, $perfil_compra = 0)
    {
        $retorno    = [];
        $conn       = Conexao::getInstanceWrite();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $senha_raw  = $dado->password;
        $senha      = md5($dado->password);

        $checkUserExist = (object)$this->verifyStudent($dado->email);

        if($checkUserExist->status){
        try {

            $data = $conn->prepare("    INSERT INTO `db_usuario`
                                        ( `usuario_login`, `usuario_senha`)
                                        VALUES
                                        ( :usuario_login , :usuario_senha);");

            $data->bindValue(":usuario_login",  $dado->login,   PDO::PARAM_STR);
            $data->bindValue(":usuario_senha",  $senha,         PDO::PARAM_STR);

            $data->execute();
            $id_usuario = $conn->lastInsertId();

            if ($id_usuario > 0) {

                $retorno['status'] = TRUE;
                $retorno['resultado'] = ['id' => $id_usuario];
                $data = ['p' => $senha_raw, 'l' => $dado->login];
                $retorno['data'] = $data;
            } else {

                $retorno['status'] = FALSE;
                $retorno['error'] = "Este Login,Usuário ou email já está cadastrado";
            }
        } catch (\Throwable $th) {
            $retorno = array(
                "status" => FALSE,
                "erro" =>  $th,
                "text" => $th
            );
        }
    }else{
        $retorno['status'] = FALSE;
        $retorno['erro'] = 'Já existe um usuário cadastrado com este e_mail!';
    }
        return $retorno;
    }

    public function verifyStudent($userEmail){
        $retorno = [];

        try{

            $conn= Conexao::getInstanceWrite();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $data = $conn->prepare("SELECT * from db_usuario WHERE usuario_login = :userEmail");

            $data->bindValue(':userEmail' , $userEmail, PDO::PARAM_STR);
            $data->execute();

            if($data->rowCount() > 0){
                $retorno['status'] = FALSE;
                $retorno['resultado'] = 'DADOS JA EXISTEM';
            }
            else{
                $retorno['status'] = TRUE;
            }

        }catch(Exception $e){
            $retorno['status'] = FALSE;
            $retorno['erro'] = $e;
        }
        return $retorno;
    }

    public function updateUsuario($dado)
    {

        $retorno = [];
        try {

            $conn = Conexao::getInstanceWrite();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($dado->password != '') {
                $resposta = $this->updateSenhaById($dado->id, $dado->password);
            }

            if (isset($dado->image)) {
                $imagem = $dado->image;
            }
            if (isset($dado->cpf)) {
                $cpf = $dado->cpf;
            }
            if (isset($dado->class)) {
                $class = " `id_turma` = :class,";
            }

            $data = $conn->prepare("    UPDATE `db_usuario`
                                        SET  
                                        `usuario_login` = :usuario_login ,
                                        WHERE `id_usuario` = :id_usuario ");

            $data->bindValue(':usuario_login', $dado->login, PDO::PARAM_STR);
            $data->bindValue(':id_usuario',     $dado->id,  PDO::PARAM_INT);

            if ($data->execute()) {
                $retorno['status'] = TRUE;
                $retorno['resultado'] = "Usuario alterado! " . $resposta;
            } else {
                $retorno['status'] = FALSE;
                $retorno['resultado'] = "Usuario Nao alterado! " . $resposta;
            }
        } catch (PDOException $e) {
            $retorno['status'] = FALSE;
            $retorno['erro'] = "ERROR: " . $e->getMessage();
        }
        return $retorno;
    }

    public function updateSenhaById($id_usuario, $senha)
    {
        $retorno = [];
        $resposta = '';
        try {
            if ($id_usuario != "" && $senha != "") {
                $senha =  md5($senha);
                $conn = Conexao::getInstanceWrite();
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $data = $conn->prepare("    UPDATE `db_usuario`
                                            SET   usuario_senha = :usuario_senha 
                                            WHERE id_usuario = :id_usuario ");

                $data->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $data->bindValue(':usuario_senha', $senha, PDO::PARAM_STR);
                $data->execute();
                $resposta = "Usuario alterado!";

                $retorno['status'] = TRUE;
                $retorno['resultado'] = $resposta;
            }
        } catch (PDOException $e) {
            $retorno['status'] = FALSE;
            $retorno['erro'] = "ERROR: " . $e->getMessage();
        }
        return $retorno;
    }

    public function deleteUsuario($id_usuario)
    {
        $retorno = [];

        try {

            $conn = Conexao::getInstanceWrite();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $data = $conn->prepare("   DELETE FROM `db_usuario` 
                                        WHERE id_usuario = :id_usuario ;");

            $data->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $data->execute();

            if ($data->rowCount() > 0) {

                $retorno['status'] = TRUE;
                $retorno['resultado'] =  "Deletado com SUCESSO";
            } else {
                $retorno['status'] = FALSE;
                $retorno['resultado'] = "Nenhum resultado ";
            }
        } catch (PDOException $e) {
            $retorno['status'] = FALSE;
            $retorno['erro'] =  "ERROR: " . $e->getMessage();
        }

        return $retorno;
    }

    public function Login($user)
    {
        $retorno = [];
        $pass = md5($user->password);
        try {

            $conn = Conexao::getInstanceWrite();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $data = $conn->prepare("SELECT * from db_usuario WHERE usuario_login = :userLogin");

            $data->bindValue(':userLogin', $user->login, PDO::PARAM_INT);
            $data->execute();

            if ($data->rowCount() > 0) {

                $dados = $data->fetch(PDO::FETCH_OBJ);

                if($pass == $dados->usuario_senha){
                    $retorno['status'] = TRUE;
                    $retorno['resultado'] = 'sucess';
                }
                
            } else {
                $retorno['status'] = FALSE;
                $retorno['resultado'] = "Nenhum resultado ";
            }
        } catch (PDOException $e) {
            $retorno['status'] = FALSE;
            $retorno['erro'] =  "ERROR: " . $e->getMessage();
        }

        return $retorno;
    }
}