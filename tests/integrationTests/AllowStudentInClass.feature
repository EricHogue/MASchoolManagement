Feature: Allow student in class
	In order to allow student in classes
	As a system user
	I need to see if he is allowed in
	
	Scenario: Student as no subscriptions
		Given a student with no subscription
		When he try to attend a class
		Then he should be denied
		
	Scenario: Student with valid monthly subscription
		Given I have a student with 2 months left on a monthly subscription
		When he try to attend a class
		Then he should be accepted
		 
		 
	Scenario: Student with an expired monthly subscription
		Given I have a student with an expired monthly subscription
		When he try to attend a class
		Then he should be denied
		
	Scenario: Student with classes left
		Given I have a student with 3 classes left
		When he try to attend a class
		Then he should be accepted
		And he should have 2 classes left
		
	Scenario: Student with valid monthy Subscription and classes left
		Given I have a student with 2 months left on a monthly subscription
		And 3 classes left
		When he try to attend a class
		Then he should be accepted
		And he should have 3 classes left