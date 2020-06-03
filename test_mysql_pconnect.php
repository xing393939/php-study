<?php
//获取php的进程id
echo "process id: " . posix_getpid();

//主机名前面加上p:表示长连接
$conn = new mysqli("p:localhost", "root", "Root!!2018", "db_wuhan_new");
if (mysqli_connect_errno()) {
    echo "<br/>mysql error: " . mysqli_connect_errno() . mysqli_connect_error();
    die();
}

// 获取mysql的连接线程id方法1
echo "<br>mysqli_thread_id: " . mysqli_thread_id($conn);

// 获取mysql的连接线程id方法2
$sql = "SELECT CONNECTION_ID()";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
print_r("<br/>");
print_r($row);