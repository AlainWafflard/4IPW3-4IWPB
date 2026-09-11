<?php

namespace Model;

use Config\App;
use Config\Model;

class Template
{
	public static function get_menu()
	{
		// Récupère le contenu du fichier menu.csv
		$menuContent  = file_get_contents( App::DATABASE_DIR . Model::MENU_DB);

		// Supprime les lignes vides et divise en lignes
		$menuLines = array_filter(explode("\n", $menuContent ));

		// Transform chaque ligne en tableau associatif
		$menu = array_map(
			fn($line) => explode('|', trim($line)),
			$menuLines
		);

		// var_dump($menu);
		return $menu;
	}

}

