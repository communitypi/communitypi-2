<?php
require_once 'vendor/autoload.php';

class CommunityPi {
	// some variables to hold things
	private $mongo;
	private $mongodb;
	private $config;
	private $twig;

	public function __construct() {
		// load config
		$this->config_load();

		// connect to database
		$this->database_connect();

		// setup twig
		$loader = new Twig_Loader_Filesystem('themes/' . $this->config['general']['theme name']);
		$this->twig = new Twig_Environment($loader);
	}

	/* Config functions */
	private function config_load() {
		if (empty($this->config)) {
			$this->config = parse_ini_file('../communitypi.ini', TRUE);

			if (!$this->config) {
				throw new Exception('Unable to load config file');
			}
		}
	}

	/* Database functions */
	private function database_connect() {
		try {
			$this->mongo = new Mongo($this->database_composeString());

			// assume db is communitypi
			if (empty($this->config['mongodb']['db'])) {
				$db = 'communitypi';
			} else {
				$db = $this->config['mongodb']['db'];
			}

			$this->mongodb = $this->mongo->selectDB($db);
		} catch (MongoConnectionException $e) {
			throw new Exception('Unable to connect to database', 0, $e);
		}
	}

	private function database_composeString() {
		// assume localhost
		if (empty($this->config['mongodb']['host'])) {
			$host = 'localhost';
		} else {
			$host = $this->config['mongodb']['host'];
		}

		// assume port is default
		if (empty($this->config['mongodb']['port']) || $this->config['mongodb']['port'] == '0' ) {
			$port = 27017;
		} else {
			$port = $this->config['mongodb']['port'];
		}

		// build final string
		if (empty($this->config['mongodb']['user'])) {
			// because theres no user, theres no password either
			return 'mongodb://' . $host . ':' . $port;
		} elseif ($this->config['mongodb']['pass'] == '') {
			// user but no password
			return 'mongodb://' . $this->config['mongodb']['user'] . '@' . $host . ':' . $port;
		} else {
			// username and password
			return 'mongodb://' . $this->config['mongodb']['user'] . ':' . $this->config['mongodb']['pass'] . '@' . $host . ':' . $port;
		}
	}

	private function database_query($collection, $query, $fields) {
		$collection = new MongoCollection($this->mongodb, $collection);
		$cursor = $collection->find($query, $fields);

		return $cursor;
	}

	private function database_queryOne($collection, $query, $fields) {
		$collection = new MongoCollection($this->mongodb, $collection);
		$cursor = $collection->findOne($query, $fields);

		return $cursor;
	}

	/* Request functions */
	public function request_router($path, $payload) {
		$prefix_length = strlen($this->config['general']['path']);
		$path = substr($path, $prefix_length);

		if ($path == '' || $path == 'home') {
			// get some basic variables
			$variables = array(
				'theme' => $this->variables_theme(),
				'global' => $this->variables_global(),
				'login' => $this->variables_login(),
				'register' => $this->variables_register()
			);

			$this->view_home($variables);
		} elseif ($path == 'login') {
			$variables = array(
				'theme' => $this->variables_theme(),
				'global' => $this->variables_global(),
				'login' => $this->variables_login()
			);

			$this->view_login($variables, $payload);
		} elseif ($path == 'register') {
			$variables = array(
				'theme' => $this->variables_theme(),
				'global' => $this->variables_global(),
				'register' => $this->variables_register()
			);

			$this->view_register($variables, $payload);
		} else {
			throw new Exception('404 Page not Foud');
		}
	}


	/* Variables functions */
	private function variables_theme() {
		return array(
			'path' => '/themes/' . $this->config['general']['theme name'] . '/'
		);
	}

	private function variables_global() {
		return array(
			'site_name' => $this->config['general']['site name'],
		);
	}

	private function variables_login() {
		return array(
			'post_url' => $this->config['general']['base url'] . '/login',
		);
	}

	private function variables_register() {
		return array(
			'post_url' => $this->config['general']['base url'] . '/register',
		);
	}


	/* View functions */
	public function view_home($variables) {
		echo $this->twig->render('home.tpl', $variables);
	}

	public function view_login($variables, $payload) {
		$login = $this->do_login($payload['username'], $payload['password'], @$payload['remember']);

	}

	public function view_register($variables, $payload) {

	}

	/* Do functions */
	private function do_login($username, $password, $remember = FALSE) {
		$results = $this->database_queryOne('users', array('username' => $username), array('security.password' => true));

		if ($results) {
			$db_password = $results['security']['password'];
		}

	}


}