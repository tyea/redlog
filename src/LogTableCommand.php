<?php

namespace Tyea\RedLog;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use DateTime;
use Illuminate\Support\Facades\Validator;

class LogTableCommand extends Command
{
	protected $signature = "log:table";
	
	protected $description = "Create a migration for the log database table";
	
	public function handle()
	{
		$table = Config::get("logging.channels.database.table");
		$now = (new DateTime("now"))->format("Y_m_d_His");
		$path = database_path() . "/migrations/" . $now . "_" . "create_" . $table . "_table.php";
		$class = "Create" . Str::studly($table) . "Table";
		$contents = str_replace(
			["{{ table }}", "{{ class }}"],
			[$table, $class],
			file_get_contents(__DIR__ . "/migration.php.example")
		);
		$success = file_put_contents($path, $contents);
		return !boolval($success);
	}
}
