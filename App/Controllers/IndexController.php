<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action
{

	public function index() 
	{	
		// Verifica se existe um parâmetro de login
		$this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
		
		$this->render('index');
	}

	public function inscreverse() 
	{
		$this->view->title = "| Inscrever-se";

		$this->view->usuario = array (
			'nome' => '',
			'email' => '',
			'senha' => ''
		);
		$this->view->erroCadastro = FALSE;

		$this->render('inscreverse');
	}

	public function registrar() 
	{	
		
		// recebe os dados do formulário
		$user = Container::getModels('Usuario');
		$user->__set('nome', $_POST['nome']);
		$user->__set('email', $_POST['email']);
		$user->__set('senha', $_POST['senha']); 

		if ($user->registerValidate() && count($user->userRecoveryEmail()) == 0)
		{
			$user->save();
			$this->render('cadastro');
		}
		else
		{
			$this->view->usuario = array (
				'nome' => $_POST['nome'],
				'email' => $_POST['email'],
				'senha' => $_POST['senha']
			);

			$this->view->erroCadastro = TRUE;
			
			$this->render('inscreverse');
		}

		// sucesso de registro

		// erro de registro



		$this->render('registrar');
	}
	
}


?>