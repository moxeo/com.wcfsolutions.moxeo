<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/system/request/ContentItemRequestHandler.class.php');

// wcf imports
require_once(WCF_DIR.'lib/system/theme/ThemeLayoutManager.class.php');

/**
 * This class extends the main WCF class by site specific functions.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	system
 * @category	Moxeo Open Source CMS
 */
class MOXEOCore extends WCF {
	/**
	 * @see	WCF::initLanguage()
	 */
	protected function initLanguage() {
		$languageID = ContentItemRequestHandler::getInstance()->getLanguageID();
		self::$languageObj = new Language($languageID);
	}

	/**
	 * @see	WCF::initTPL()
	 */
	protected function initTPL() {
		// init theme layout to get template pack id
		$this->initThemeLayout();

		global $packageDirs;
		require_once(WCF_DIR.'lib/system/template/StructuredTemplate.class.php');
		self::$tplObj = new StructuredTemplate(self::getThemeLayout()->getTheme()->templatePackID, self::getLanguage()->getLanguageID(), ArrayUtil::appendSuffix($packageDirs, 'templates/'));
		$this->assignDefaultTemplateVariables();

		// init cronjobs
		$this->initCronjobs();
	}

	/**
	 * Initialises the cronjobs.
	 */
	protected function initCronjobs() {
		self::getTPL()->assign('executeCronjobs', WCF::getCache()->get('cronjobs-'.PACKAGE_ID, 'nextExec') < TIME_NOW);
	}

	/**
	 * @see	WCF::loadDefaultCacheResources()
	 */
	protected function loadDefaultCacheResources() {
		parent::loadDefaultCacheResources();
		self::loadDefaultMOXEOCacheResources();
	}

	/**
	 * Loads default cache resources of content management system.
	 * Can be called statically from other applications or plugins.
	 */
	public static function loadDefaultMOXEOCacheResources() {
		WCF::getCache()->addResource('contentItem', MOXEO_DIR.'cache/cache.contentItem.php', MOXEO_DIR.'lib/system/cache/CacheBuilderContentItem.class.php');
		WCF::getCache()->addResource('contentItemAlias', MOXEO_DIR.'cache/cache.contentItemAlias.php', MOXEO_DIR.'lib/system/cache/CacheBuilderContentItemAlias.class.php');
		WCF::getCache()->addResource('contentItemStructure', MOXEO_DIR.'cache/cache.contentItemStructure.php', MOXEO_DIR.'lib/system/cache/CacheBuilderContentItemStructure.class.php');
		WCF::getCache()->addResource('contentItemArticles', MOXEO_DIR.'cache/cache.contentItemArticles.php', MOXEO_DIR.'lib/system/cache/CacheBuilderContentItemArticles.class.php');
		WCF::getCache()->addResource('cronjobs-'.PACKAGE_ID, WCF_DIR.'cache/cache.cronjobs-'.PACKAGE_ID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderCronjobs.class.php');
		WCF::getCache()->addResource('theme-'.PACKAGE_ID, WCF_DIR.'cache/cache.theme-'.PACKAGE_ID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderTheme.class.php');
		WCF::getCache()->addResource('themeLayout-'.PACKAGE_ID, WCF_DIR.'cache/cache.themeLayout-'.PACKAGE_ID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderThemeLayout.class.php');
		WCF::getCache()->addResource('themeModule-'.PACKAGE_ID, WCF_DIR.'cache/cache.themeModule-'.PACKAGE_ID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderThemeModule.class.php');
	}

	/**
	 * @see	WCF::getOptionsFilename()
	 */
	protected function getOptionsFilename() {
		return MOXEO_DIR.'options.inc.php';
	}

	/**
	 * Initialises the theme layout system.
	 */
	protected function initThemeLayout() {
		ThemeLayoutManager::changeThemeLayout();
	}

	/**
	 * Returns the active theme layout object.
	 *
	 * @return	ThemeLayout
	 */
	public static final function getThemeLayout() {
		return ThemeLayoutManager::getThemeLayout();
	}

	/**
	 * @see	WCF::initSession()
	 */
	protected function initSession() {
		// start session
		require_once(MOXEO_DIR.'lib/system/session/MOXEOSessionFactory.class.php');
		$factory = new MOXEOSessionFactory();
		self::$sessionObj = $factory->get();
		self::$userObj = self::getSession()->getUser();
	}
}
?>