<?php
namespace MASchoolManagement\Subscriptions;

interface Subscription  {
	/**
	 * Check if the subscriber can attend
	 *
	 * @return boolean true if the user can attend
	 */
	public function canAttend();

	/**
	 * Add an attendace
	 */
	public function addAttendance();
}