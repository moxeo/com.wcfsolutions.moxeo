<?php
/**
 * @author	Sebastian Oettl
 * @copyright	2011 Sebastian Oettl <http://www.infinite-site.org/>
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