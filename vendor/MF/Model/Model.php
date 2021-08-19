<?php

namespace MF\Model;

/**
 * Modelo de classe de conexão com o BD
 */
abstract class Model
{
    protected $db;
    
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

}