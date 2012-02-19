<?php
// wcf imports
require_once(WCF_DIR.'lib/acp/package/plugin/AbstractXMLPackageInstallationPlugin.class.php');

/**
 * This PIP installs, updates or deletes commentable object types.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.php>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.package.plugin
 * @category 	Moxeo Open Source CMS
 */
class CommentableObjectTypePackageInstallationPlugin extends AbstractXMLPackageInstallationPlugin {
	public $tagName = 'commentableobjecttype';
	public $tableName = 'commentable_object_type';
	
	/** 
	 * @see	PackageInstallationPlugin::install()
	 */
	public function install() {
		parent::install();
		
		if (!$xml = $this->getXML()) {
			return;
		}
		
		// get instance no
		$instanceNo = WCF_N.'_'.$this->getApplicationPackage()->getInstanceNo();
		
		// Create an array with the data blocks (import or delete) from the xml file.
		$commentableObjectTypeXML = $xml->getElementTree('data');
		
		// Loop through the array and install or uninstall items.
		foreach ($commentableObjectTypeXML['children'] as $key => $block) {
			if (count($block['children'])) {
				// Handle the import instructions
				if ($block['name'] == 'import') {
					// Loop through items and create or update them.
					foreach ($block['children'] as $commentableObjectType) {
						// Extract item properties.
						foreach ($commentableObjectType['children'] as $child) {
							if (!isset($child['cdata'])) continue;
							$commentableObjectType[$child['name']] = $child['cdata'];
						}
					
						// default values
						$name = $classFile = '';
						
						// get values
						if (isset($commentableObjectType['name'])) $name = $commentableObjectType['name'];
						if (isset($commentableObjectType['classfile'])) $classFile = $commentableObjectType['classfile'];
						
						// insert items
						$sql = "INSERT INTO			moxeo".$instanceNo."_commentable_object_type
											(packageID, commentableObjectType, classFile)
							VALUES				(".$this->installation->getPackageID().",
											'".escapeString($name)."',
											'".escapeString($classFile)."')
							ON DUPLICATE KEY UPDATE 	classFile = VALUES(classFile)";
						WCF::getDB()->sendQuery($sql);
					}
				}
				// Handle the delete instructions.
				else if ($block['name'] == 'delete' && $this->installation->getAction() == 'update') {
					// Loop through items and delete them.
					$nameArray = array();
					foreach ($block['children'] as $commentableObjectType) {
						// Extract item properties.
						foreach ($commentableObjectType['children'] as $child) {
							if (!isset($child['cdata'])) continue;
							$commentableObjectType[$child['name']] = $child['cdata'];
						}
					
						if (empty($commentableObjectType['name'])) {
							throw new SystemException("Required 'name' attribute for commentable object type is missing", 13023); 
						}
						$nameArray[] = $commentableObjectType['name'];
					}
					if (count($nameArray)) {
						$sql = "DELETE FROM	moxeo".$instanceNo."_commentable_object_type
							WHERE		packageID = ".$this->installation->getPackageID()."
									AND commentableObjectType IN ('".implode("','", array_map('escapeString', $nameArray))."')";
						WCF::getDB()->sendQuery($sql);
					}
				}
			}
		}
	}
	
	/**
	 * @see	PackageInstallationPlugin::hasUninstall()
	 */
	public function hasUninstall() {
		if (($package = $this->getApplicationPackage()) !== null && $package->getPackage() == 'com.wcfsolutions.moxeo') {
			try {				
				$instanceNo = WCF_N.'_'.$package->getInstanceNo();
				$sql = "SELECT	COUNT(*) AS count
					FROM	moxeo".$instanceNo."_commentable_object_type
					WHERE	packageID = ".$this->installation->getPackageID();
				$installationCount = WCF::getDB()->getFirstRow($sql);
				return $installationCount['count'];
			}
			catch (Exception $e) {
				return false;	
			}
		}
		else return false;
	}
	
	/**
	 * @see	PackageInstallationPlugin::uninstall()
	 */
	public function uninstall() {
		if (($package = $this->getApplicationPackage()) !== null && $package->getPackage() == 'com.wcfsolutions.moxeo') {		
			$instanceNo = WCF_N.'_'.$package->getInstanceNo();
			
			// get commentable object types
			$commentableObjectTypes = array();
			$sql = "SELECT	commentableObjectType
				FROM	moxeo".$instanceNo."_commentable_object_type
				WHERE	packageID = ".$this->installation->getPackageID();
			$result = WCF::getDB()->sendQuery($sql);
			while ($row = WCF::getDB()->fetchArray($result)) {
				$commentableObjectTypes[] = $row['commentableObjectType'];
			}
			
			if (count($commentableObjectTypes)) {
				// delete comments
				$sql = "DELETE FROM	moxeo".$instanceNo."_comment
					WHERE		commentableObjectType IN ('".implode("','", array_map('escapeString', $commentableObjectTypes))."')";
				WCF::getDB()->sendQuery($sql);			
			
				// delete commentable object types
				$sql = "DELETE FROM	moxeo".$instanceNo."_commentable_object_type
					WHERE		packageID = ".$this->installation->getPackageID();
				WCF::getDB()->sendQuery($sql);
			}
		}
	}
	
	/**
	 * Returns the application package instance.
	 * 
	 * @return	Package
	 */
	protected function getApplicationPackage() {
		if ($this->installation->getPackage()->getParentPackage() !== null) {
			return $this->installation->getPackage()->getParentPackage();
		}
		return $this->installation->getPackage();
	}
}
?>