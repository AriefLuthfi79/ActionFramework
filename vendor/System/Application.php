<?php

namespace System;

class Application
{
	/*
	* Container
	*
	* @var array associative $container
	*/
	private $container = [];

	/*
	* Constructor
	*
	* @params System\File $file
	*/
	public function __construct(File $file)
	{
		$this->share('file', $file);
		$this->registerClasses();
		$this->loadHelpers();
	}

	/*
	* Share the given key|value Through Application
	*
	* @param string $key
	* @param mixed $value
	* @return mixed
	*/
	public function share($key, $value)
	{
		$this->container[$key] = $value;
	}

	/*
	* Get shared value dynamically
	*
	* @param string $key
	* @return mixed
	*/
	public function __get($key)
	{
		return $this->get($key);
	}

	/*
	* Load classes through autoloading implementation
	*
	* @param string $class
	* @return void
	*/
	public function load($class)
	{
		if (strpos($class, 'App') === 0) {
			$file = $this->file->to($class . '.php');
		} else {
			// get the class from vendor directory
			$file = $this->file->toVendor($class . '.php');
		}
		
		if ($this->file->exists($file)) {
			$this->file->require($file);
		}
	}

	/*
	* Get shared value
	*
	* @param string $key
	* @return mixed
	*/
	public function get($key)
	{
		return isset($this->container[$key]) ? $this->container[$key] : null;
	}

	/*
	* Register classes in spl_autoload_register and bundled
	*
	* @return void
	*/
	private function registerClasses()
	{
		spl_autoload_register([$this, 'load']);
	}

	/*
	* Load the helpers in vendor directory
	*
	* return @var void
	*/
	private function loadHelpers()
	{
		return $this->file->require($this->file->toVendor('helpers.php'));
	}
}