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
		$file = strpos($class, 'App') === 0 ? $this->file->to($class . '.php') : $this->file->toVendor($class . '.php');
		
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
		if (!$this->isSharing($key)) {
			if ($this->isCoreAliases($key)) {
				$this->share($key, $this->createNewObjectCore($key));
			} else {
				die($key . ' not found in application container');
			}
		}

		return $this->container[$key];
	}

	/*
	* Determinae if the given key is setup
	*
	* @return bool
	* @param string $key
	*/
	public function isSharing($key)
	{
		return isset($this->container[$key]);
	}

	/*
	* Determine if the given alias to core class
	*
	* @param string $alias
	* @return bool
	*/
	private function isCoreAliases($alias)
	{
		$coreClasses = $this->coreClasses();
		return isset($coreClasses[$alias]);
	}

	/*
	* Create new instance of object from core classes
	*
	* @param string key
	* @return object
	*/
	private function createNewObjectCore(string $key)
	{
		$coreClasses = $this->coreClasses();
		$object = $coreClasses[$key];
		return new $object($this);	
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

	/*
	* Get all core with aliases
	*
	* @return array associative
	*/

	private function coreClasses()
	{
		return [
			'request' 	=> 'System\\Http\\Request',
			'response' 	=> 'System\\Http\\Response',
			'session' 	=> 'System\\Session',
			'cookie'	=> 'System\\Cookie',
			'load'		=> 'System\\Loader',
			'html'		=> 'System\\Html',
			'db'		=> 'System\\Database',
			'view'		=> 'System\\View\\ViewFactory'
		];
	}
}