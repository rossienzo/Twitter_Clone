<?php

namespace App\Models;

use MF\Model\Model;
use PDOException;

class Usuario extends Model
{
    private $id;
    private $nome;
    private $email;
    private $senha;

    
    public function __get($attribute)
    {
        return $this->$attribute;
    }

    public function __set($attribute, $value)
    {
        $this->$attribute = $value;
    }

    // save
    public function save()
    {
        try
        {
            $nome = $this->__get('nome');
            $email = $this->__get('email');
            $senha = $this->__get('senha');
            $senha = md5($senha); //md5() -> hash 32 caracteres

            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:NOME, :EMAIL, :SENHA)";

            $conn = $this->db; // variavel protegida da classe Model
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':NOME', $nome);
            $stmt->bindParam(':EMAIL', $email);
            $stmt->bindParam(':SENHA', $senha);
            $stmt->execute();
            
            return $this; // Retorna true ou false
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    // register validate
    public function registerValidate()
    {
        $valid = TRUE;

        if(strlen($this->__get('nome')) < 3)
        {
            $valid = FALSE;
        }
        else if(strlen($this->__get('email')) < 6)
        {
            $valid = FALSE;
        }
        else if(strlen($this->__get('senha')) < 5)
        {
            $valid = FALSE;
        }

        return $valid;
    }

    // email user recovery
    public function userRecoveryEmail()
    {
      
        $sql = "SELECT nome, email from usuarios WHERE email = '" . $this->__get('email') . "'";
        $conn = $this->db;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // User login
    public function autenticar()
    {
        $email = $this->__get('email');
        $senha = $this->__get('senha');
        
        $sql = "SELECT id, nome, email FROM usuarios WHERE email = :EMAIL AND senha = :SENHA";
        $conn = $this->db;
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':EMAIL', $email);
        $stmt->bindParam(':SENHA', $senha);
        $stmt->execute();

        $user =  $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if($user['id'] != '' && $user['nome'] != '')
        {
            $this->__set('id', $user['id']);
            $this->__set('nome', $user['nome']);
        }

        return $this; // retorna o objeto user
    }

    public function getAll()
    {
        $nome = $this->__get('nome');
        $id = $this->__get('id');

        /**
         * Faz a primeira consulta retornando os dados de usuario e verifica
         * se existe a relação do usuario logado com o usuario seguido através da contagem de indices
         * 1º Retorna os dados pesquisados no pesquisarPor
         * 2º Retorna 1 para adicionado e 0 para não adicionado
         */
        $sql = "SELECT u.id, u.nome, u.email, 
                    ( SELECT count(*)
                      FROM usuarios_seguidores as us
                      WHERE us.id_usuario = :ID_USUARIO and us.id_usuario_seguindo = u.id
                    ) as seguindo_sn
                FROM usuarios as u
                WHERE u.nome like :NOME and u.id != :ID_USUARIO";

        $conn = $this->db;
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':NOME', '%' .  $nome . '%'); // like espera os caracters coringas(%)
        $stmt->bindValue(':ID_USUARIO', $id);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function seguirUsuario($id_usuario_seguindo)
    {
        $id = $this->__get('id');

        $sql = "INSERT INTO usuarios_seguidores (id_usuario, id_usuario_seguindo)
                VALUES (:ID_USUARIO, :ID_USUARIO_SEGUINDO)";

        $conn = $this->db;
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':ID_USUARIO', $id); 
        $stmt->bindValue(':ID_USUARIO_SEGUINDO', $id_usuario_seguindo);
        $stmt->execute();

        return TRUE;
    }

    public function deixarSeguirUsuario($id_usuario_seguindo)
    {
        $id = $this->__get('id');

        $sql = "DELETE FROM usuarios_seguidores 
        WHERE id_usuario = :ID_USUARIO and id_usuario_seguindo = :ID_USUARIO_SEGUINDO";
        $conn = $this->db;
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':ID_USUARIO', $id); 
        $stmt->bindValue(':ID_USUARIO_SEGUINDO', $id_usuario_seguindo);
        $stmt->execute();
    }

    public function getInfoUsuario()
    {
        $id = $this->__get('id');
        $sql = "SELECT nome FROM usuarios WHERE id = :ID_USUARIO";
        $conn = $this->db;
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':ID_USUARIO', $id); 
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getTotalTweets()
    {
        $id = $this->__get('id');
        $sql = "SELECT count(*) as total_tweet 
                FROM tweets 
                WHERE id_usuario = :ID_USUARIO";

        $conn = $this->db;
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':ID_USUARIO', $id); 
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getTotalSeguindo()
    {
        $id = $this->__get('id');
        $sql = "SELECT count(*) as total_seguindo 
                FROM usuarios_seguidores 
                WHERE id_usuario = :ID_USUARIO";

        $conn = $this->db;
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':ID_USUARIO', $id); 
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getTotalSeguidores()
    {
        $id = $this->__get('id');
        $sql = "SELECT count(*) as total_seguidores 
                FROM usuarios_seguidores 
                WHERE id_usuario_seguindo = :ID_USUARIO";

        $conn = $this->db;
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':ID_USUARIO', $id); 
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}