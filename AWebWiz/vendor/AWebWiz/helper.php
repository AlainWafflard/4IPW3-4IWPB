<?php

class Helper
{
	/**
	 * main function for rendering : view())
	 * make and return HTMl code from input arguments
	 * @param array $html_a array of pieces of HTMl code
	 * @return string
	 */
	public static function view( $html_a=[] ):string
	{
		return join( "\n", $html_a );
	}

}
