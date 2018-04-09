<?php

class DataTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function it_generates_a_correct_data_object()
    {
        $data = new \Fcm\Push\Data();
        $data
            ->addRecipient('device_1')
            ->addData('key', 'value');

        $expected = [
            'to' => 'device_1',
            'data' => [
                'key' => 'value',
            ],
        ];

        $this->assertSame($expected, $data->getBody());
    }

    /**
     * @test
     *
     * @expectedException \Fcm\Exception\NotificationException
     * @expectedExceptionMessage Must minimaly specify a single recipient or topic.
     */
    public function it_can_not_have_no_recipients_or_topics()
    {
        $data = new \Fcm\Push\Data();
        $data->addData('key', 'value');

        $data->getBody();
    }

    /**
     * @test
     *
     * @expectedException \Fcm\Exception\NotificationException
     * @expectedExceptionMessage Must either specify a recipient or topic, not more then one.
     */
    public function it_can_not_have_a_recipient_and_topic()
    {
        $data = new \Fcm\Push\Data();
        $data
            ->addRecipient('device')
            ->addTopic('topic')
            ->addData('key', 'value');

        $data->getBody();
    }

    /**
     * @test
     *
     * @expectedException \Fcm\Exception\NotificationException
     * @expectedExceptionMessage Data should not be empty for a Data Notification.
     */
    public function it_should_always_have_data_parameters()
    {
        $data = new \Fcm\Push\Data();

        $data->getBody();
    }

    /** @test */
    public function it_can_generate_a_data_push_for_multiple_recipients()
    {
        $data = new \Fcm\Push\Data();
        $data
            ->addRecipient('device_1')
            ->addRecipient(['device_2', 'device_3'])
            ->addData('key', 'value');

        $expected = [
            'registration_ids' => [
                'device_1',
                'device_2',
                'device_3',
            ],
            'data' => [
                'key' => 'value',
            ],
        ];

        $this->assertSame($expected, $data->getBody());
    }

    /** @test */
    public function it_can_generate_a_data_push_for_multiple_topics()
    {
        $data = new \Fcm\Push\Data();
        $data
            ->addData('test', 'value')
            ->addTopic(['news', 'weather'])
            ->addTopic('personal');

        $expected = [
            'condition' => "'news' in topics||'weather' in topics||'personal' in topics",
            'data' => [
                'test' => 'value',
            ],
        ];

        $this->assertSame($expected, $data->getBody());
    }

    /** @test */
    public function it_can_generate_a_data_push_with_data()
    {
        $data = new \Fcm\Push\Data();
        $data
            ->addRecipient('device')
            ->addData('key', 'value')
            ->addData('name', 'notification')
            ->addData('test', 'data');

        $expected = [
            'to' => 'device',
            'data' => [
                'key' => 'value',
                'name' => 'notification',
                'test' => 'data',
            ],
        ];

        $this->assertSame($expected, $data->getBody());
    }

    /** @test */
    public function it_can_generate_a_quick_object_from_magic_method()
    {
        $client = \Fcm\FcmClient::create('', '');

        $data = $client->pushData([
            'sample' => 'example',
            'my_name' => 'john doe',
        ], 'device_id');

        $expected = [
            'to' => 'device_id',
            'data' => [
                'sample' => 'example',
                'my_name'  => 'john doe',
            ],
        ];

        $this->assertSame($expected, $data->getBody());
    }
}
