<?php
require_once 'app/init.php';

header('Content-Type: application/json');

$results = [];
if (isset($_GET['q'])) {
    $q = $_GET['q'];
    $query = $es->search([
        'body' => [
            'query' => [
                'bool' => [
                    'should' => [
                        ['match' => ['content' => $q]],
                        ['match' => ['filename' => $q]]
                    ]
                ]
            ]
        ]
    ]);

    if ($query['hits']['total'] >= 1) {
        $results = $query['hits']['hits'];
    }
}

echo json_encode($results);
?>

