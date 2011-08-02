-- update comment structure
ALTER TABLE wsis1_1_comment DROP INDEX articleSectionID;
ALTER TABLE wsis1_1_comment CHANGE articleSectionID commentObjectID INT(10) NOT NULL DEFAULT 0;
ALTER TABLE wsis1_1_comment ADD commentObjectType VARCHAR(255) NOT NULL DEFAULT '' AFTER commentObjectID;
ALTER TABLE wsis1_1_comment ADD KEY (commentObjectID, commentObjectType);

-- update existing comments
UPDATE	wsis1_1_comment
SET	commentObjectType = 'articleSection';