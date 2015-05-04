<?php

namespace CommunityPi;

class Core {
	private $config;
	private $view_controller;

	public function __construct() {
		// load config
		$config = new \CommunityPi\Config\ConfigParse();
		$this->config = $config->file;

		// setup view controller
		$this->view_controller = new \CommunityPi\View\Main;
	}

	public function requestRouter($path, $payload) {
		$prefix_length = strlen($this->config['general']['path']);
		$path = substr($path, $prefix_length);


		if ($path == '' || $path == 'home') {
			// get some basic variables
			$variables = array(
				'theme' => $this->theme_variables(),
				'global' => $this->global_variables(),
				'login' => $this->login_variables(),
				'register' => $this->register_variables()
				);

			$this->view_controller->view_home($variables);
		} elseif ($path == 'login') {

		} elseif ($path == 'register') {

		} else {
			print_r($payload);
			$error = new \CommunityPi\Errors\HTTPError(404, "Invalid Route");
		}
	}

	private function theme_variables() {
		return array(
			'path' => '/themes/' . $this->config['general']['theme name'] . '/'
			);
	}

	private function global_variables() {
		return array(
			'site_name' => $this->config['general']['site name'],
		);
	}

	private function login_variables() {
		return array(
			'post_url' => $this->config['general']['base url'] . '/login',
		);
	}

	private function register_variables() {
		return array(
			'post_url' => $this->config['general']['base url'] . '/register',
		);
	}


}