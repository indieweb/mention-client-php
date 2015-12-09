<?php
class SendPingbackTest extends PHPUnit_Framework_TestCase {

  public $client;

  public function setUp() {
    $this->client = new IndieWeb\MentionClientTest(false, 'empty');
  }

  public function testNot200Response() {
    $endpoint = 'http://pingback-target.example/404-response';
    $response = $this->client->sendPingbackToEndpoint($endpoint, 'source', 'target');
    $this->assertFalse($response);
  }

  public function testInvalidXMLResponse() {
    $endpoint = 'http://pingback-target.example/invalid-body';
    $response = $this->client->sendPingbackToEndpoint($endpoint, 'source', 'target');
    $this->assertFalse($response);
  }

  public function testInvalidRequest() {
    $endpoint = 'http://pingback-target.example/invalid-request';
    $response = $this->client->sendPingbackToEndpoint($endpoint, 'source', 'target');
    $this->assertFalse($response);
  }

  public function testValidResponse() {
    $endpoint = 'http://pingback-target.example/valid-response';
    $response = $this->client->sendPingbackToEndpoint($endpoint, 'source', 'target');
    $this->assertTrue($response);
  }

}
