<?php

namespace Tyea\RedLog;

use Illuminate\Console\Command;
use DateTime;
use Illuminate\Support\Facades\Validator;

class LogClearCommand extends Command
{
	protected $signature = "log:clear {days}";
	
	protected $description = "Flush the log database table";
	
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
		$past = new DateTime("now - " . $days . " days");
		$table = Config::get("logging.database.table");
		DB::table($table)->where("logged_at", "<", $past)->delete();
		return 0;
	}
}
