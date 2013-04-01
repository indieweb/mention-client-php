<?php

use AaronParecki\MentionClient;

// Note: if installing with composer you should require 'vendor/autoload.php' instead
require 'src/AaronParecki/MentionClient.php';

$url = 'https://github.com/aaronpk/mention-client';
$client = new MentionClient($url);
$client->debug = true;
$sent = $client->sendSupportedMentions();

echo "Sent $sent mentions\n";