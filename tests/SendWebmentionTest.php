<?php
class SendWebmentionTest extends PHPUnit_Framework_TestCase {

  public $client;

  public function setUp() {
    $this->client = new IndieWeb\MentionClientTest(false, 'empty');
  }

  public function testNot200Response() {
    $endpoint = 'http://webmention-endpoint.example/404-response';
    $response = $this->client->sendWebmentionToEndpoint($endpoint, 'source', 'target');
    $this->assertInternalType('array', $response);
    $this->assertEquals(404, $response['code']);
  }

  public function testInvalidRequest() {
    $endpoint = 'http://webmention-endpoint.example/invalid-request';
    $response = $this->client->sendWebmentionToEndpoint($endpoint, 'source', 'target');
    $this->assertInternalType('array', $response);
    $this->assertEquals(400, $response['code']);
  }

  public function testValidResponse() {
    $endpoint = 'http://webmention-endpoint.example/queued-response';
    $response = $this->client->sendWebmentionToEndpoint($endpoint, 'source', 'target');
    $this->assertInternalType('array', $response);
    $this->assertEquals(202, $response['code']);
  }



}
