<?php

namespace CommunityPi\View;

class Main {
	private $twig;
	private $config;

	public function __construct() {
		// load config
		$config = new \CommunityPi\Config\ConfigParse();
		$this->config = $config->file;

		// setup twig
		$loader = new \Twig_Loader_Filesystem('themes/' . $this->config['general']['theme name']);
		$this->twig = new \Twig_Environment($loader);
		
	}

	public function view_home($data) {
		echo $this->twig->render('home.tpl', $data);

	}

}