<?php

class RemoveTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function it_generates_a_correct_devicegroup_remove_object()
    {
        $remove = new \Fcm\DeviceGroup\Remove('devices_to_remove', 'generated_key');
        $remove->addDevice('device_test');

        $expected = [
            'operation' => 'remove',
            'notification_key_name' => 'devices_to_remove',
            'notification_key' => 'generated_key',
            'registration_ids' => [
                'device_test',
            ]
        ];

        $this->assertSame($expected, $remove->getBody());
    }

    /** @test */
    public function it_can_update_a_group_with_multiple_devices()
    {
        $remove = new \Fcm\DeviceGroup\Remove('group_name', 'generated_key');
        $remove
            ->addDevice('my-phone')
            ->addDevice(['device_1', 'device_2'])
            ->addDevice('my-tablet');

        $expected = [
            'operation' => 'remove',
            'notification_key_name' => 'group_name',
            'notification_key' => 'generated_key',
            'registration_ids' => [
                'my-phone',
                'device_1',
                'device_2',
                'my-tablet',
            ]
        ];

        $this->assertSame($expected, $remove->getBody());
    }

    /** @test */
    public function it_can_generate_a_quick_object_from_magic_method()
    {
        $client = \Fcm\FcmClient::create('', '');

        $remove = $client->deviceGroupRemove(
            'devicegroup_new',
            'generated_token',
            'the_device'
        );

        $expected = [
            'operation' => 'remove',
            'notification_key_name' => 'devicegroup_new',
            'notification_key' => 'generated_token',
            'registration_ids' => [
                'the_device',
            ]
        ];

        $this->assertSame($expected, $remove->getBody());
    }
}
