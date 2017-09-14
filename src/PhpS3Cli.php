<?php namespace Hasibomi\PhpS3Cli;

use Hasibomi\PhpS3Cli\Core\PhpS3CliBase;
use Hasibomi\PhpS3Cli\Core\Retrieve;
use Hasibomi\PhpS3Cli\Core\Upload;

class PhpS3Cli extends PhpS3CliBase {
	/**
	 * This method will be called by default.
	 *
	 * @param array $args
	 */
	public function run($args)
	{
		$commands = implode("\n", $this->commands);

		$this->handleHelpErrors($args);

		switch ($args[0]) {
			case "upload":
				new Upload();
				break;

			case "list":
				if (isset($args[1]) && $args[1] === "bucket") {
					new Retrieve();
				} else {
					$this->colorize("Usage: ", "warning");
					$this->colorize(" vendor/bin/s3cli list <bucket>", "success");
				}
				break;
			
			default:
				$this->colorize("List of available commands are: ", "warning");
				$this->colorize(" {$commands}", "success");
				break;
		}
	}

	/**
	 * Handle help command & errors
	 *
	 * @param array $args
	 */
	private function handleHelpErrors($args) {
		$commands = implode("\n", $this->commands);

		if (count($args) === 0) {
			die("List of available commands are: \n{$commands} \n");
		}

		if (! in_array($args[0], $this->commands)) {
			die("No command found. List of available commands are: \n{$commands} \n");
		}
		
		if ($args[0] === "help") {
			if (count($args) === 2 && $args[1] === "upload") {
				$this->colorize("Usage: ", "warning");
				$this->colorize(" vendor/bin/s3cli upload --bucket=<bucketname> --dir=<local-directory>", "success");
				exit();
			} else {
				$this->colorize("Usage: ", "warning");
				$this->colorize(" vendor/bin/s3cli help <command> <options>", "success");
				exit();
			}

			$this->colorize("List of available commands are: ", "warning");
			$this->colorize(" {$commands}", "success");
		}
	}
}
