<?php
/**
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
try {
	// include wcf/moxeo
	require_once('./global.php');

	// execute cronjobs
	require_once(WCF_DIR.'lib/action/CronjobsExecAction.class.php');
	new CronjobsExecAction();
}
catch (NamedUserException $e) {
	throw new SystemException($e->getMessage());
}
?>