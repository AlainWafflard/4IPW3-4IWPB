<?php

// Controllers/NotFound.php
namespace Controller;

class NotFound
{
	public static function main()
	{
		header("HTTP/1.0 404 Not Found");
		echo "<h1>404 - Page non trouvée</h1>";
	}
}

