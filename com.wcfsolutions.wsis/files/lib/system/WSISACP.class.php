<?php
// wcf imports
require_once(WCF_DIR.'lib/system/WCFACP.class.php');

/**
 * This class extends the main WCFACP class by cms specific functions.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	system
 * @category	Infinite Site
 */
class WSISACP extends WCFACP {
	/**
	 * @see WCF::getOptionsFilename()
	 */
	protected function getOptionsFilename() {
		return WSIS_DIR.'options.inc.php';
	}
	
	/**
	 * Initialises the template engine.
	 */
	protected function initTPL() {
		global $packageDirs;
		
		self::$tplObj = new ACPTemplate(self::getLanguage()->getLanguageID(), ArrayUtil::appendSuffix($packageDirs, 'acp/templates/'));
		$this->assignDefaultTemplateVariables();
	}
	
	/**
	 * Does the user authentication.
	 */
	protected function initAuth() {
		parent::initAuth();
		
		// user ban
		if (self::getUser()->banned) {
			throw new PermissionDeniedException();
		}
	}
	
	/**
	 * @see WCF::assignDefaultTemplateVariables()
	 */
	protected function assignDefaultTemplateVariables() {
		parent::assignDefaultTemplateVariables();
		
		self::getTPL()->assign(array(
			// add jump to frontend link 			
			'additionalHeaderButtons' => '<li><a href="'.RELATIVE_WSIS_DIR.'"><img src="'.RELATIVE_WSIS_DIR.'icon/indexS.png" alt="" /> <span>'.WCF::getLanguage()->get('wsis.acp.jumpToFrontend').'</span></a></li>',
			// individual page title
			'pageTitle' => WCF::getLanguage()->get(StringUtil::encodeHTML(PAGE_TITLE)).' - '.StringUtil::encodeHTML(PACKAGE_NAME.' '.PACKAGE_VERSION)
		));
	}
	
	/**
	 * @see WCF::loadDefaultCacheResources()
	 */
	protected function loadDefaultCacheResources() {
		parent::loadDefaultCacheResources();
		self::loadDefaultWSISCacheResources();
	}
	
	/**
	 * Loads default cache resources of content management system acp.
	 * Can be called statically from other applications or plugins.
	 */
	public static function loadDefaultWSISCacheResources() {
		WCF::getCache()->addResource('contentItem', WSIS_DIR.'cache/cache.contentItem.php', WSIS_DIR.'lib/system/cache/CacheBuilderContentItem.class.php');
		WCF::getCache()->addResource('contentItemAlias', WSIS_DIR.'cache/cache.contentItemAlias.php', WSIS_DIR.'lib/system/cache/CacheBuilderContentItemAlias.class.php');
		WCF::getCache()->addResource('contentItemStructure', WSIS_DIR.'cache/cache.contentItemStructure.php', WSIS_DIR.'lib/system/cache/CacheBuilderContentItemStructure.class.php');
		WCF::getCache()->addResource('contentItemArticles', WSIS_DIR.'cache/cache.contentItemArticles.php', WSIS_DIR.'lib/system/cache/CacheBuilderContentItemArticles.class.php');
		WCF::getCache()->addResource('newsArchive', WSIS_DIR.'cache/cache.newsArchive.php', WSIS_DIR.'lib/system/cache/CacheBuilderNewsArchive.class.php');
		WCF::getCache()->addResource('theme-'.PACKAGE_ID, WCF_DIR.'cache/cache.theme-'.PACKAGE_ID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderTheme.class.php');
		WCF::getCache()->addResource('themeLayout-'.PACKAGE_ID, WCF_DIR.'cache/cache.themeLayout-'.PACKAGE_ID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderThemeLayout.class.php');
		WCF::getCache()->addResource('themeModule-'.PACKAGE_ID, WCF_DIR.'cache/cache.themeModule-'.PACKAGE_ID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderThemeModule.class.php');
	}
	
	/**
	 * @see WCF::initSession()
	 */
	protected function initSession() {
		// start session
		require_once(WSIS_DIR.'lib/system/session/WSISACPSessionFactory.class.php');
		$factory = new WSISACPSessionFactory();
		self::$sessionObj = $factory->get();
		self::$userObj = self::getSession()->getUser();
	}
}
?>