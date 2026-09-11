<?php

namespace Controller;

class Home
{

	public static function main():string
	{
		// model
		$menu_a = \Model\Template::get_menu();

		// view
		return \Helper::view([
			\View\Template::head($menu_a),
			\View\Home::body(),
			\View\Template::foot(),
		]);

	}

}


