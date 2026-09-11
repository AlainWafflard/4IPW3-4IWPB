<?php

namespace View;

use Config\App;

class Template {

    /**
     * header de chaque page
     */
	public static function head($menu_a=[], $include_vuejs_b=false ):string
	{
		$debug = false;

		// on génère le code html du menu, à partir de $menu_a
        $menu_s = '<ul class="menu">';
        $menu_s .= array_reduce(
            $menu_a,
            function ($carry, $menu_item)
            {
                $visual = $menu_item[0];
                $comp = $menu_item[1];
                $subcomp = $menu_item[2] ?? '';
                return $carry . <<<HTML
                    <li>
                        <a href="?page=$comp&subpage=$subcomp">
                            $visual
                        </a>
                    </li>
                HTML;
            },
            ''
        );
        $menu_s .= '</ul>';

		ob_start();
		?>
      <html lang="fr">
      <head>
        <title>AWebWiz Template (MVC)</title>
        <link rel="stylesheet" href="./vendor/bootstrap/bootstrap.min.css" />  <!-- lib externe -->
        <link rel="stylesheet" href="./assets/css/main.css" /> <!-- lib interne / perso -->
        <link rel="icon" href="./assets/media/press16x16.ico" type="image/x-icon">

        <?php if( $include_vuejs_b) : ?>
          <!-- custom vanilla javascript -->
          <script type="application/javascript" src="./assets/js/counter.js"></script>

          <!-- Vue.js components  -->
          <script type="importmap">
              {
                "imports": {
                    "vue" : "./vendor/vuejs/vue.esm-browser.js"
                }
              }
          </script>
          <script type="module" src="./assets/components/app.js"></script>
        <?php endif; ?>
      </head>
      <body>
      <header>
          <h1>
              Mon site de presse (MVC)
              <img src="./assets/media/press.png">
          </h1>
				<?=$menu_s?>
      </header>
		<?php

		if($debug)
		{
			var_dump($_COOKIE);
			var_dump($_SESSION);
			var_dump($_GET);
			var_dump($_POST);
		}
		return ob_get_clean();
	}

	/**
	 * footer de chaque page
	 */
	public static function foot():string
	{
		ob_start();
		?>
      <hr />
      <footer>
          Made with the amazing AWebWiz framework
          <img src="./assets/media/awebwiz66x50.png" alt="AWebWiz logo">
          version <?=App::AWEBWIZ_VERSION?>
      </footer>
      </body>
      </html>
		<?php
		return ob_get_clean();
	}

}


