<?php
namespace MASchoolManagement\Subscriptions;

use \Zend\Date\Date;

interface Subscription  {
	/**
	 * Check if the subscriber can attend at the given date
	 *
	 * @param \Zend\Date\Date $date
	 * @return boolean true if the user can attend
	 */
	public function canAttend(Date $date);

	/**
	 * Add an attendace for a date
	 *
	 * @param \Zend\Date\Date $date
	 */
	public function addAttendance(Date $date);
}