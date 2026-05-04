<?php

require_once 'vendor/autoload.php';
use Elastic\Elasticsearch\ClientBuilder;

$hosts = ['localhost:9200'];

// Create the Elasticsearch client
$es = ClientBuilder::create()->setHosts($hosts)->build();
