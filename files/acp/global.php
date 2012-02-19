<?php
/**
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.php>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
// define paths
define('RELATIVE_MOXEO_DIR', '../');

// include config
$packageDirs = array();
require_once(dirname(dirname(__FILE__)).'/config.inc.php');

// include wcf
require_once(RELATIVE_WCF_DIR.'global.php');
if (!count($packageDirs)) $packageDirs[] = MOXEO_DIR;
$packageDirs[] = WCF_DIR;

// starting moxeo acp
require_once(MOXEO_DIR.'lib/system/MOXEOACP.class.php');
new MOXEOACP();
?>