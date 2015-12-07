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

    $target = 'http://pin13.net/mention-client-php/target.php';
    $endpoint = $this->client->discoverWebmentionEndpoint($target);
    $this->assertEquals('http://pin13.net/mention-client-php/webmention.php', $endpoint);
  }

  public function testSupportsPingback() {
  	$headers = "HTTP/1.1 200 OK\r
X-Pingback: http://pingback.me/webmention?forward=http%3A%2F%2Faaronparecki.com%2Fwebmention.php\r
Link: <http://aaronparecki.com/>; rel=\"me\"\r
";

    $target = 'http://example.com/';
    $this->client->c('headers', $target, IndieWeb\MentionClientTest::_parse_headers($headers));
    $endpoint = $this->client->discoverPingbackEndpoint($target);
    $this->assertEquals('http://pingback.me/webmention?forward=http%3A%2F%2Faaronparecki.com%2Fwebmention.php', $endpoint);
  }

}
