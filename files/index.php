<?php
/**
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
require_once('./global.php');
require_once(MOXEO_DIR.'lib/system/request/ContentItemRequestHandler.class.php');
ContentItemRequestHandler::getInstance()->handle();
?>