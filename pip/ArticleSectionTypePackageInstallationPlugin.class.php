<?php
// wcf imports
require_once(WCF_DIR.'lib/acp/package/plugin/AbstractXMLPackageInstallationPlugin.class.php');

/**
 * This PIP installs, updates or deletes article section types.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.package.plugin
 * @category 	Moxeo Open Source CMS
 */
class ArticleSectionTypePackageInstallationPlugin extends AbstractXMLPackageInstallationPlugin {
	public $tagName = 'articlesectiontype';
	public $tableName = 'article_section_type';

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
		$articleSectionTypeXML = $xml->getElementTree('data');

		// Loop through the array and install or uninstall items.
		foreach ($articleSectionTypeXML['children'] as $key => $block) {
			if (count($block['children'])) {
				// Handle the import instructions
				if ($block['name'] == 'import') {
					// Loop through items and create or update them.
					foreach ($block['children'] as $articleSectionType) {
						// Extract item properties.
						foreach ($articleSectionType['children'] as $child) {
							if (!isset($child['cdata'])) continue;
							$articleSectionType[$child['name']] = $child['cdata'];
						}

						// default values
						$name = $category = $classFile = '';

						// get values
						if (isset($articleSectionType['name'])) $name = $articleSectionType['name'];
						if (isset($articleSectionType['category'])) $category = $articleSectionType['category'];
						if (isset($articleSectionType['classfile'])) $classFile = $articleSectionType['classfile'];

						// insert items
						$sql = "INSERT INTO			moxeo".$instanceNo."_article_section_type
											(packageID, articleSectionType, category, classFile)
							VALUES				(".$this->installation->getPackageID().",
											'".escapeString($name)."',
											'".escapeString($category)."',
											'".escapeString($classFile)."')
							ON DUPLICATE KEY UPDATE 	category = VALUES(category),
											classFile = VALUES(classFile)";
						WCF::getDB()->sendQuery($sql);
					}
				}
				// Handle the delete instructions.
				else if ($block['name'] == 'delete' && $this->installation->getAction() == 'update') {
					// Loop through items and delete them.
					$nameArray = array();
					foreach ($block['children'] as $articleSectionType) {
						// Extract item properties.
						foreach ($articleSectionType['children'] as $child) {
							if (!isset($child['cdata'])) continue;
							$articleSectionType[$child['name']] = $child['cdata'];
						}

						if (empty($articleSectionType['name'])) {
							throw new SystemException("Required 'name' attribute for article section type is missing", 13023);
						}
						$nameArray[] = $articleSectionType['name'];
					}
					if (count($nameArray)) {
						$sql = "DELETE FROM	moxeo".$instanceNo."_article_section_type
							WHERE		packageID = ".$this->installation->getPackageID()."
									AND articleSectionType IN ('".implode("','", array_map('escapeString', $nameArray))."')";
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
					FROM	moxeo".$instanceNo."_article_section_type
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

			// get article section types
			$articleSectionTypes = array();
			$sql = "SELECT	articleSectionType
				FROM	moxeo".$instanceNo."_article_section_type
				WHERE	packageID = ".$this->installation->getPackageID();
			$result = WCF::getDB()->sendQuery($sql);
			while ($row = WCF::getDB()->fetchArray($result)) {
				$articleSectionTypes[] = $row['articleSectionType'];
			}

			if (count($articleSectionTypes)) {
				// delete article sections
				$sql = "DELETE FROM	moxeo".$instanceNo."_article_section
					WHERE		articleSectionType IN ('".implode("','", array_map('escapeString', $articleSectionTypes))."')";
				WCF::getDB()->sendQuery($sql);

				// delete article section types
				$sql = "DELETE FROM	moxeo".$instanceNo."_article_section_type
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