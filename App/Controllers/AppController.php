<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action
{
    public function timeline()
    {
        $this->view->title = "| Página Inicial";
        $this->authValidation();

        // recupera os tweets
        $tweet = Container::getModels('Tweet');
        $tweet->__set('id_usuario', $_SESSION['id']);

        /**
         * INICIO paginação
         */

        // variaveis de paginação
        $total_registros_pagina = 10; // se desloca até o 10º registro
        
        $pagina =  isset($_GET['pagina']) ? $_GET['pagina'] : 1; // define a pagina atual
        $deslocamento = ((int)$pagina - 1) * $total_registros_pagina; // recupera apatir do primeiro registro
        
            //getALl()
        $tweets = $tweet->getAll();

        $tweets = $tweet->getPorPagina($total_registros_pagina, $deslocamento);
        $total_tweets = $tweet->getTotalRegistros();

        // envia os dados de PAGINAÇÂO para a página phtml
        $this->view->total_de_paginas =  ceil($total_tweets['total'] / $total_registros_pagina); // ceil retorna o resultado arredondado para cima
        $this->view->pagina_ativa = (int) $pagina; // envia a pagina atual
   
        /**
         * FIM paginação
         */

        // envia os dados de TWEETS para a página phtml
        $this->view->tweets = $tweets;

        $user = Container::getModels('Usuario');
        $user->__set('id', $_SESSION['id']);

        $this->view->info_usuario = $user->getInfoUsuario();
        $this->view->total_tweets = $user->getTotalTweets();
        $this->view->total_seguindo = $user->getTotalSeguindo();
        $this->view->total_seguidores = $user->getTotalSeguidores();
        
        $this->render('timeline');
    }

    

    public function sair()
    {
        session_start();
        session_destroy();

        header('Location: /');
    }

    public function tweet()
    {

        $this->authValidation();

        $tweet = Container::getModels('Tweet');
        $tweet->__set('tweet', $_POST['tweet']);
        $tweet->__set('id_usuario', $_SESSION['id']); // o Id de usuario está salvo na sessão
        $tweet->save();

        header('Location: /timeline');
    }
    
    public function delete()
    {
        $this->authValidation();

        $tweet = Container::getModels('Tweet');
        $id_tweet = isset($_GET['id_tweet']) ? $_GET['id_tweet'] : '';
       
        $tweet->__set('id', $id_tweet);
        $tweet->__set('id_usuario', $_SESSION['id']); // o Id de usuario está salvo na sessão
        $tweet->delete();
       
        header('Location: /timeline');
    }

    public function quemSeguir()
    {
        $this->authValidation();

        $this->view->title = "| Quem Seguir";

        $pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';

        $users = array(); // define users como vazio

        $user =  Container::getModels('Usuario');
        $user->__set('id', $_SESSION['id']);

        if($pesquisarPor != '')
        {
            
            $user->__set('nome', $pesquisarPor);
           
            $users = $user->getAll();
           
        }

        $this->view->users = $users;

        $this->view->info_usuario = $user->getInfoUsuario();
        $this->view->total_tweets = $user->getTotalTweets();
        $this->view->total_seguindo = $user->getTotalSeguindo();
        $this->view->total_seguidores = $user->getTotalSeguidores();

        $this->render('quemSeguir');
    }

    public function acao()
    {
        $this->authValidation();

        //acao
        $acao = isset($_GET['acao']) ? $_GET['acao'] : '';
        $id_usuario_seguindo = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';

        $user = Container::getModels('Usuario');
        $user->__set('id', $_SESSION['id']);

        if ($acao == 'seguir')
        {
            $user->seguirUsuario($id_usuario_seguindo);
        }
        else if ($acao == 'deixar_de_seguir')
        {
            $user->deixarSeguirUsuario($id_usuario_seguindo);

        }
        
        header('Location: /quem_seguir?pesquisarPor=');
        
    }

    // valida se o usuario está autenticado
    public function authValidation()
    {
        session_start();
        if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') 
        {
			header('Location: /');
		}	
    }

}