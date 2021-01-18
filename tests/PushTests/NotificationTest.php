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
            'notification' => [
                'title' => 'Test title',
                'body'  => 'A small body as an example',
                'sound'  => '',
                'icon'  => '',
                'color'  => '',
                'tag'  => '',
                'subtitle'  => '',
            ],
            'data' => [
                'key' => 'value',
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
            ->addRecipient(['device_2', 'device_3'])
            ->addData('key', 'value');

        $expected = [
            'registration_ids' => [
                'device_1',
                'device_2',
                'device_3',
            ],
            'notification' => [
                'title' => 'Test title',
                'body'  => '',
                'sound'  => '',
                'icon'  => '',
                'color'  => '',
                'tag'  => '',
                'subtitle'  => '',
            ],
            'data' => [
                'key' => 'value',
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
            ->addTopic('personal')
            ->addData('key', 'value');

        $expected = [
            'condition' => "'news' in topics||'weather' in topics||'personal' in topics",
            'notification' => [
                'title' => 'Test title',
                'body'  => '',
            ],
            'notification' => [
                'title' => 'Test title',
                'body'  => '',
                'sound'  => '',
                'icon'  => '',
                'color'  => '',
                'tag'  => '',
                'subtitle'  => '',
            ],
            'data' => [
                'key' => 'value',
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
            'notification' => [
                'title' => 'Test title',
                'body'  => '',
                'sound'  => '',
                'icon'  => '',
                'color'  => '',
                'tag'  => '',
                'subtitle'  => '',
            ],
            'data' => [
                'key' => 'value',
                'name' => 'notification',
                'test' => 'data',
            ],
        ];

        $this->assertSame($expected, $notification->getBody());
    }


    /** @test */
    public function it_can_generate_a_notification_with_no_data()
    {
        $notification = new \Fcm\Push\Notification();
        $notification
            ->setTitle('Test title')
            ->addRecipient('device');

        $expected = [
            'to' => 'device',
            'notification' => [
                'title' => 'Test title',
                'body'  => '',
                'sound'  => '',
                'icon'  => '',
                'color'  => '',
                'tag'  => '',
                'subtitle'  => '',
            ],
        ];

        $this->assertSame($expected, $notification->getBody());
    }


    /** @test */
    public function it_can_generate_a_notification_with_add_data_array()
    {
        $notification = new \Fcm\Push\Notification();
        $notification
            ->setTitle('Test title')
            ->addRecipient('device')
            ->addDataArray(
                array(
                    'key'=>'value',
                    'name'=>'notification',
                    'test'=>'data',
                    )
                );

        $expected = [
            'to' => 'device',
            'notification' => [
                'title' => 'Test title',
                'body'  => '',
                'sound'  => '',
                'icon'  => '',
                'color'  => '',
                'tag'  => '',
                'subtitle'  => '',
            ],
            'data' => [
                'key' => 'value',
                'name' => 'notification',
                'test' => 'data',
            ],
        ];

        $this->assertSame($expected, $notification->getBody());
    }


    /**
     * @test
     *
     * @expectedException \Fcm\Exception\NotificationException
     * @expectedExceptionMessage Data must be an asscoiative array of ("key" => "value") pairs.
     */
    public function it_will_throw_an_exception_if_data_is_not_an_asscoiative_array()
    {
        $notification = new \Fcm\Push\Notification();
        $notification
            ->setTitle('Test title')
            ->addRecipient('device')
            ->addDataArray('array');

        $notification->getBody();
    }


    /** @test */
    public function it_can_generate_a_notification_with_add_data_array_twice()
    {
        $notification = new \Fcm\Push\Notification();
        $notification
            ->setTitle('Test title')
            ->addRecipient('device')
            ->addDataArray(
                array(
                    'i1'=>'the value of one',
                    'i2'=>'the value of two',
                    'i3'=>'the value of three',
                    )
                )
            ->addDataArray(
                array(
                    'i4'=>'the value of four',
                    'i5'=>'the value of five',
                    'i6'=>'the value of six',
                    )
                );

        $expected = [
            'to' => 'device',
            'notification' => [
                'title' => 'Test title',
                'body'  => '',
                'sound'  => '',
                'icon'  => '',
                'color'  => '',
                'tag'  => '',
                'subtitle'  => '',
            ],
            'data' => [
                'i1'=>'the value of one',
                'i2'=>'the value of two',
                'i3'=>'the value of three',
                'i4'=>'the value of four',
                'i5'=>'the value of five',
                'i6'=>'the value of six',
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
                'sound'  => '',
                'icon'  => '',
                'color'  => '',
                'tag'  => '',
                'subtitle'  => '',
            ],
        ];

        $this->assertSame($expected, $notification->getBody());
    }


    /** @test */
    public function it_generates_a_correct_notification_object_setting_sound()
    {
        $notification = new \Fcm\Push\Notification();
        $notification
            ->setTitle('Test title')
            ->addRecipient('device')
            ->addData('key', 'value');

        $notification->setSound('my sound');

        $expected = [
            'to' => 'device',
            'notification' => [
                'title' => 'Test title',
                'body'  => '',
                'sound'  => 'my sound',
                'icon'  => '',
                'color'  => '',
                'tag'  => '',
                'subtitle'  => '',
            ],
            'data' => [
                'key' => 'value',
            ],
        ];
        $this->assertSame($expected, $notification->getBody());
    }


    /** @test */
    public function it_generates_a_correct_notification_object_setting_badge()
    {
        $notification = new \Fcm\Push\Notification();
        $notification
            ->setTitle('Test title')
            ->addRecipient('device')
            ->addData('key', 'value');

        $notification->setBadge(1);

        $expected = [
            'to' => 'device',
            'notification' => [
                'title' => 'Test title',
                'body'  => '',
                'sound'  => '',
                'icon'  => '',
                'color'  => '',
                'tag'  => '',
                'subtitle'  => '',
                'badge'  => 1,
            ],
            'data' => [
                'key' => 'value',
            ],
        ];
        $this->assertSame($expected, $notification->getBody());
    }


    /** @test */
    public function it_generates_a_correct_notification_object_setting_tag()
    {
        $notification = new \Fcm\Push\Notification();
        $notification
            ->setTitle('Test title')
            ->addRecipient('device')
            ->addData('key', 'value');

        $notification->setTag('my tag');

        $expected = [
            'to' => 'device',
            'notification' => [
                'title' => 'Test title',
                'body'  => '',
                'sound'  => '',
                'icon'  => '',
                'color'  => '',
                'tag'  => 'my tag',
                'subtitle'  => '',
            ],
            'data' => [
                'key' => 'value',
            ],
        ];
        $this->assertSame($expected, $notification->getBody());
    }


    /** @test */
    public function it_generates_a_correct_notification_object_setting_subtitle()
    {
        $notification = new \Fcm\Push\Notification();
        $notification
            ->setTitle('Test title')
            ->addRecipient('device')
            ->addData('key', 'value');

        $notification->setSubtitle('my subtitle');

        $expected = [
            'to' => 'device',
            'notification' => [
                'title' => 'Test title',
                'body'  => '',
                'sound'  => '',
                'icon'  => '',
                'color'  => '',
                'tag'  => '',
                'subtitle'  => 'my subtitle',
            ],
            'data' => [
                'key' => 'value',
            ],
        ];
        $this->assertSame($expected, $notification->getBody());
    }
    

    /** @test */
    public function it_generates_a_correct_notification_object_setting_color()
    {
        $notification = new \Fcm\Push\Notification();
        $notification
            ->setTitle('Test title')
            ->addRecipient('device')
            ->addData('key', 'value');

        $notification->setColor('my color');

        $expected = [
            'to' => 'device',
            'notification' => [
                'title' => 'Test title',
                'body'  => '',
                'sound'  => '',
                'icon'  => '',
                'color'  => 'my color',
                'tag'  => '',
                'subtitle'  => '',
            ],
            'data' => [
                'key' => 'value',
            ],
        ];
        $this->assertSame($expected, $notification->getBody());
    }


    /** @test */
    public function it_generates_a_correct_notification_object_setting_icon()
    {
        $notification = new \Fcm\Push\Notification();
        $notification
            ->setTitle('Test title')
            ->addRecipient('device')
            ->addData('key', 'value');

        $notification->setIcon('my icon');

        $expected = [
            'to' => 'device',
            'notification' => [
                'title' => 'Test title',
                'body'  => '',
                'sound'  => '',
                'icon'  => 'my icon',
                'color'  => '',
                'tag'  => '',
                'subtitle'  => '',
            ],
            'data' => [
                'key' => 'value',
            ],
        ];
        $this->assertSame($expected, $notification->getBody());
    }

    /** @test */
    public function it_generates_a_correct_notification_object_setting_click_action()
    {
        $notification = new \Fcm\Push\Notification();
        $notification
            ->setTitle('Test title')
            ->addRecipient('device')
            ->addData('key', 'value');

        $notification->setClickAction('MAIN_ACTIVITY');

        $expected = [
            'to' => 'device',
            'notification' => [
                'title' => 'Test title',
                'body'  => '',
                'sound'  => '',
                'icon'  => '',
                'color'  => '',
                'tag'  => '',
                'subtitle'  => '',
                'click_action' => 'MAIN_ACTIVITY'
            ],
            'data' => [
                'key' => 'value',
            ],
        ];
        $this->assertSame($expected, $notification->getBody());
    }


    /** @test */
    public function it_generates_a_correct_notification_object_no_click_action()
    {
        $notification = new \Fcm\Push\Notification();
        $notification
            ->setTitle('Test title')
            ->addRecipient('device')
            ->addData('key', 'value');

        $expected = [
            'to' => 'device',
            'notification' => [
                'title' => 'Test title',
                'body'  => '',
                'sound'  => '',
                'icon'  => '',
                'color'  => '',
                'tag'  => '',
                'subtitle'  => '',
            ],
            'data' => [
                'key' => 'value',
            ],
        ];
        $this->assertSame($expected, $notification->getBody());
    }

}
