<?php
//��ȡphp�Ľ���id
echo "process id: " . posix_getpid();

//������ǰ�����p:��ʾ������
$conn = new mysqli("p:localhost", "root", "Root!!2018", "db_wuhan_new");
if (mysqli_connect_errno()) {
    echo "<br/>mysql error: " . mysqli_connect_errno() . mysqli_connect_error();
    die();
}

// ��ȡ�����߳�id��Ȼ����mysql��ִ��show processlist;���Ա�
// ��ȡmysql�������߳�id����1
echo "<br>mysqli_thread_id: " . mysqli_thread_id($conn);

// ��ȡmysql�������߳�id����2
$sql = "SELECT CONNECTION_ID()";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
print_r("<br/>");
print_r($row);

// ��ȡwait_timeout��interactive_timeout
$sql = 'show variables like "%_timeout"';
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
print_r("<pre>");
print_r($row);
