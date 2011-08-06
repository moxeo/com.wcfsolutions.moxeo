-- update comment structure
ALTER TABLE wsis1_1_comment CHANGE commentObjectID commentableObjectID INT(10) NOT NULL DEFAULT 0;
ALTER TABLE wsis1_1_comment CHANGE commentObjectType commentableObjectType VARCHAR(255) NOT NULL DEFAULT '';

-- add new table
DROP TABLE IF EXISTS wsis1_1_commentable_object_type;
CREATE TABLE wsis1_1_commentable_object_type (
	commentableObjectTypeID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	packageID INT(10) NOT NULL,
	commentableObjectType VARCHAR(255) NOT NULL UNIQUE KEY,
	classFile VARCHAR(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;