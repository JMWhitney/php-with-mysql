-- Example SQL commands for our pages table --

CREATE TABLE pages (
    id INT(11) NOT NULL AUTO_INCREMENT,
    subject_id INT(11),
    menu_name VARCHAR(255),
    position INT(3),
    visible TINYINT(1),
    content TEXT,
    PRIMARY KEY (id)
);

ALTER TABLE pages ADD INDEX fk_subject_id (subject_id);

SELECT * FROM subjects;

INSERT INTO pages (subject_id, menu_name, position, visible) VALUES (1, 'Globe Bank', 1, 1);
INSERT INTO pages (subject_id, menu_name, position, visible) VALUES (1, 'History', 2, 1);
INSERT INTO pages (subject_id, menu_name, position, visible) VALUES (1, 'Leadership', 3, 1);
INSERT INTO pages (subject_id, menu_name, position, visible) VALUES (1, 'Contact Us', 4, 1);
INSERT INTO pages (subject_id, menu_name, position, visible) VALUES (2, 'Banking', 1, 1);
INSERT INTO pages (subject_id, menu_name, position, visible) VALUES (2, 'Credit Cards', 2, 1);
INSERT INTO pages (subject_id, menu_name, position, visible) VALUES (2, 'Mortgages', 3, 1);
INSERT INTO pages (subject_id, menu_name, position, visible) VALUES (3, 'Checking', 1, 1);
INSERT INTO pages (subject_id, menu_name, position, visible) VALUES (3, 'Loans', 2, 1);
INSERT INTO pages (subject_id, menu_name, position, visible) VALUES (3, 'Merchant Services', 3, 1);

-- There was a redudant entry for "Globe Bank" page. Delete the first occurance.
DELETE FROM pages WHERE id='1';

SELECT * FROM pages WHERE id=3;

SELECT id, subject_id FROM pages WHERE id=3;

-- Use foreign key to search related table
SELECT * FROM subjects WHERE id=3;
SELECT * FROM pages WHERE subject_id=2;