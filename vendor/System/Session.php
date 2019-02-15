<?php


namespace System;

class Session
{
	/**
	* Set the object class Application
	*
	* @var object
	*/
	private $app;

	/*
	* Constructor inject the container Application
	*
	* @param \System\Application $app
	*/
	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	/**
	* Start the session
	*
	* @return void
	*/
	public function start()
	{
		ini_set('session.use_only_cookies', 1);
		session_id();

		if (!session_id()) {
			session_start();
		}
	}

	/**
	* Set the new Session
	*
	* @param string $key, mixed $value
	* @return void
	*/
	public function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	/**
	* Determine if the session has the given key
	*
	* @param string $key
	* @return bool
	*/
	public function has($key)
	{
		return isset($_SESSION[$key]);
	}

	/**
	* Remove session by the given key
	*
	* @param string $key
	* @return void
	*/
	public function remove($key)
	{
		unset($_SESSION[$key]);
	}

	/**
	* Get session by the given key 
	*
	* @param string $key
	* @param mixed $default
	* @return mixed
	*/
	public function get($key, $default = null)
	{
		return array_get($_SESSION, $key, $default);
	}

	/**
	* Get all the sessions data
	*
	* @return array
	*/
	public function all()
	{
		return $_SESSION;
	}

	/**
	* Get the session and then destroy the session
	*
	* @param string $key
	* @return void
	*/
	public function pull($key)
	{
		$value = $this->get($key);
		$this->remove($key);
		return $value;
	}

	/**
	* Destroy all the sesssions
	*
	* @return void
	*/
	public function destroy()
	{
		session_destroy();
		unset($_SESSION);
	}
}