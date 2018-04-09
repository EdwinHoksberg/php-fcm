<?php

class SubscribeTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function it_generates_a_correct_subscribe_object()
    {
        $subscribe = new \Fcm\Topic\Subscribe('the_topic');
        $subscribe->addDevice('device_1');

        $expected = [
            'to' => '/topics/the_topic',
            'registration_tokens' => [
                'device_1',
            ],
        ];

        $this->assertSame($expected, $subscribe->getBody());
        $this->assertSame('https://iid.googleapis.com/iid/v1:batchAdd', $subscribe->getUrl());
    }

    /** @test */
    public function it_can_subscribe_multiple_devices_to_topic()
    {
        $subscribe = new \Fcm\Topic\Subscribe('news');
        $subscribe
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

        $this->assertSame($expected, $subscribe->getBody());
    }

    /**
     * @test
     *
     * @expectedException \Fcm\Exception\TopicException
     * @expectedExceptionMessage Device id is empty
     */
    public function it_can_not_use_an_empty_deviceId()
    {
        $subscribe = new \Fcm\Topic\Subscribe('news');
        $subscribe->addDevice('');
    }

    /** @test */
    public function it_can_generate_a_quick_object_from_magic_method()
    {
        $client = new \Fcm\FcmClient('', '');

        $subscribe = $client->topicSubscribe('topic_name', 'device_identifier');

        $expected = [
            'to' => '/topics/topic_name',
            'registration_tokens' => [
                'device_identifier',
            ],
        ];

        $this->assertSame($expected, $subscribe->getBody());
    }
}
