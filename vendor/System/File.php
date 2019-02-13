<?php

namespace System;

class File
{
	/*
	* Directory separator
	*
	* @const string
	*/
	const DS = DIRECTORY_SEPARATOR;

	/*
	* Root Path
	* 
	* return @var string
	*/
	private $root;

	/*
	* Constructor
	*
	* @param string $root
	*/
	public function __construct(string $root)
	{
		$this->root = $root;
	}

	/*
	* Determine wether the given file path exists
	*
	* @param string $file
	* return @var bool
	*/
	public function exists($file)
	{
		return file_exists($file);
	}

	/*
	* Require the given file path
	*
	* @param string $file
	* return @var void
	*/
	public function require(string $file)
	{
		require $file;
	}

	/*
	* Generate full path to the given path in vendor folder
	*
	* @param string $path
	* return @var string
	*/
	public function toVendor($path)
	{
		return $this->to('vendor/' . $path);
	}

	/*
	* Generate full to the given path
	*
	* @param string $path
	* return @var string
	*/
	public function to($path)
	{
		return $this->root . static::DS . str_replace(['/', '\\'], static::DS, $path);
	}
}