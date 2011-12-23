Feature: User can attend a class
	In order to attend a class
	As a student
	I need to know if I'm allowed

Scenario: User has classes left
	Given I have "3" classes Left
	When I check if I can attend
	Then I should get "true"