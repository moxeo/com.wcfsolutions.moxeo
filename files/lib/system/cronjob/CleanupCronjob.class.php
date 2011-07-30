<?php
// wcf imports
require_once(WCF_DIR.'lib/data/cronjobs/Cronjob.class.php');
require_once(WCF_DIR.'lib/system/session/Session.class.php');

/**
 * Cronjob for a hourly system cleanup for the site.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	system.cronjob
 * @category	Infinite Site
 */
class CleanupCronjob implements Cronjob {
	/**
	 * @see	Cronjob::execute()
	 */
	public function execute($data) {		
		// delete old sessions
		Session::deleteExpiredSessions((TIME_NOW - SESSION_TIMEOUT));
		
		// delete old captchas
		$sql = "DELETE FROM	wsis".WSIS_N."_captcha
			WHERE		time < ".(TIME_NOW - 3600);
		WCF::getDB()->registerShutdownUpdate($sql);
		
		// optimize tables to save some memory (mysql only)
		if (WCF::getDB()->getDBType() == 'MySQLDatabase' || WCF::getDB()->getDBType() == 'MySQLiDatabase' || WCF::getDB()->getDBType() == 'MySQLPDODatabase') {
			$sql = "OPTIMIZE TABLE	wcf".WCF_N."_session_data, wcf".WCF_N."_acp_session_data, wcf".WCF_N."_search";
			WCF::getDB()->registerShutdownUpdate($sql);
		}
	}
}
?>