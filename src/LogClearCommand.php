<?php

namespace Tyea\RedLog;

use Illuminate\Console\Command;
use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LogClearCommand extends Command
{
	protected $signature = "log:clear {days=14}";
	
	protected $description = "Flush the logs database table";
	
	public function handle()
	{    	
		$days = $this->argument("days");
		$validator = Validator::make(
			["days" => $days],
			["days" => "required|integer|between:1,365"]
		);
		if ($validator->fails()) {
			$this->line("<error>The \"days\" argument is invalid</error>");
			return 1;
		}
		$past = new DateTime("now - " . Str::replaceFirst("+", "", $days) . " days");
		$table = Config::get("logging.channels.database.table");
		DB::table($table)->where("logged_at", "<", $past)->delete();
		$this->info("Logs database table cleared!");
		return 0;
	}
}
