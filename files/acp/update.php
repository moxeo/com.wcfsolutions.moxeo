<?php
/**
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
$packageID = $this->installation->getPackageID();

// delete deprecated files
$deprecatedFiles = array(
	'icon/newsArchiveAddL.png',
	'icon/newsArchiveAddM.png',
	'icon/newsArchiveEditL.png',
	'icon/newsArchiveL.png',
	'icon/newsArchiveM.png',
	'icon/newsItemAddL.png',
	'icon/newsItemAddM.png',
	'icon/newsItemEditL.png',
	'icon/newsItemL.png',
	'icon/newsItemM.png',
	'lib/acp/action/AbstractNewsItemAction.class.php',
	'lib/acp/action/NewsArchiveDeleteAction.class.php',
	'lib/acp/action/NewsItemDeleteAction.class.php',
	'lib/acp/action/NewsItemDisableAction.class.php',
	'lib/acp/action/NewsItemEnableAction.class.php',
	'lib/acp/form/NewsArchiveAddForm.class.php',
	'lib/acp/form/NewsArchiveEditForm.class.php',
	'lib/acp/form/NewsItemAddForm.class.php',
	'lib/acp/form/NewsItemEditForm.class.php',
	'lib/acp/page/NewsArchiveListPage.class.php',
	'lib/acp/page/NewsItemListPage.class.php',
	'lib/data/news/archive/NewsArchive.class.php',
	'lib/data/news/archive/NewsArchiveEditor.class.php',
	'lib/data/news/archive/NewsArchiveList.class.php',
	'lib/data/news/NewsItem.class.php',
	'lib/data/news/NewsItemCommentableObject.class.php',
	'lib/data/news/NewsItemCommentableObjectType.class.php',
	'lib/data/news/NewsItemEditor.class.php',
	'lib/data/news/NewsItemList.class.php',
	'lib/data/theme/module/type/NewsItemListThemeModuleType.class.php',
	'lib/data/theme/module/type/NewsItemThemeModuleType.class.php',
	'lib/page/element/NewsItemListPageElement.class.php',
	'lib/page/element/NewsItemPageElement.class.php',
	'lib/system/cache/CacheBuilderNewsArchive.class.php'
);

$sql = "DELETE FROM	wcf".WCF_N."_package_installation_file_log
	WHERE		filename IN ('".implode("','", array_map('escapeString', $deprecatedFiles))."')
			AND packageID = ".$packageID;
WCF::getDB()->sendQuery($sql);

foreach ($deprecatedFiles as $file) {
	@unlink(RELATIVE_WCF_DIR.$this->installation->getPackage()->getDir().$file);
}

// delete deprecated templates
$deprecatedTemplates = array(
	'newsItem',
	'newsItemList'
);

$sql = "DELETE FROM	wcf".WCF_N."_template
	WHERE		templateName IN ('".implode("','", array_map('escapeString', $deprecatedTemplates))."')
			AND packageID = ".$packageID;
WCF::getDB()->sendQuery($sql);

foreach ($deprecatedTemplates as $template) {
	@unlink(RELATIVE_WCF_DIR.$this->installation->getPackage()->getDir().'templates/'.$template.'.tpl');
}

// delete deprecated acp templates
$deprecatedACPTemplates = array(
	'newsArchiveAdd',
	'newsArchiveList',
	'newsItemAdd',
	'newsItemList',
	'newsItemListThemeModuleType',
	'newsItemThemeModuleType'
);

$sql = "DELETE FROM	wcf".WCF_N."_acp_template
	WHERE		templateName IN ('".implode("','", array_map('escapeString', $deprecatedACPTemplates))."')
			AND packageID = ".$packageID;
WCF::getDB()->sendQuery($sql);

foreach ($deprecatedACPTemplates as $template) {
	@unlink(RELATIVE_WCF_DIR.$this->installation->getPackage()->getDir().'acp/templates/'.$template.'.tpl');
}

// delete obsolete language items
$deprecatedLanguageItems = array(
	'wcf.acp.group.option.admin.moxeo.canAddNewsArchive',
	'wcf.acp.group.option.admin.moxeo.canAddNewsArchive.description',
	'wcf.acp.group.option.admin.moxeo.canAddNewsItem',
	'wcf.acp.group.option.admin.moxeo.canAddNewsItem.description',
	'wcf.acp.group.option.admin.moxeo.canDeleteNewsArchive',
	'wcf.acp.group.option.admin.moxeo.canDeleteNewsArchive.description',
	'wcf.acp.group.option.admin.moxeo.canDeleteNewsItem',
	'wcf.acp.group.option.admin.moxeo.canDeleteNewsItem.description',
	'wcf.acp.group.option.admin.moxeo.canEditNewsArchive',
	'wcf.acp.group.option.admin.moxeo.canEditNewsArchive.description',
	'wcf.acp.group.option.admin.moxeo.canEditNewsItem',
	'wcf.acp.group.option.admin.moxeo.canEditNewsItem.description',
	'wcf.acp.group.option.admin.moxeo.canEnableNewsItem',
	'wcf.acp.group.option.admin.moxeo.canEnableNewsItem.description',
	'wcf.acp.group.option.category.admin.moxeo.news',
	'wcf.acp.group.option.category.admin.moxeo.news.description',
	'wcf.theme.module.type.category.news',
	'wcf.theme.module.type.newsItem',
	'wcf.theme.module.type.newsItemList',
	'moxeo.acp.menu.link.content.news',
	'moxeo.acp.menu.link.content.newsArchive.add',
	'moxeo.acp.menu.link.content.newsArchive.view',
	'moxeo.acp.menu.link.content.newsItem.add',
	'moxeo.acp.menu.link.content.newsItem.view',
	'moxeo.acp.news.archive',
	'moxeo.acp.news.archive.add',
	'moxeo.acp.news.archive.add.success',
	'moxeo.acp.news.archive.contentItemID',
	'moxeo.acp.news.archive.contentItemID.description',
	'moxeo.acp.news.archive.data',
	'moxeo.acp.news.archive.delete',
	'moxeo.acp.news.archive.delete.success',
	'moxeo.acp.news.archive.delete.sure',
	'moxeo.acp.news.archive.description',
	'moxeo.acp.news.archive.edit',
	'moxeo.acp.news.archive.edit.success',
	'moxeo.acp.news.archive.newsArchiveID',
	'moxeo.acp.news.archive.newsItems',
	'moxeo.acp.news.archive.title',
	'moxeo.acp.news.archive.title.description',
	'moxeo.acp.news.archive.view',
	'moxeo.acp.news.archive.view.count',
	'moxeo.acp.news.archive.view.count.noNewsArchives',
	'moxeo.acp.news.item.add',
	'moxeo.acp.news.item.add.success',
	'moxeo.acp.news.item.cssClasses',
	'moxeo.acp.news.item.cssClasses.description',
	'moxeo.acp.news.item.cssID',
	'moxeo.acp.news.item.cssID.description',
	'moxeo.acp.news.item.data',
	'moxeo.acp.news.item.delete',
	'moxeo.acp.news.item.delete.success',
	'moxeo.acp.news.item.delete.sure',
	'moxeo.acp.news.item.disable',
	'moxeo.acp.news.item.display',
	'moxeo.acp.news.item.edit',
	'moxeo.acp.news.item.edit.success',
	'moxeo.acp.news.item.enable',
	'moxeo.acp.news.item.enableComments',
	'moxeo.acp.news.item.enableComments.description',
	'moxeo.acp.news.item.newsArchiveID',
	'moxeo.acp.news.item.newsArchiveID.description',
	'moxeo.acp.news.item.newsItemAlias',
	'moxeo.acp.news.item.newsItemAlias.description',
	'moxeo.acp.news.item.newsItemID',
	'moxeo.acp.news.item.publishingEndTime',
	'moxeo.acp.news.item.publishingEndTime.description',
	'moxeo.acp.news.item.publishingEndTime.error.invalid',
	'moxeo.acp.news.item.publishingStartTime',
	'moxeo.acp.news.item.publishingStartTime.description',
	'moxeo.acp.news.item.publishingStartTime.error.invalid',
	'moxeo.acp.news.item.publishingTime',
	'moxeo.acp.news.item.publishingTime.from',
	'moxeo.acp.news.item.publishingTime.until',
	'moxeo.acp.news.item.teaser',
	'moxeo.acp.news.item.teaser.description',
	'moxeo.acp.news.item.text',
	'moxeo.acp.news.item.text.description',
	'moxeo.acp.news.item.time',
	'moxeo.acp.news.item.title',
	'moxeo.acp.news.item.title.description',
	'moxeo.acp.news.item.username',
	'moxeo.acp.news.item.username.description',
	'moxeo.acp.news.item.view',
	'moxeo.acp.news.item.view.count',
	'moxeo.acp.news.item.view.count.noNewsArchives',
	'moxeo.acp.news.item.view.count.noNewsItems',
	'moxeo.acp.theme.module.newsItem.data',
	'moxeo.acp.theme.module.newsItem.displayType',
	'moxeo.acp.theme.module.newsItem.displayType.description',
	'moxeo.acp.theme.module.newsItem.displayType.full',
	'moxeo.acp.theme.module.newsItem.displayType.short',
	'moxeo.acp.theme.module.newsItem.newsArchiveIDs',
	'moxeo.acp.theme.module.newsItem.newsArchiveIDs.description',
	'moxeo.acp.theme.module.newsItemList.data',
	'moxeo.acp.theme.module.newsItemList.displayType',
	'moxeo.acp.theme.module.newsItemList.displayType.description',
	'moxeo.acp.theme.module.newsItemList.displayType.full',
	'moxeo.acp.theme.module.newsItemList.displayType.short',
	'moxeo.acp.theme.module.newsItemList.newsArchiveIDs',
	'moxeo.acp.theme.module.newsItemList.newsArchiveIDs.description',
	'moxeo.acp.theme.module.newsItemList.newsItemsPerPage',
	'moxeo.acp.theme.module.newsItemList.newsItemsPerPage.description',
	'moxeo.comment.commentableObjectType.newsItem'
);
$sql = "DELETE FROM	wcf".WCF_N."_language_item
	WHERE		languageItem IN ('".implode("','", $deprecatedLanguageItems)."')
			AND packageID = ".$packageID;
WCF::getDB()->sendQuery($sql);
?>