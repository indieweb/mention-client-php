<?php
include('mention-client.php');

class TagParserTest extends PHPUnit_Framework_TestCase {

  public $client;

  public function setUp() {
    $this->client = new MentionClient(false, 'empty');
  }

  public function testFindWebmentionTagRelHref() {
    $html = '<link rel="http://webmention.org/" href="http://example.com/webmention" />';
    $endpoint = $this->client->_findWebmentionEndpoint($html);
    $this->assertEquals('http://example.com/webmention', $endpoint);
  }

  public function testFindWebmentionTagHrefRel() {
    $html = '<link href="http://example.com/webmention" rel="http://webmention.org/" />';
    $endpoint = $this->client->_findWebmentionEndpoint($html);
    $this->assertEquals('http://example.com/webmention', $endpoint);
  }

  public function testFindWebmentionTagExtraWhitespace() {
    $html = '<link  href="http://example.com/webmention"   rel="http://webmention.org/"  />';
    $endpoint = $this->client->_findWebmentionEndpoint($html);
    $this->assertEquals('http://example.com/webmention', $endpoint);
  }

  public function testFindWebmentionTagNoWhitespace() {
    $html = '<link href="http://example.com/webmention" rel="http://webmention.org/"/>';
    $endpoint = $this->client->_findWebmentionEndpoint($html);
    $this->assertEquals('http://example.com/webmention', $endpoint);
  }

  public function testFindWebmentionTagNoCloseTag() {
    $html = '<link href="http://example.com/webmention" rel="http://webmention.org/">';
    $endpoint = $this->client->_findWebmentionEndpoint($html);
    $this->assertEquals('http://example.com/webmention', $endpoint);
  }

}

