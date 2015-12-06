<?php
namespace IndieWeb;

/*
 * Make all protected methods public for PHPUnit
 */
class MentionClientTest extends MentionClient {

  public function __call($method, $args) {
    $method = new \ReflectionMethod('IndieWeb\MentionClient', $method);
    $method->setAccessible(true);
    return $method->invokeArgs($this, $args);
  }

  public static function __callStatic($method, $args) {
    $method = new \ReflectionMethod('IndieWeb\MentionClient', $method);
    $method->setAccessible(true);
    return $method->invokeArgs(null, $args);
  }

}
