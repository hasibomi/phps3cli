<?php namespace Hasibomi\PhpS3Cli\Core;

use Hasibomi\PhpS3Cli\Core\PhpS3CliBase;

class Upload extends PhpS3CliBase {
	/**
	 * This method will be called by default.
	 *
	 * @param array $args
	 */
	public function run($args)
	{
		$bucket = explode("=", $args[0]);
		$dir = explode("=", $args[1]);

		if ($bucket[0] !== "--bucket" || $dir[0] !== "--dir") {
			$this->colorize("Usage:", "warning");
			$this->colorize(" php s3cli upload --bucket=<bucketname> --dir=<local-directory>", "success");
		} else {
			$bucketdir = $bucket[1];
			$localdir = $dir[1];

			$this->upload($bucketdir, $localdir);
		}
	}

	/**
	 * Upload file to S3.
	 *
	 * @param $bucket represents bucket name
	 * @param $localdir represents local directory to upload
	 */
	private function upload($bucket, $localdir)
	{
		$this->colorize("Uploading files to {$bucket}...", "warning");

		$files = scandir($localdir);

		foreach ($files as $file) {
			if ($file !== "." || $file !== ".." || $file !== ".DS_Store") {
				try {
	                $this->s3->putObject([
	                    "Bucket" => $bucket,
	                    "Key"    => $localdir . DIRECTORY_SEPARATOR . $file,
	                    "Body"   => fopen($localdir . DIRECTORY_SEPARATOR . $file, "r"),
	                    "ACL"    => "public-read",
	                ]);
	            } catch (\Aws\S3\Exception\S3Exception $e) {
	            	$this->colorize("Can't upload to S3 $e", "failed");
	                exit();
	            }
			}
		}

		$this->colorize("Upload successful", "success");
	}
}