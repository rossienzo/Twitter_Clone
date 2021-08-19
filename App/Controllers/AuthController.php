<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class authController extends Action
{
    public function autenticar()
    {
        $user = Container::getModels('Usuario');

        $user->__set('email', $_POST['email']);
        $user->__set('senha', md5($_POST['senha'])); // verifica se a senha md5 é a mesma no banco
       
        $result = $user->autenticar();
        
        if ($user->__get('id') != '' && $user->__get('nome'))
        {
            // inicia a sessão
            session_start();

            $_SESSION['id'] = $user->__get('id');
            $_SESSION['nome'] = $user->__get('nome');

            header('Location: /timeline');
        }
        else
        {
            header('Location: /?login=erro');
        }
    }
}