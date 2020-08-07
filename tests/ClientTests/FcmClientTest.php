<?php

class FcmClientTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function it_generates_a_correct_guzzle_client_object()
    {
        $client = new \Fcm\FcmClient('api_token_test', 'the_sender_id');

        $headers = $client
            ->getGuzzleClient()
            ->getConfig('headers');

        $this->assertArrayHasKey('Authorization', $headers);
        $this->assertSame('key=api_token_test', $headers['Authorization']);

        $this->assertArrayHasKey('project_id', $headers);
        $this->assertSame('the_sender_id', $headers['project_id']);
    }

    /** @test */
    public function it_correctly_sends_a_request_and_parses_the_response()
    {
        $client = Mockery::mock(\Fcm\FcmClient::class)->makePartial();

        $client
            ->shouldReceive('getGuzzleClient')
            ->andReturn(new GuzzleClientMock());

        $info = new \Fcm\Device\Info('device_id');

        $response = $client->send($info);
        $this->assertSame(['json_syntax' => 'correct'], $response);
    }

    /** @test */
    public function default_options_on_guzzle()
    {
        $client = new \Fcm\FcmClient('api_token_test', 'the_sender_id');

        $this->assertArrayHasKey('http_errors', $client->options);
        $this->assertSame($client->options["http_errors"], false);

    }

    /** @test */
    public function non_default_options_on_guzzle()
    {
        $client = new \Fcm\FcmClient('api_token_test', 'the_sender_id', Array("http_errors" => true));

        $this->assertArrayHasKey('http_errors', $client->options);
        $this->assertSame($client->options["http_errors"], true);

    }

    /** @test */
    public function can_set_options_on_guzzle()
    {
        $client = new \Fcm\FcmClient('api_token_test', 'the_sender_id');

        $this->assertArrayHasKey('http_errors', $client->options);
        $this->assertSame($client->options["http_errors"], false);

        $client->setOptions( Array("http_errors" => true) );
        $this->assertSame($client->options["http_errors"], true);

        $client->setOptions( Array("http_errors" => false) );
        $this->assertSame($client->options["http_errors"], false);
    }

    /**
     * @test
     *
     * @expectedException \Fcm\Exception\FcmClientException
     * @expectedExceptionMessage Failed to json decode response body: Syntax error
     */
    public function it_throws_an_exception_if_invalid_json_was_returned()
    {
        $client = Mockery::mock(\Fcm\FcmClient::class)->makePartial();

        $client
            ->shouldReceive('getGuzzleClient')
            ->andReturn(new InvalidJsonGuzzleClientMock());

        $info = new \Fcm\Device\Info('device_id');

        $client->send($info);
    }

    /**
     * @test
     *
     * @expectedException \Fcm\Exception\FcmClientException
     * @expectedExceptionMessage Invalid magic method called: \Fcm\Fail\Test
     */
    public function it_fails_when_calling_a_nonexisting_magic_method()
    {
        $client = new \Fcm\FcmClient('', '');

        $client->failTest();
    }
}

class GuzzleClientMock extends \GuzzleHttp\Client
{
    public function post($uri, array $options = []): \Psr\Http\Message\ResponseInterface
    {
        return new \GuzzleHttp\Psr7\Response(200, [], '{"json_syntax": "correct"}');
    }
}

class InvalidJsonGuzzleClientMock extends \GuzzleHttp\Client
{
    public function post($uri, array $options = []): \Psr\Http\Message\ResponseInterface
    {
        return new \GuzzleHttp\Psr7\Response(200, [], '%Invalid"json^');
    }
}
