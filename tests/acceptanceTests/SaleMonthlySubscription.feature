Feature: Sale monthly subscription to a student
	In order to have student subscribe
	As a system user
	I need to sale monthly subscriptions
	
	Scenario: Sale monthly subscription to student without subscription 
		Given I have a student without monthly subscription
		When I sell him a 3 months subscription
		Then his subscription should end in 3 months
	
	Scenario: Sale monthly subscription to student with time left on his subscription
		Given I have a student with 2 months left on a monthly subscription
		When I sell him a 6 months subscription
		Then his subscription should end in 8 months