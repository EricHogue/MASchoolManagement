@database
Feature: Create a student
	In order to track students
	As a user of the system
	I need to create and retrieve students
	
	Scenario: Create Student
		Given I have a new student
		When I create his profile
		Then I can retrieve it back
	
	Scenario: Read Student information
		Given I have a student With id: 1, firstname "foo", lastname: "bar" and rank: "kyu6"
		When I load his profile
		Then his firstname should be "foo"
		And his lastname should be "bar"
		And his rank should be "kyu6"
		