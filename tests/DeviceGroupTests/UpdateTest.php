<?php

class UpdateTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function it_generates_a_correct_devicegroup_update_object()
    {
        $update = new \Fcm\DeviceGroup\Update('group_name', 'generated_key');
        $update->addDevice('device_test');

        $expected = [
            'operation' => 'add',
            'notification_key_name' => 'group_name',
            'notification_key' => 'generated_key',
            'registration_ids' => [
                'device_test',
            ]
        ];

        $this->assertSame($expected, $update->getBody());
    }

    /** @test */
    public function it_can_update_a_group_with_multiple_devices()
    {
        $update = new \Fcm\DeviceGroup\Update('group_name', 'generated_key');
        $update
            ->addDevice('my-phone')
            ->addDevice(['device_1', 'device_2'])
            ->addDevice('my-tablet');

        $expected = [
            'operation' => 'add',
            'notification_key_name' => 'group_name',
            'notification_key' => 'generated_key',
            'registration_ids' => [
                'my-phone',
                'device_1',
                'device_2',
                'my-tablet',
            ]
        ];

        $this->assertSame($expected, $update->getBody());
    }

    /** @test */
    public function it_can_generate_a_quick_object_from_magic_method()
    {
        $client = \Fcm\FcmClient::create('', '');

        $update = $client->deviceGroupUpdate(
            'devicegroup_new',
            'generated_token',
            'the_device'
        );

        $expected = [
            'operation' => 'add',
            'notification_key_name' => 'devicegroup_new',
            'notification_key' => 'generated_token',
            'registration_ids' => [
                'the_device',
            ]
        ];

        $this->assertSame($expected, $update->getBody());
    }
}
