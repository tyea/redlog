<?php

namespace Tyea\RedLog;

use Monolog\Handler\AbstractProcessingHandler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class DatabaseHandler extends AbstractProcessingHandler
{
	protected function write(array $record): void
	{
		$table = Config::get("logging.database.table");
		DB::table($table)->insert([
			"hostname" => gethostname(),
			"message" => $record["formatted"],
			"logged_at" => $record["datetime"]
		]);
	}
}
