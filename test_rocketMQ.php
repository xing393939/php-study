<?php

require "vendor/autoload.php";

use MQ\Model\TopicMessage;
use MQ\MQClient;

define('GROUP_ID', "GID_READ5_DEBUG");
define('MESSAGE_TAG', "TAG_READ5_DEBUG");

if (file_exists(__DIR__ . '/.env')) {
    $arr = explode("\n", file_get_contents(__DIR__ . '/.env'));
    foreach ($arr as $line) {
        $line = trim($line);
        if ($line) putenv($line);
    }
}

class ProducerTest
{
    private $client;
    private $producer;

    public function __construct()
    {
        $this->client = new MQClient(
            getenv('HTTP_ENDPOINT'),
            getenv('ACCESS_KEY'),
            getenv('SECRET_KEY')
        );
        $topic = getenv('TOPIC');
        $instanceId = getenv('INSTANCE_ID');
        $this->producer = $this->client->getProducer($instanceId, $topic);
    }

    public function run()
    {
        for ($i = 1; $i <= 4; $i++) {
            $publishMessage = new TopicMessage(
                "hello mq!"
            );
            $publishMessage->setMessageTag(MESSAGE_TAG);
            $publishMessage->putProperty("a", $i);
            $publishMessage->setMessageKey("MessageKey");
            $result = $this->producer->publishMessage($publishMessage);
            print "msgId is:" . $result->getMessageId() . ", bodyMD5 is:" . $result->getMessageBodyMD5() . "\n";
        }
    }
}

class ConsumerTest
{
    private $client;
    private $consumer;

    public function __construct()
    {
        $this->client = new MQClient(
            getenv('HTTP_ENDPOINT'),
            getenv('ACCESS_KEY'),
            getenv('SECRET_KEY')
        );
        $topic = getenv('TOPIC');
        $groupId = GROUP_ID;
        $instanceId = getenv('INSTANCE_ID');
        $this->consumer = $this->client->getConsumer($instanceId, $topic, $groupId, MESSAGE_TAG);
    }

    public function run()
    {
        // 长轮询消费消息。
        $messages = $this->consumer->consumeMessage(
            3, // 一次最多消费3条（最多可设置为16条）。
            3  // 长轮询时间3秒（最多可设置为30秒）。
        );
        print "consume finish, messages:\n";

        // 处理业务逻辑。
        $receiptHandles = array();
        foreach ($messages as $message) {
            $receiptHandles[] = $message->getReceiptHandle();
            printf(
                "msgId:%s TAG:%s BODY:%s ConsumedTimes:%d NextConsumeTime:%d MessageKey:%s\n",
                $message->getMessageId(), $message->getMessageTag(), $message->getMessageBody(),
                $message->getConsumedTimes(), $message->getNextConsumeTime(), $message->getMessageKey()
            );
        }
    }
}

$instance = new ProducerTest();
$instance->run();

$instance = new ConsumerTest();
$instance->run();

