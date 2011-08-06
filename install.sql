DROP TABLE IF EXISTS wsis1_1_article;
CREATE TABLE wsis1_1_article (
	articleID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	contentItemID INT(10) NOT NULL DEFAULT 0,
	themeModulePosition VARCHAR(255) NOT NULL DEFAULT '',
	title VARCHAR(255) NOT NULL DEFAULT '',
	cssID VARCHAR(255) NOT NULL DEFAULT '',
	cssClasses VARCHAR(255) NOT NULL DEFAULT '',
	showOrder INT(10) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS wsis1_1_article_section;
CREATE TABLE wsis1_1_article_section (
	articleSectionID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	articleID INT(10) NOT NULL DEFAULT 0,
	articleSectionType VARCHAR(125) NOT NULL DEFAULT '',
	articleSectionData MEDIUMTEXT,
	cssID VARCHAR(255) NOT NULL DEFAULT '',
	cssClasses VARCHAR(255) NOT NULL DEFAULT '',
	showOrder INT(10) NOT NULL DEFAULT 0,
	KEY (articleID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS wsis1_1_article_section_type;
CREATE TABLE wsis1_1_article_section_type (
	articleSectionTypeID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	packageID INT(10) NOT NULL,
	articleSectionType VARCHAR(255) NOT NULL,
	category VARCHAR(255) NOT NULL,
	classFile VARCHAR(255) NOT NULL,
	--UNIQUE KEY (packageID, articleSectionType)
	UNIQUE KEY (articleSectionType)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS wsis1_1_captcha;
CREATE TABLE wsis1_1_captcha (
	captchaID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	questionNo INT(10) NOT NULL DEFAULT 0,
	firstValue INT(10) NOT NULL DEFAULT 0,
	secondValue INT(10) NOT NULL DEFAULT 0,
	time INT(10) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS wsis1_1_comment;
CREATE TABLE wsis1_1_comment (
	commentID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	commentableObjectID INT(10) NOT NULL DEFAULT 0,
	commentableObjectType VARCHAR(255) NOT NULL DEFAULT '',
	userID INT(10) NOT NULL DEFAULT 0,
	username VARCHAR(255) NOT NULL DEFAULT '',
	comment TEXT NULL,
	time INT(10) NOT NULL DEFAULT 0,
	ipAddress VARCHAR(15) NOT NULL DEFAULT '',
	KEY (commentableObjectID, commentableObjectType)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS wsis1_1_commentable_object_type;
CREATE TABLE wsis1_1_commentable_object_type (
	commentableObjectTypeID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	packageID INT(10) NOT NULL,
	commentableObjectType VARCHAR(255) NOT NULL UNIQUE KEY,
	classFile VARCHAR(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS wsis1_1_content_item;
CREATE TABLE wsis1_1_content_item (
	contentItemID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	parentID INT(10) NOT NULL DEFAULT 0,
	languageID INT(10) NOT NULL DEFAULT 0,
	userID INT(10) NOT NULL DEFAULT 0,
	title VARCHAR(255) NOT NULL DEFAULT '',
	contentItemAlias VARCHAR(255) NOT NULL DEFAULT '',
	cssClasses VARCHAR(255) NOT NULL DEFAULT '',
	description MEDIUMTEXT,
	pageTitle VARCHAR(255) NOT NULL DEFAULT '',
	metaDescription MEDIUMTEXT,
	metaKeywords VARCHAR(255) NOT NULL DEFAULT '',
	contentItem VARCHAR(255) NOT NULL DEFAULT '',
	contentItemType TINYINT(1) NOT NULL DEFAULT 0,
	externalURL VARCHAR(255) NOT NULL DEFAULT '',
	publishingStartTime INT(10) NOT NULL DEFAULT 0,
	publishingEndTime INT(10) NOT NULL DEFAULT 0,
	themeLayoutID INT(10) NOT NULL DEFAULT 0,
	addSecurityToken TINYINT(1) NOT NULL DEFAULT 0,
	enabled TINYINT(1) NOT NULL DEFAULT 1,
	invisible TINYINT(1) NOT NULL DEFAULT 0,
	robots ENUM('index,follow', 'index,nofollow', 'noindex,follow', 'noindex,nofollow') NOT NULL DEFAULT 'index,follow',
	showOrder INT(10) NOT NULL DEFAULT 0,
	searchableContent MEDIUMTEXT
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS wsis1_1_content_item_admin;
CREATE TABLE wsis1_1_content_item_admin (
	contentItemID INT(10) NOT NULL DEFAULT 0,
	userID INT(10) NOT NULL DEFAULT 0,
	groupID INT(10) NOT NULL DEFAULT 0,
	canAddContentItem TINYINT(1) NOT NULL DEFAULT -1,
	canEditContentItem TINYINT(1) NOT NULL DEFAULT -1,
	canDeleteContentItem TINYINT(1) NOT NULL DEFAULT -1,
	canEnableContentItem TINYINT(1) NOT NULL DEFAULT -1,
	canAddArticle TINYINT(1) NOT NULL DEFAULT -1,
	canEditArticle TINYINT(1) NOT NULL DEFAULT -1,
	canDeleteArticle TINYINT(1) NOT NULL DEFAULT -1,
	KEY (userID),
	KEY (groupID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS wsis1_1_content_item_to_group;
CREATE TABLE wsis1_1_content_item_to_group (
	contentItemID INT(10) NOT NULL DEFAULT 0,
	groupID INT(10) NOT NULL DEFAULT 0,
	canViewContentItem TINYINT(1) NOT NULL DEFAULT -1,
	canEnterContentItem TINYINT(1) NOT NULL DEFAULT -1,
	canViewHiddenContentItem TINYINT(1) NOT NULL DEFAULT -1,
	PRIMARY KEY (groupID, contentItemID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS wsis1_1_content_item_to_user;
CREATE TABLE wsis1_1_content_item_to_user (
	contentItemID INT(10) NOT NULL DEFAULT 0,
	userID INT(10) NOT NULL DEFAULT 0,
	canViewContentItem TINYINT(1) NOT NULL DEFAULT -1,
	canEnterContentItem TINYINT(1) NOT NULL DEFAULT -1,
	canViewHiddenContentItem TINYINT(1) NOT NULL DEFAULT -1,
	PRIMARY KEY (userID, contentItemID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS wsis1_1_news_archive;
CREATE TABLE wsis1_1_news_archive (
	newsArchiveID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(255) NOT NULL DEFAULT '',
	contentItemID INT(10) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS wsis1_1_news_item;
CREATE TABLE wsis1_1_news_item (
	newsItemID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	newsArchiveID INT(10) NOT NULL DEFAULT 0,
	userID INT(10) NOT NULL DEFAULT 0,
	title VARCHAR(255) NOT NULL DEFAULT '',
	newsItemAlias VARCHAR(255) NOT NULL DEFAULT '',
	cssID VARCHAR(255) NOT NULL DEFAULT '',
	cssClasses VARCHAR(255) NOT NULL DEFAULT '',
	teaser TINYTEXT,
	text TEXT NULL,
	time INT(10) NOT NULL DEFAULT 0,
	publishingStartTime INT(10) NOT NULL DEFAULT 0,
	publishingEndTime INT(10) NOT NULL DEFAULT 0,
	enabled TINYINT(1) NOT NULL DEFAULT 1,
	KEY (newsArchiveID),
	KEY (newsArchiveID, enabled, publishingStartTime, publishingEndTime)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;