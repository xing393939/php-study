<?php
//获取php的进程id
echo "process id: " . posix_getpid();

//主机名前面加上p:表示长连接
$conn = new mysqli("p:localhost", "root", "Root!!2018", "db_wuhan_new");
if (mysqli_connect_errno()) {
    echo "<br/>mysql error: " . mysqli_connect_errno() . mysqli_connect_error();
    die();
}

// 获取连接线程id，然后在mysql中执行show processlist;做对比
// 获取mysql的连接线程id方法1
echo "<br>mysqli_thread_id: " . mysqli_thread_id($conn);

// 获取mysql的连接线程id方法2
$sql = "SELECT CONNECTION_ID()";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
print_r("<br/>");
print_r($row);

// 获取wait_timeout和interactive_timeout
$sql = 'show variables like "%_timeout"';
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
print_r("<pre>");
print_r($row);
