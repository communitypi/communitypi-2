<?php
namespace CommunityPi\Errors;

class ErrorHandler extends \Exception {
	protected $title;
	protected $message;
	protected $code;
	protected $previous;

	public function __construct($title, $message, $code = 0, Exception $previous = null) {
		$this->title = $title;
		$this->message = $message;
		$this->code = $code;
		$this->previous = $previous;

		parent::__construct($message, $code, $previous);
	}

	public function displayError() {
		echo '<h2>' . $this->title . '</h2>';
		echo '<p>' . $this->message . '</p>';
		echo '<p><i>' . $this->previous . '</p>';
	}
}