<?php

if (! function_exists('pre')) {
	/*
	* Visualize the given variable
	*
	* @param mixed @var
	* @return void
	*/
	function pre($variable) {
		echo '<pre>';
		print_r($variable);
		echo '<pre>';
	}
}