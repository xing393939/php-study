<?php

$con = mysqli_connect("localhost", "root", "", "test");
if (mysqli_connect_errno()) {
    echo "连接 MySQL 失败: " . mysqli_connect_error();
}

// 执行查询
mysqli_query($con, "
CREATE TABLE IF NOT EXISTS `vote_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(32) NOT NULL,
  `vote_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_user_id` (`user_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
") or var_dump(mysqli_error($con));

mysqli_query($con, "
CREATE PROCEDURE IF NOT EXISTS `vote_record`(IN n int)
BEGIN
    DECLARE i INT DEFAULT 1;
    WHILE (i <= n) DO
        INSERT INTO vote_record (user_id, vote_id, group_id, create_time) VALUES (MD5(RAND()), FLOOR(RAND() * 1000), FLOOR(RAND() * 100), NOW());
        SET i = i + 1;
    END WHILE;
END
") or var_dump(mysqli_error($con));

mysqli_query($con, "CALL vote_record(1000000)") or var_dump(mysqli_error($con));
mysqli_close($con);
