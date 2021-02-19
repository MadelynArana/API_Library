DELIMITER // ;
 CREATE PROCEDURE ps_author(IN p_code INT,IN p_name VARCHAR(50), IN p_surname VARCHAR(70))
 BEGIN

IF p_code=0 THEN
INSERT INTO tb_author(name_author,sur_name)VALUES(p_name,p_surname);
 ELSE
UPDATE tb_author SET name_author=p_name, sur_name=p_surname WHERE id=p_code;
 END IF;
 END //
