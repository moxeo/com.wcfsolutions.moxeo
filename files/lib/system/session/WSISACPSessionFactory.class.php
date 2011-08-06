<?php
// wsis imports
require_once(WSIS_DIR.'lib/system/session/WSISACPSession.class.php');
require_once(WSIS_DIR.'lib/data/user/WSISUserSession.class.php');
require_once(WSIS_DIR.'lib/data/user/WSISGuestSession.class.php');

// wcf imports
require_once(WCF_DIR.'lib/system/session/SessionFactory.class.php');

/**
 * WSISACPSessionFactory extends the SessionFactory class with site specific functions.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	system.session
 * @category	Infinite Site
 */
class WSISACPSessionFactory extends SessionFactory {
	protected $guestClassName = 'WSISGuestSession';
	protected $userClassName = 'WSISUserSession';
	protected $sessionClassName = 'WSISACPSession';
}
?>