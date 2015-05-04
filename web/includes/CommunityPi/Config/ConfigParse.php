<?php
namespace CommunityPi\Config;

class ConfigParse {
	public $file;

	public function __construct() {
		// try to load the configuration file
		$this->file = parse_ini_file('../communitypi.ini', TRUE);

		if (!$this->file) {
			try {
				throw new \CommunityPi\Errors\ErrorHandler('Unable to load config file', 'Unable to load communitypi.conf', 1);
			} catch (\CommunityPi\Errors\ErrorHandler $e) {
				$e->displayError();
			}
		}
	}
}