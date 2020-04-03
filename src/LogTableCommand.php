<?php

namespace Tyea\RedLog;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use DateTime;
use Illuminate\Support\Facades\Config;

class LogTableCommand extends Command
{
	protected $signature = "log:table";
	
	protected $description = "Create a migration for the logs database table";
	
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
		if (!file_put_contents($path, $contents)) {
			$this->error("Could not create migration");
			return 0;
		}
		$this->info("Migration created successfully!");
		return 1;
	}
}
