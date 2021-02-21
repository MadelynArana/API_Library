DELIMITER // ;
	CREATE PROCEDURE ps_author_isert_update(IN p_code INT,IN p_name VARCHAR(50), IN p_surname VARCHAR(70))
 BEGIN
	IF p_code=0 THEN
		INSERT INTO tb_author(name_author,sur_name)VALUES(p_name,p_surname);
	 ELSE
		UPDATE tb_author SET name_author=p_name, sur_name=p_surname WHERE id=p_code;
	 END IF;
 END //

 DELIMITER $$
CREATE 
    PROCEDURE ps_book_id(IN p_id INT)
    BEGIN
	SELECT b.id, b.name_book,b.page_count,b.point_book,b.author_id,b.type_id,a.name_author, a.sur_name FROM tb_book b INNER JOIN
	tb_author a ON a.id=b.author_id WHERE b.id=p_id;
    END$$
DELIMITER ;
