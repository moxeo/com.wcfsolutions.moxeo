<?php
try {
	// include wcf/wsis
	require_once('./global.php');	
	
	// execute cronjobs
	require_once(WCF_DIR.'lib/action/CronjobsExecAction.class.php');
	new CronjobsExecAction();
}
catch (NamedUserException $e) {
	throw new SystemException($e->getMessage());
}
?>