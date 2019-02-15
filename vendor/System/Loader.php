<?php

namespace System;

class Loader
{
	private $app;

	public function __construct(Application $app)
	{
		$this->app = $app;
	}
}