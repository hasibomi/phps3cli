## phps3cli
Command line support for S3 for PHP projects. It reads configurations from the `.env` file.

## Features
1. Upload to S3 bucket

(More features are coming)

## Requirements
You have to place your configurations in the `.env` file. The `.env` must be placed in the project root.

## Example of `.env` file
`S3_REGION=region`

`S3_VERSION=latest`

`AWS_ACCESS_KEY_ID=access-key-id`

`AWS_SECRET_ACCESS_KEY=secret-access-key`

## Installation
You can install via composer. Just type `composer require hasibomi/phps3cli` in your terminal & you are good to go.

## Usage
1. `vendor/bin/phps3cli` to get the list of commands
2. `vendor/bin/phps3cli upload --bucket=bucket_name --dir=local_directory` 
