<?php

namespace Tyea\RedLog;

use Illuminate\Support\ServiceProvider;

class RedLogServiceProvider extends ServiceProvider
{
	public function boot()
	{
		$this->commands([
			"Tyea\\RedLog\\LogTableCommand",
			"Tyea\\RedLog\\LogClearCommand"
		]);
	}
}
