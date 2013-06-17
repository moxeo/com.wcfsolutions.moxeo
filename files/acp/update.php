<?php
/**
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
$packageID = $this->installation->getPackageID();
$instanceNo = $this->installation->getPackage()->getParentPackage()->getInstanceNo();

// create root
$sql = "INSERT INTO	moxeo".WCF_N."_".$instanceNo."_content_item
			(languageID, parentID, title, contentItemType)
	VALUES		(".WCF::getLanguage()->getLanguageID().", 0, 'Moxeo Open Source CMS', -1)";
WCF::getDB()->sendQuery($sql);
$contentItemID = WCF::getDB()->getInsertID("moxeo".WCF_N."_".$instanceNo."_content_item", 'contentItemID');

// update content items
$sql = "UPDATE	moxeo".WCF_N."_".$instanceNo."_content_item
	SET	parentID = ".$contentItemID.",
		languageID = 0
	WHERE 	parentID = 0";
WCF::getDB()->sendQuery($sql);
?>