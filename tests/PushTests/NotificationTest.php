<?php

class NotificationTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function it_generates_a_correct_notification_object()
    {
        $notification = new \Fcm\Push\Notification();
        $notification
            ->setTitle('Test title')
            ->setBody('A small body as an example')
            ->addRecipient('device_1')
            ->addData('key', 'value');

        $expected = [
            'to' => 'device_1',
            'data' => [
                'key' => 'value',
            ],
            'notification' => [
                'title' => 'Test title',
                'body'  => 'A small body as an example',
            ],
        ];

        $this->assertSame($expected, $notification->getBody());
        $this->assertSame('https://fcm.googleapis.com/fcm/send', $notification->getUrl());
    }

    /**
     * @test
     *
     * @expectedException \Fcm\Exception\NotificationException
     * @expectedExceptionMessage Must minimaly specify a single recipient or topic.
     */
    public function it_can_not_have_no_recipients_or_topics()
    {
        $notification = new \Fcm\Push\Notification();
        $notification
            ->setTitle('Test title')
            ->setBody('A small body as an example');

        $notification->getBody();
    }

    /**
     * @test
     *
     * @expectedException \Fcm\Exception\NotificationException
     * @expectedExceptionMessage Must either specify a recipient or topic, not more then one.
     */
    public function it_can_not_have_a_recipient_and_topic()
    {
        $notification = new \Fcm\Push\Notification();
        $notification
            ->setTitle('Test title')
            ->addRecipient('device')
            ->addTopic('topic');

        $notification->getBody();
    }

    /** @test */
    public function it_can_generate_a_notification_for_multiple_recipients()
    {
        $notification = new \Fcm\Push\Notification();
        $notification
            ->setTitle('Test title')
            ->addRecipient('device_1')
            ->addRecipient(['device_2', 'device_3']);

        $expected = [
            'registration_ids' => [
                'device_1',
                'device_2',
                'device_3',
            ],
            'notification' => [
                'title' => 'Test title',
                'body'  => '',
            ],
        ];

        $this->assertSame($expected, $notification->getBody());
    }

    /** @test */
    public function it_can_generate_a_notification_for_multiple_topics()
    {
        $notification = new \Fcm\Push\Notification();
        $notification
            ->setTitle('Test title')
            ->addTopic(['news', 'weather'])
            ->addTopic('personal');

        $expected = [
            'condition' => "'news' in topics||'weather' in topics||'personal' in topics",
            'notification' => [
                'title' => 'Test title',
                'body'  => '',
            ],
        ];

        $this->assertSame($expected, $notification->getBody());
    }

    /** @test */
    public function it_can_generate_a_notification_with_data()
    {
        $notification = new \Fcm\Push\Notification();
        $notification
            ->setTitle('Test title')
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
            'notification' => [
                'title' => 'Test title',
                'body'  => '',
            ],
        ];

        $this->assertSame($expected, $notification->getBody());
    }

    /** @test */
    public function it_can_generate_a_quick_object_from_magic_method()
    {
        $client = \Fcm\FcmClient::create('', '');

        $notification = $client->pushNotification('Sample title', 'Sample body', 'device_id');

        $expected = [
            'to' => 'device_id',
            'notification' => [
                'title' => 'Sample title',
                'body'  => 'Sample body',
            ],
        ];

        $this->assertSame($expected, $notification->getBody());
    }
}
