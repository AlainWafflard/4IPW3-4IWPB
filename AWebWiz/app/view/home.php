<?php

namespace View;

class Home {

	/**
	 * build <body>
	 * @param $user
	 * @param $role
	 */
	public static function body():string
	{
		ob_start();
		?>
      <section>
          <h2>
              HOME
          </h2>
          <p>
              Ceci est la home page.
          </p>
      </section>
		<?php
		return ob_get_clean();
	}

}


