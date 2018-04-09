<?php

class InfoTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function it_generates_a_correct_info_request()
    {
        $info = new \Fcm\Device\Info('device_id');

        $this->assertSame([], $info->getBody());
        $this->assertSame('https://iid.googleapis.com/iid/info/device_id', $info->getUrl());

        $info = new \Fcm\Device\Info('device_id_new', true);

        $this->assertSame([], $info->getBody());
        $this->assertSame('https://iid.googleapis.com/iid/info/device_id_new?details=true', $info->getUrl());
    }

    /** @test */
    public function it_can_generate_a_quick_object_from_magic_method()
    {
        $client = new \Fcm\FcmClient('', '');

        $info = $client->deviceInfo('my-magic_Device');

        $this->assertSame('https://iid.googleapis.com/iid/info/my-magic_Device', $info->getUrl());
    }
}
