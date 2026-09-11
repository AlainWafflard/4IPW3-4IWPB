<?php

namespace Controller;

class Counter
{
	public static function main(): string
	{
		// model
		$menu_a = \Model\Template::get_menu();

		// view
		return \Helper::view([
			\View\Template::head( $menu_a, true ), // true = include vue.js libraries
			\View\Counter::fetch_sample(),
			\View\Counter::vuejs_fetch_sample(),
			\View\Template::foot(),
		]);
	}
}


class Counter_fetch
{
	/**
	 * Counter_fetch
	 * incrémente le compteur stocké en SESSION
	 * est appelée en mode asynchrone depuis FETCH,
	 * soit dans une simple page HTML
	 * soit dans un composant Vue.js
	 *
	 * Remarque : Seul le cas nominal est considéré, les cas alternatifs sont à développer.
   *
	 * @return JSON string
	 */
	public static function main(): string
	{
		/*return json_encode([
			'success' => true,  // ou false en cas d'erreur
			'data'    => [
				'cpt_val'	=> 30,
			],    // données en cas de succès
			'error'   => null   // message d'erreur en cas d'échec
		]);*/

		if(isset($_POST['vuejs']))
		{
			// appelé depuis framework vue.js
			$session_var = 'vuejs_cpt_val';
		}
		else
		{
			// appelé depuis simple page HTML
			$session_var = 'cpt_val';
		}

		// on récupère la valeur stockée
		// si non existante alors 0
		$cpt_val = @$_SESSION[$session_var] ?: 0 ;

		// get or increment
		switch($_POST['action']) {
			case "get" :
				break;
			case "set" :
				$cpt_val = $_POST['initialValue'];
				break;
			case "increment":
				$cpt_val++;
				break;
			case "decrement":
				$cpt_val--;
				break;
		}

		// on sauvegarde dans SESSION
		$_SESSION[$session_var] = $cpt_val;

		// on formatte la réponse à la requête
		$response = [
			'success' => true,  // ou false en cas d'erreur
			'data'    => [
				'cpt_val'	=> $cpt_val,
			],    // données en cas de succès
			'error'   => null   // message d'erreur en cas d'échec
		];

		return json_encode($response);
	}

}
