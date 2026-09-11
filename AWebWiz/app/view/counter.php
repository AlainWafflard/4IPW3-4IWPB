<?php

namespace View;

class Counter
{

	/**
	 * build a counter as a FETCH sample
	 */
	public static function fetch_sample():string
	{
		ob_start();
		?>
		<section id="html_fetch_sample">
			Ceci est un compteur utilisant une requête FETCH.<br>
			La valeur du compteur est stockée sur le serveur en variable SESSION.<br>
			<button type="button" id="b_compteur">Comptons !</button>
			<span class="compteur">compteur : <span id="compteur">0</span></span><br>
            <div class="erreur" id="fetch_error"></div>
		</section>
		<?php
		return ob_get_clean();
	}


	/**
	 * build a counter as a FETCH sample, integrated in vue.js framework
	 */
	public static function vuejs_fetch_sample():string
	{
		ob_start();
		?>
		<section id="vuejs_fetch_sample">
			<counter></counter>
		</section>
		<?php
		return ob_get_clean();
	}

}