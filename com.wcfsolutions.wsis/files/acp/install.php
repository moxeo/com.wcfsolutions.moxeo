<?php
/**
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.php>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
$packageID = $this->installation->getPackageID();

// set installation date
$sql = "UPDATE	wcf".WCF_N."_option
	SET	optionValue = ".TIME_NOW."
	WHERE	optionName = 'install_date'
		AND packageID = ".$packageID;
WCF::getDB()->sendQuery($sql);

// set page url and cookie path
if (!empty($_SERVER['SERVER_NAME'])) {
	// domain
	$pageURL = 'http://'.$_SERVER['SERVER_NAME'];
	
	// port
	if (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != 80) {
		$pageURL .= ':'.$_SERVER['SERVER_PORT'];
	}
	
	// file
	$path = FileUtil::removeTrailingSlash(FileUtil::getRealPath(FileUtil::addTrailingSlash(dirname(dirname(WCF::getSession()->requestURI))).$this->installation->getPackage()->getDir()));
	$pageURL .= $path;
	
	$sql = "UPDATE	wcf".WCF_N."_option
		SET	optionValue = '".escapeString($pageURL)."'
		WHERE	optionName = 'page_url'
			AND packageID = ".$packageID;
	WCF::getDB()->sendQuery($sql);
	
	$sql = "UPDATE	wcf".WCF_N."_option
		SET	optionValue = '".escapeString($path)."'
		WHERE	optionName = 'cookie_path'
			AND packageID = ".$packageID;
	WCF::getDB()->sendQuery($sql);
}

// admin options
$sql = "UPDATE 	wcf".WCF_N."_group_option_value
	SET	optionValue = 1
	WHERE	groupID = 4
		AND optionID IN (
			SELECT	optionID
			FROM	wcf".WCF_N."_group_option
			WHERE	packageID IN (
					SELECT	dependency
					FROM	wcf".WCF_N."_package_dependency
					WHERE	packageID = ".$packageID."
				)
		)
		AND optionValue = '0'";
WCF::getDB()->sendQuery($sql);
?>