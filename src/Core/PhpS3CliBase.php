<?php namespace Hasibomi\PhpS3Cli\Core;

abstract class PhpS3CliBase {
	/**
	 * Abstract method that will be run by this class.
	 * 
	 * @param array $args
	 */
	abstract protected function run($args);

	private $args;
	protected $commands = ["help", "upload", "list"];
	protected $s3;

	/**
	 * PhpS3CliBase Constructor.
	 */
	public function __construct()
	{
		$this->s3 = new \Aws\S3\S3Client([
		    "region"  => $_ENV["S3_REGION"],
		    "version"  => $_ENV["S3_VERSION"]
		]);
		$this->args = $this->getArguments();
		$this->run($this->args);
	}

	/**
	 * Get arguments from the super global variable $argv.
	 *
	 * @return array
	 */
	private function getArguments()
	{
		array_shift($GLOBALS["argv"]);

		return $GLOBALS["argv"];
	}

	/**
	 * Colorize a text.
	 *
	 * @param $text
	 * @param $status
	 */
	protected function colorize($text, $status)
	{
		$out = "";

		switch ($status) {
			case "success":
				$out = "\033[0;32m";
				break;

			case "warning":
				$out = "\033[1;33m";
				break;

			case "failed":
				$out = "\033[0;31m";
				break;
			
			default:
				throw new Exception("Invalid status: {$status}");
		}

		echo chr(27) . "$out $text \n" . chr(27) . "[0m";
	}
}
