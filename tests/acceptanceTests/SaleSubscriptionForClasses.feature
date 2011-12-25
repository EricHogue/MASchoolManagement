Feature: Sales classes subscription
	In order to have students subscribes
	As a system user
	I need to sale subscriptions by the class
	
	Scenario: Sale classes to students without subscription
		Given I have a student with 0 classes left
		When I sell him 5 classes
		Then he should have 5 classes left
		
	Scenario: Sale classes to students with an existing classes subscription
		Given I have a student with 3 classes left
		When I sell him 4 classes
		Then he should have 7 classes left