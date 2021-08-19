<?php

namespace App\Models;

use MF\Model\Model;

class Tweet extends Model
{
    private $id;
    private $id_usuario;
    private $tweet;
    private $data;

    public function __get($attribute)
    {
        return $this->$attribute;
    }

    public function __set($attribute, $value)
    {
        $this->$attribute = $value;
    }

    // save tweets
    public function save()
    {
        $id_usuario = $this->__get('id_usuario');
        $tweet = $this->__get('tweet');

        $sql = "INSERT INTO tweets (id_usuario, tweet) VALUES (:ID_USUARIO, :TWEET)";
        $conn = $this->db;
        $stmt= $conn->prepare($sql);
        $stmt->bindParam(':ID_USUARIO', $id_usuario);
        $stmt->bindParam(':TWEET', $tweet);
        $stmt->execute();
        
        return $this; // retorna o tweet
    }

    public function delete()
    {
        $id = $this->__get('id');
        $id_usuario = $this->__get('id_usuario');
        
        $sql = "DELETE FROM tweets WHERE id = :ID and id_usuario = :ID_USUARIO";
        $conn = $this->db;
        $stmt= $conn->prepare($sql);
        $stmt->bindParam(':ID', $id);
        $stmt->bindParam(':ID_USUARIO', $id_usuario);
        $stmt->execute();
        
        return $this; // retorna o tweet
    }

    /**
     * Faz a primeira consulta relacionado ao usuario logado ou(OR) realiza a segunda seleção
     * 1º Retorna os tweets formatados no padrão de hora e data da Amercia do Sul
     * 2º Retorna os tweets dos usuarios adicionados pelo usuario logado
     */
    public function getAll()
    {
        $id_usuario = $this->__get('id_usuario');
        $sql = "SELECT 
                    t.id, t.id_usuario, t.tweet, u.nome, DATE_FORMAT(t.data, '%d/%m/%Y %H:%i') as data 
                FROM 
                    tweets as t
                    LEFT JOIN usuarios as u on (t.id_usuario = u.id)
                WHERE 
                    t.id_usuario = :ID_USUARIO
                    or t.id_usuario in 
                        (SELECT id_usuario_seguindo 
                         FROM usuarios_seguidores 
                         WHERE id_usuario = :ID_USUARIO
                        )
                ORDER BY 
                    t.data DESC";
                    
        $conn = $this->db;
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ID_USUARIO', $id_usuario);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getIdTweets()
    {
        $id_usuario = $this->__get('id_usuario');
        $sql = "SELECT 
                    t.id, t.id_usuario
                FROM 
                    tweets as t
                    LEFT JOIN usuarios as u on (t.id_usuario = u.id)
                WHERE 
                    t.id_usuario = :ID_USUARIO
                    or t.id_usuario in 
                        (SELECT id_usuario_seguindo 
                         FROM usuarios_seguidores 
                         WHERE id_usuario = :ID_USUARIO
                        )
                ORDER BY 
                    t.data DESC";
                    
        $conn = $this->db;
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ID_USUARIO', $id_usuario);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    // recuperar o Total de Tweets
    public function getTotalRegistros()
    {
        $id_usuario = $this->__get('id_usuario');
        $sql = "SELECT 
                    count(*) as total   
                FROM 
                    tweets as t
                    LEFT JOIN usuarios as u on (t.id_usuario = u.id)
                WHERE  
                    t.id_usuario = :ID_USUARIO
                    or t.id_usuario in 
                        (SELECT id_usuario_seguindo 
                         FROM usuarios_seguidores 
                         WHERE id_usuario = :ID_USUARIO
                        )";
         
                  
        $conn = $this->db;
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ID_USUARIO', $id_usuario);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // recupera os tweets limitando a busca em até 10 resultados
    public function getPorPagina($limit, $offset)
    {
        $id_usuario = $this->__get('id_usuario');
        $sql = "SELECT 
                    t.id, t.id_usuario, t.tweet, u.nome, DATE_FORMAT(t.data, '%d/%m/%Y %H:%i') as data 
                FROM 
                    tweets as t
                    LEFT JOIN usuarios as u on (t.id_usuario = u.id)
                WHERE 
                    t.id_usuario = :ID_USUARIO
                    or t.id_usuario in 
                        (SELECT id_usuario_seguindo 
                         FROM usuarios_seguidores 
                         WHERE id_usuario = :ID_USUARIO
                        )
                ORDER BY 
                    t.data DESC
                LIMIT
                    $limit
                OFFSET
                    $offset
                ";
                
                    
        $conn = $this->db;
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ID_USUARIO', $id_usuario);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}