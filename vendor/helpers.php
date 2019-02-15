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

if (! function_exists('array_get')) {
	/**
	* Get value from array if the key found otherwise
	* get default value
	* 
	* @param array $array
	* @param string $key
	* @param mixed $default
	* @return void
	*/
	function array_get(array $array, string $key, $default = null) {
		return isset($array[$key]) ? $array[$key] : $default;
	}
}