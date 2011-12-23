<?php
namespace MASchoolManagement;

class Student {
	/** @var string */
	private $lastName;

	/** @var string */
	private $firstName;


	public function __construct($lastName, $firstName) {
		$this->lastName = $lastName;
		$this->firstName = $firstName;
	}


	public function getFirstName() {
		return $this->firstName;
	}

	public function getLastName() {
		return $this->lastName;
	}

}