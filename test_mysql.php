<?php
$con1 = mysqli_connect("localhost", "root", "", "test");
$con2 = mysqli_connect("localhost", "root", "", "test");
if (mysqli_connect_errno()) {
    echo "连接 MySQL 失败: " . mysqli_connect_error();
}

// 执行查询
mysqli_query($con1, "
CREATE TABLE IF NOT EXISTS `vote_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(32) NOT NULL,
  `vote_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_user_id` (`user_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
") or var_dump(mysqli_error($con1));

mysqli_query($con1, "
CREATE PROCEDURE IF NOT EXISTS `vote_record`(IN n int)
BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE s FLOAT DEFAULT 0;
    WHILE (i <= n) DO
        SET s = RAND();
        INSERT INTO vote_record VALUES (NULL, MD5(s), FLOOR(s * 1000), FLOOR(s * 100), NOW());
        SET i = i + 1;
    END WHILE;
END
") or var_dump(mysqli_error($con1));

mysqli_query($con1, "CALL vote_record(1000000)", MYSQLI_ASYNC);
mysqli_query($con2, "CALL vote_record(1000000)", MYSQLI_ASYNC);
$read = $errors = $reject = [$con1, $con2];
mysqli_poll($read, $errors, $reject, 1) or var_dump(mysqli_error($con1));

mysqli_close($con1);
