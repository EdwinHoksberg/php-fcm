<?php

class UnsubscribeTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function it_generates_a_correct_unsubscribe_object()
    {
        $unsubscribe = new \Fcm\Topic\Unsubscribe('the_topic');
        $unsubscribe->addDevice('device_1');

        $expected = [
            'to' => '/topics/the_topic',
            'registration_tokens' => [
                'device_1',
            ],
        ];

        $this->assertSame($expected, $unsubscribe->getBody());
        $this->assertSame('https://iid.googleapis.com/iid/v1:batchRemove', $unsubscribe->getUrl());
    }

    /** @test */
    public function it_can_unsubscribe_multiple_devices_to_topic()
    {
        $unsubscribe = new \Fcm\Topic\Unsubscribe('news');
        $unsubscribe
            ->addDevice('device_1')
            ->addDevice(['device_new', 'test_device']);

        $expected = [
            'to' => '/topics/news',
            'registration_tokens' => [
                'device_1',
                'device_new',
                'test_device',
            ],
        ];

        $this->assertSame($expected, $unsubscribe->getBody());
    }

    /**
     * @test
     *
     * @expectedException \Fcm\Exception\TopicException
     * @expectedExceptionMessage Device id is empty
     */
    public function it_can_not_use_an_empty_deviceId()
    {
        $unsubscribe = new \Fcm\Topic\Unsubscribe('news');
        $unsubscribe->addDevice('');
    }

    /** @test */
    public function it_can_generate_a_quick_object_from_magic_method()
    {
        $client = new \Fcm\FcmClient('', '');

        $unsubscribe = $client->topicUnsubscribe('topic_name', 'device_identifier');

        $expected = [
            'to' => '/topics/topic_name',
            'registration_tokens' => [
                'device_identifier',
            ],
        ];

        $this->assertSame($expected, $unsubscribe->getBody());
    }
}
