<?php
require_once('src/IndieWeb/MentionClient.php');

class LinkHeaderParserTest extends PHPUnit_Framework_TestCase {

  public $client;

  public function setUp() {
    $this->client = new IndieWeb\MentionClient(false, 'empty');
  }

  public function testFindWebmentionLinkHeader() {
  	$headers = "HTTP/1.1 200 OK\r
Server: nginx/1.0.14\r
Date: Thu, 04 Jul 2013 15:56:21 GMT\r
Content-Type: text/html; charset=UTF-8\r
Connection: keep-alive\r
X-Powered-By: PHP/5.3.13\r
X-Pingback: http://pingback.me/webmention?forward=http%3A%2F%2Faaronparecki.com%2Fwebmention.php\r
Link: <http://aaronparecki.com/webmention.php>; rel=\"http://webmention.org/\"\r
Link: <http://aaronparecki.com/>; rel=\"me\"";
	
	$target = 'http://aaronparecki.com/';
	$this->client->c('headers', $target, $this->client->_parse_headers($headers));
    $supports = $this->client->supportsWebmention($target);
    $this->assertEquals(true, $supports);
  }

}
