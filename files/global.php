<?php
/**
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.php>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
// include config
$packageDirs = array();
require_once(dirname(__FILE__).'/config.inc.php');

// include wcf
require_once(RELATIVE_WCF_DIR.'global.php');
if (!count($packageDirs)) $packageDirs[] = WSIS_DIR;
$packageDirs[] = WCF_DIR;

// starting wsis core
require_once(WSIS_DIR.'lib/system/WSISCore.class.php');
new WSISCore();
?>