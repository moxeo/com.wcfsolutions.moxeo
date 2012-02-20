<?php
// wcf imports
require_once(WCF_DIR.'lib/system/WCFACP.class.php');

/**
 * This class extends the main WCFACP class by cms specific functions.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	system
 * @category	Moxeo Open Source CMS
 */
class MOXEOACP extends WCFACP {
	/**
	 * @see	WCF::getOptionsFilename()
	 */
	protected function getOptionsFilename() {
		return MOXEO_DIR.'options.inc.php';
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
	 * @see	WCF::assignDefaultTemplateVariables()
	 */
	protected function assignDefaultTemplateVariables() {
		parent::assignDefaultTemplateVariables();

		self::getTPL()->assign(array(
			// add jump to frontend link
			'additionalHeaderButtons' => '<li><a href="'.RELATIVE_MOXEO_DIR.'"><img src="'.RELATIVE_MOXEO_DIR.'icon/indexS.png" alt="" /> <span>'.WCF::getLanguage()->get('moxeo.acp.jumpToFrontend').'</span></a></li>',
			// individual page title
			'pageTitle' => WCF::getLanguage()->get(StringUtil::encodeHTML(PAGE_TITLE)).' - '.StringUtil::encodeHTML(PACKAGE_NAME.' '.PACKAGE_VERSION)
		));

		// moxeo stylesheet
		$html = '<style type="text/css">
				@import url("'.RELATIVE_MOXEO_DIR.'acp/style/moxeo'.(PAGE_DIRECTION == 'rtl' ? '-rtl' : '').'.css");
			</style>';
		self::getTPL()->append('specialStyles', $html);
	}

	/**
	 * @see	WCF::loadDefaultCacheResources()
	 */
	protected function loadDefaultCacheResources() {
		parent::loadDefaultCacheResources();
		self::loadDefaultMOXEOCacheResources();
	}

	/**
	 * Loads default cache resources of content management system acp.
	 * Can be called statically from other applications or plugins.
	 */
	public static function loadDefaultMOXEOCacheResources() {
		WCF::getCache()->addResource('contentItem', MOXEO_DIR.'cache/cache.contentItem.php', MOXEO_DIR.'lib/system/cache/CacheBuilderContentItem.class.php');
		WCF::getCache()->addResource('contentItemAlias', MOXEO_DIR.'cache/cache.contentItemAlias.php', MOXEO_DIR.'lib/system/cache/CacheBuilderContentItemAlias.class.php');
		WCF::getCache()->addResource('contentItemStructure', MOXEO_DIR.'cache/cache.contentItemStructure.php', MOXEO_DIR.'lib/system/cache/CacheBuilderContentItemStructure.class.php');
		WCF::getCache()->addResource('contentItemArticles', MOXEO_DIR.'cache/cache.contentItemArticles.php', MOXEO_DIR.'lib/system/cache/CacheBuilderContentItemArticles.class.php');
		WCF::getCache()->addResource('newsArchive', MOXEO_DIR.'cache/cache.newsArchive.php', MOXEO_DIR.'lib/system/cache/CacheBuilderNewsArchive.class.php');
		WCF::getCache()->addResource('theme-'.PACKAGE_ID, WCF_DIR.'cache/cache.theme-'.PACKAGE_ID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderTheme.class.php');
		WCF::getCache()->addResource('themeLayout-'.PACKAGE_ID, WCF_DIR.'cache/cache.themeLayout-'.PACKAGE_ID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderThemeLayout.class.php');
		WCF::getCache()->addResource('themeModule-'.PACKAGE_ID, WCF_DIR.'cache/cache.themeModule-'.PACKAGE_ID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderThemeModule.class.php');
	}

	/**
	 * @see	WCF::initSession()
	 */
	protected function initSession() {
		// start session
		require_once(MOXEO_DIR.'lib/system/session/MOXEOACPSessionFactory.class.php');
		$factory = new MOXEOACPSessionFactory();
		self::$sessionObj = $factory->get();
		self::$userObj = self::getSession()->getUser();
	}
}
?>