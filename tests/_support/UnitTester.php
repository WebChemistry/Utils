<?php

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class UnitTester extends \Codeception\Actor {

	use _generated\UnitTesterActions;

	/**
	 * Define custom actions here
	 */
	public function assertExceptionThrown($exception, $function) {
		try {
			$function();

			return FALSE;
		} catch (Exception $e) {
			if (get_class($e) == $exception) {
				return TRUE;
			}

			return FALSE;
		}
	}

}
