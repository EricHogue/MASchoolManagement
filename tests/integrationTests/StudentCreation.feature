@database
Feature: Create a student
	In order to track students
	As a user of the system
	I need to create and retrieve students
	
	Scenario: Create Student
		Given I have a student With id: 1, firstname "foo", lastname: "bar" and rank: "kyu6"
		When I create his profile
		Then I can retrieve it back
	
	Scenario: Read Student information
		Given I have a student With id: 2, firstname "Eric", lastname: "Hogue" and rank: "shodan"
		When I create his profile
		And I load student with id 2
		Then his id should be 2
		And his firstname should be "Eric"
		And his lastname should be "Hogue"
		And his rank should be "shodan"
	
	Scenario: Loading a student that does not exists
		Given I don't have a student with id 2
		When I load student with id 2
		Then it should be null