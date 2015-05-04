<?php
namespace CommunityPi\Database;

class Connect {
	private $MongoClient;
	private $MongoDB;

	public function __construct() {
		$configuration = new \CommunityPi\Config\ConfigParse();

		try {
			$this->MongoClient = new \MongoClient($this->composeString());
		} catch (\MongoConnectionException $e) {
			try {
				throw new \CommunityPi\Errors\ErrorHandler('Unable to connect to database', $e->getMessage(), 1);
			} catch (\CommunityPi\Errors\ErrorHandler $e) {
				$e->displayError();
			}
		}
	}

	private function composeString() {
		$configuration = new \CommunityPi\Config\ConfigParse();

		// assume localhost
		if (empty($configuration->file['mongodb']['host'])) {
			$host = 'localhost';
		} else {
			$host = $configuration->file['mongodb']['host'];
		}

		// assume port is default
		if (empty($configuration->file['mongodb']['port']) || $configuration->file['mongodb']['port'] == '0' ) {
			$port = 27017;
		} else {
			$port = $configuration->file['mongodb']['port'];
		}

		// assume db is communitypi
		if (empty($configuration->file['mongodb']['db'])) {
			$db = 'communitypi';
		} else {
			$db = $configuration->file['mongodb']['db'];
		}

		// build final string
		if (empty($configuration->file['mongodb']['user'])) {
			// because theres no user, theres no password either
			return 'mongodb://' . $host . ':' . $port . '/' . $db;
		} elseif ($configuration->file['mongodb']['pass'] == '') {
			// user but no password
			return 'mongodb://' . $configuration->file['mongodb']['user'] . '@' . $host . ':' . $port . '/' . $db;
		} else {
			// username and password
			return 'mongodb://' . $configuration->file['mongodb']['user'] . ':' . $configuration->file['mongodb']['pass'] . '@' . $host . ':' . $port . '/' . $db;
		}
	}
}
?>