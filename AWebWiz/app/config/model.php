<?php

namespace Config;

use Config\App;

class Model
{
	const DATABASE_TYPE = "MySql";  // "csv"
	const DATABASE_NAME = "4ipo3_2026";

	const MENU_DB =  'menu.csv'; // menu description

	const LOGIN_DB = 'login.csv'; // user description

	/**
	 * Méthode pour obtenir les paramètres de la base de données en fonction de MACHINE
	 */
	public static function getDatabaseConfig(): array
	{
		switch (App::MACHINE) {
			case "classe38":
				return [
					'DATABASE_PORT' => 3307,
					'DATABASE_USERNAME' => 'root',
					'DATABASE_PASSWORD' => '',
				];
			case "home":
			default:
				return [
					'DATABASE_PORT' => 3306,
					'DATABASE_USERNAME' => 'root',
					'DATABASE_PASSWORD' => 'root',
				];
		}
	}

	/**
	 * Méthode pour obtenir le DSN (Data Source Name)
	 */
	public static function getDsn(): string
	{
		$dbConfig = self::getDatabaseConfig();
		return "mysql:host=localhost;dbname=" . Model::DATABASE_NAME . ";port=" . $dbConfig['DATABASE_PORT'] . ";";
	}

}





