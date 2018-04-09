<?php

class CreateTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function it_generates_a_correct_devicegroup_create_object()
    {
        $create = new \Fcm\DeviceGroup\Create('group_name');
        $create->addDevice('my-phone');

        $expected = [
            'operation' => 'create',
            'notification_key_name' => 'group_name',
            'registration_ids' => [
                'my-phone',
            ]
        ];

        $this->assertSame($expected, $create->getBody());
        $this->assertSame('https://android.googleapis.com/gcm/notification', $create->getUrl());
    }

    /** @test */
    public function it_can_create_a_group_from_multiple_devices()
    {
        $create = new \Fcm\DeviceGroup\Create('group_name');
        $create
            ->addDevice('my-phone')
            ->addDevice(['device_1', 'device_2'])
            ->addDevice('my-tablet');

        $expected = [
            'operation' => 'create',
            'notification_key_name' => 'group_name',
            'registration_ids' => [
                'my-phone',
                'device_1',
                'device_2',
                'my-tablet',
            ]
        ];

        $this->assertSame($expected, $create->getBody());
    }

    /** @test */
    public function it_can_generate_a_quick_object_from_magic_method()
    {
        $client = \Fcm\FcmClient::create('', '');

        $create = $client->deviceGroupCreate('devicegroup_new', 'device_id');

        $expected = [
            'operation' => 'create',
            'notification_key_name' => 'devicegroup_new',
            'registration_ids' => [
                'device_id',
            ]
        ];

        $this->assertSame($expected, $create->getBody());
    }
}
