<?php

namespace CommunityPi\Errors;

class HTTPError {

	public function __construct($code, $extra) {
		switch ($code) {
			case 404:
				$this->HTTP_404($extra);
				break;
		}
	}

	private function HTTP_404($extra) {
		header("HTTP/1.1 404 Page not found");
	}
}