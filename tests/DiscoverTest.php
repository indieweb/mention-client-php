<?php
class DiscoverTest extends PHPUnit_Framework_TestCase {

  public $client;

  public function setUp() {
    $this->client = new IndieWeb\MentionClientTest(false, 'empty');
  }

  public function testDiscoverWebmentionEndpoint() {
  	$headers = "HTTP/1.1 200 OK\r
Link: <http://aaronparecki.com/webmention.php>; rel=\"webmention\"\r
Link: <http://aaronparecki.com/>; rel=\"me\"\r
";

    $target = 'http://example.com/';
    $this->client->c('headers', $target, IndieWeb\MentionClientTest::_parse_headers($headers));
    $endpoint = $this->client->discoverWebmentionEndpoint($target);
    $this->assertEquals('http://aaronparecki.com/webmention.php', $endpoint);
  }

  public function testDiscoverPingbackEndpoint() {
  	$headers = "HTTP/1.1 200 OK\r
X-Pingback: http://pingback.me/webmention?forward=http%3A%2F%2Faaronparecki.com%2Fwebmention.php\r
Link: <http://aaronparecki.com/>; rel=\"me\"\r
";

    $target = 'http://example.com/';
    $this->client->c('headers', $target, IndieWeb\MentionClientTest::_parse_headers($headers));
    $endpoint = $this->client->discoverPingbackEndpoint($target);
    $this->assertEquals('http://pingback.me/webmention?forward=http%3A%2F%2Faaronparecki.com%2Fwebmention.php', $endpoint);
  }

  public function testDiscoverWebmentionEndpointInHeader() {
    $target = 'http://target.example.com/header.html';
    $endpoint = $this->client->discoverWebmentionEndpoint($target);
    $this->assertEquals('http://webmention-endpoint.example/queued-response', $endpoint);
  }

  public function testDiscoverPingbackEndpointInHeader() {
    $target = 'http://target.example.com/header.html';
    $endpoint = $this->client->discoverPingbackEndpoint($target);
    $this->assertEquals('http://pingback-endpoint.example/valid-response', $endpoint);
  }

  public function testDiscoverWebmentionEndpointInBodyLink() {
    $target = 'http://target.example.com/body-link.html';
    $endpoint = $this->client->discoverWebmentionEndpoint($target);
    $this->assertEquals('http://webmention.example/webmention', $endpoint);

    $target = 'http://target.example.com/body-link-org.html';
    $endpoint = $this->client->discoverWebmentionEndpoint($target);
    $this->assertEquals('http://webmention.example/webmention', $endpoint);

    $target = 'http://target.example.com/body-link-org2.html';
    $endpoint = $this->client->discoverWebmentionEndpoint($target);
    $this->assertEquals('http://webmention.example/webmention', $endpoint);
  }

  public function testDiscoverPingbackEndpointInBodyLink() {
    $target = 'http://target.example.com/body-link.html';
    $endpoint = $this->client->discoverPingbackEndpoint($target);
    $this->assertEquals('http://webmention.example/pingback', $endpoint);
  }

  public function testDiscoverWebmentionEndpointInBodyA() {
    $target = 'http://target.example.com/body-a.html';
    $endpoint = $this->client->discoverWebmentionEndpoint($target);
    $this->assertEquals('http://webmention.example/webmention', $endpoint);
  }

}
