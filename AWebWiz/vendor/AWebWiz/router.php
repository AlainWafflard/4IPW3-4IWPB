<?php

use Config\App;

class Router
{
	public static function route($page, $header)
	{
		// Convertir en nom de classe (ex: "home" -> "Home")
		//		$className = ucfirst($page);
		$controllerClassName = 'Controller\\' . ucfirst($page);

		// Chemin vers le fichier de la classe
		// $filePath = __DIR__ . "/Controllers/{$className}.php";

		// Vérifier si le fichier existe : temporary dropped
		// if (file_exists($filePath))
		if (true)
		{
			// Vérifier si la classe existe
			if (class_exists($controllerClassName))
			{
				// Vérifier si la méthode statique `main()` existe
				if (method_exists($controllerClassName, 'main'))
				{
					// Appeler la méthode statique
					$out = $controllerClassName::main();
					$success = true;
				}
				else
				{
					$out = "La méthode statique main() n'existe pas dans la classe {$controllerClassName}.";
					$success = false;
				}
			}
			else
			{
				$out = "La classe {$controllerClassName} n'existe pas.";
				$success = false;
			}
		}
		else
		{
			// Page non trouvée : appeler une classe statique "NotFound"
			// require_once __DIR__ . "/Controllers/NotFound.php";  TO DO
			if (class_exists('NotFound'))
			{
				NotFound::main();
			}
			else
			{
				$out = "Page non trouvée.";
			}
		}

		// formatter et retourner la réponse (HTML ou JSON)
		switch ($header):
			case 'application/json' :
				if($success)
				{
					$response = [
						'success' => true,  // ou false en cas d'erreur
						'data' => $out,  // données en cas de succès
						'error' => null   // message d'erreur en cas d'échec
					];
				}
				else
				{
					$response = [
						'success' => false,  // ou false en cas d'erreur
						'data' => null,  // données en cas de succès
						'error' => $out,   // message d'erreur en cas d'échec
					];
				}
				break;
				$out = json_encode($response);

			case 'text/html; charset=UTF-8' :
				break;

		endswitch;

		return $out;
	}

	/**
	 * include all MVC PHP files
	 */
	public static function include_mvc_php_files()
	{
		// include all PHP files
		foreach ( array( 'model', 'view', 'controller') as $dir )
		{
			$file_a = scandir(App::ROOT_DIR.$dir);

			foreach ( $file_a as $file)
			{
				if( substr( $file, -4, 4 ) != ".php" ) continue;
				// echo($file."\n");
				require_once( App::ROOT_DIR.$dir.DIRECTORY_SEPARATOR.$file );
			}
		}

	}


}