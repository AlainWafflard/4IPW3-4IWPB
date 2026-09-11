<?php

namespace Model;

use Config\App;
use Config\Model;
use Exception;

class Login
{
	/**
	 * valider() vérifie que le nom entré par l'utilisateur existe bien dans
	 * le fichier login.csv
	 * @param string $input nom entré par l'utilisateur
	 * @return array	[0] : true si existe, false si n'existe pas
	 * 								[1, 2] : details sur l'utilisateur
	 */
	public static function validate($input)
	{
		try
		{
			// lecture fichier
			$fh = fopen( App::DATABASE_DIR . Model::LOGIN_DB, 'r' );
			while( ! feof($fh) )
			{
				$ligne = fgets($fh);
				$user_info = explode( ';', trim($ligne) );

				if( $user_info[0] == $input )
				{
					// l'utilisateur a été identifié
					// $_SESSION['id'] = $user_info[0];
					// $_SESSION['role'] = $user_info[2];
					fclose($fh);
					return array( true, $user_info[0], $user_info[2] );
				}
			}
			// l'utilisateur n'a pas été identifié
			fclose($fh);
			return array( false, null, null );
		}
		catch( Exception $e)
		{
			echo "Problem while reading file login2.csv : " . $e->getMessage();
			return array( false, null, null );
		}
	}

}


?>