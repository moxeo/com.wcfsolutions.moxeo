<?php
/**
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.php>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
$packageID = $this->installation->getPackageID();
$parentPackageID = $this->installation->getPackage()->getParentPackageID();
$filename = 'default-theme.tgz';

// extract theme tar
$sourceFile = $this->installation->getArchive()->extractTar($filename, 'theme_');

// import theme
require_once(WCF_DIR.'lib/data/theme/ThemeEditor.class.php');
$theme = ThemeEditor::import($sourceFile, $packageID);

// delete tmp file
@unlink($sourceFile);

// create default contents
if ($theme->themeID) {
	// create theme layout
	require_once(WCF_DIR.'lib/data/theme/layout/ThemeLayoutEditor.class.php');
	$themeLayout = ThemeLayoutEditor::create($theme->themeID, 'Default', 'global', $packageID);
	$themeLayout->setAsDefault($parentPackageID);
	
	// create default modules
	require_once(WCF_DIR.'lib/data/theme/module/ThemeModuleEditor.class.php');
	$headerThemeModule = ThemeModuleEditor::create($theme->themeID, 'Page Title', '', '', 'html', array('code' => '{PAGE_TITLE}', 'dynamicCode' => '<?php echo StringUtil::encodeHTML(PAGE_TITLE); ?>'), $packageID);
	$mainNavigationThemeModule = ThemeModuleEditor::create($theme->themeID, 'Main Menu', 'mainMenu', '', 'navigation', array('levelOffset' => 0, 'levelLimit' => 1), $packageID);
	$subNavigationThemeModule = ThemeModuleEditor::create($theme->themeID, 'Sub Menu', 'subMenu', '', 'navigation', array('levelOffset' => 1, 'levelLimit' => 5), $packageID);
	$breadCrumbThemeModule = ThemeModuleEditor::create($theme->themeID, 'Bread Crumbs', '', '', 'breadCrumb', array(), $packageID);
	$articleThemeModule = ThemeModuleEditor::create($theme->themeID, 'Article', '', '', 'article', array(), $packageID);
	
	// add modules to layout
	$themeLayout->addThemeModule($headerThemeModule->themeModuleID, 'header');
	$themeLayout->addThemeModule($mainNavigationThemeModule->themeModuleID, 'header');
	$themeLayout->addThemeModule($subNavigationThemeModule->themeModuleID, 'left');
	$themeLayout->addThemeModule($breadCrumbThemeModule->themeModuleID, 'main');
	$themeLayout->addThemeModule($articleThemeModule->themeModuleID, 'main');
}
?>