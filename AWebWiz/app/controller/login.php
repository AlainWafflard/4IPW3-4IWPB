<?php

namespace Controller;

//use \View\Login;

class Login
{
	public static function main():string
	{
		$action = @$_GET['action'] ?: "";
		$msg = '';
		$menu_a = \Model\Template::get_menu();

		//	if(isset($_POST['logout'] ))
		if( $action == 'logout' )
		{
			// l'utilisateur est en train de se délogguer
			// logout_print();
			session_unset();
			$msg = 'Vous êtes déloggué. ';
		}

		if( ! empty($_POST['identifier']))
		{
			// l'utilisateur est en train de s'identifier
			list( $valide, $_SESSION['id'], $_SESSION['role'] ) = \Model\Login::validate($_POST['identifier']);
			// si identification ratée
			if( ! $valide )
			{
				// unknown_user_print();
				session_unset();
				$msg = "Vous n'êtes pas identifié.";
			}
		}

		if(isset($_SESSION['id']))
		{
			// l'utilisateur est déjà identifié
			// plus besoin du composant login
			// => redirection vers home page
			print('mouchard');
			header("Location: .");
		}
		else
		{
			// l'utilisateur n'est pas identifié
			$msg .= \View\Login::unidentified_user();
		}

		return Helper::view([
			\View\Template::head($menu_a),
			\View\Login::open_form(),
			$msg,
			\View\Login::link_home(),
			\View\Login::close_form(),
			\View\Template::foot(),
		]);

	}

}

?>