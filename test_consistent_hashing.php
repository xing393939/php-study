<?php

// 一致性哈希算法
class ConsistentHashing
{
    protected $nodes = array();    //真实节点
    protected $position = array();  //虚拟节点
    protected $mul = 64;  // 每个节点对应64个虚拟节点

    /**
     * 把字符串转为32位符号整数
     */
    public function hash($str)
    {
        return sprintf('%u', crc32($str));
    }

    /**
     * 核心功能
     */
    public function lookup($key)
    {
        $point = $this->hash($key);

        //先取圆环上最小的一个节点,当成结果
        $node = current($this->position);

        // 循环获取相近的节点
        foreach ($this->position as $key => $val) {
            if ($point <= $key) {
                $node = $val;
                break;
            }
        }

        //把数组的内部指针指向第一个元素，便于下次查询从头查找
        reset($this->position);

        return $node;
    }

    /**
     * 添加节点
     */
    public function addNode($node)
    {
        if (isset($this->nodes[$node])) return;

        // 添加节点和虚拟节点
        for ($i = 0; $i < $this->mul; $i++) {
            $pos = $this->hash($node . '-' . $i);
            $this->position[$pos] = $node;
            $this->nodes[$node][] = $pos;
        }

        // 重新排序
        $this->sortPos();
    }

    /**
     * 删除节点
     */
    public function delNode($node)
    {
        if (!isset($this->nodes[$node])) return;

        // 循环删除虚拟节点
        foreach ($this->nodes[$node] as $val) {
            unset($this->position[$val]);
        }

        // 删除节点
        unset($this->nodes[$node]);
    }

    /**
     * 排序
     */
    public function sortPos()
    {
        ksort($this->position, SORT_REGULAR);
    }
}

// 测试
error_reporting(0);
$con = new ConsistentHashing();

$con->addNode('127.0.0.1');
$con->addNode('127.0.0.2');
$con->addNode('127.0.0.3');
$record1 = [];
$userMap = [];
for ($i = 1; $i <= 50000; $i++) {
    $server = $con->lookup($i);
    $userMap[$i] = $server;
    $record1[$server]++;
}
$con->addNode('127.0.0.4');
$record2 = [];
$changedMap = [];
for ($i = 1; $i <= 50000; $i++) {
    $server = $con->lookup($i);
    if ($userMap[$i] != $server) {
        $changedMap[$userMap[$i]]++;
    }
    $record2[$server]++;
}
var_dump($record1, $record2, $changedMap);


