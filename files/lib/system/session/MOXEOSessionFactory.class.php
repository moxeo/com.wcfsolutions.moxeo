<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/system/session/MOXEOSession.class.php');
require_once(MOXEO_DIR.'lib/data/user/MOXEOUserSession.class.php');
require_once(MOXEO_DIR.'lib/data/user/MOXEOGuestSession.class.php');

// wcf imports
require_once(WCF_DIR.'lib/system/session/CookieSessionFactory.class.php');

/**
 * MOXEOSessionFactory extends the CookieSessionFactory class with site specific functions.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	system.session
 * @category	Moxeo Open Source CMS
 */
class MOXEOSessionFactory extends CookieSessionFactory {
	protected $guestClassName = 'MOXEOGuestSession';
	protected $userClassName = 'MOXEOUserSession';
	protected $sessionClassName = 'MOXEOSession';
}
?>