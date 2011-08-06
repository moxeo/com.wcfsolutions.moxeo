<?php
// wsis imports
require_once(WSIS_DIR.'lib/system/session/WSISSession.class.php');
require_once(WSIS_DIR.'lib/data/user/WSISUserSession.class.php');
require_once(WSIS_DIR.'lib/data/user/WSISGuestSession.class.php');

// wcf imports
require_once(WCF_DIR.'lib/system/session/CookieSessionFactory.class.php');

/**
 * WSISSessionFactory extends the CookieSessionFactory class with site specific functions.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	system.session
 * @category	Infinite Site
 */
class WSISSessionFactory extends CookieSessionFactory {
	protected $guestClassName = 'WSISGuestSession';
	protected $userClassName = 'WSISUserSession';
	protected $sessionClassName = 'WSISSession';
}
?>