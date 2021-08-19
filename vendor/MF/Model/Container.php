<?php

namespace MF\Model;

use App\Connection;

class Container 
{
    /*
    * Faz a instancia de um objeto e a conexão com o Banco de dados
    */
    public static function getModels($model)
    {
        $class = "\\App\\Models\\" . ucfirst($model);
        $conn = Connection::getDb();

        return new $class($conn);
    }
}