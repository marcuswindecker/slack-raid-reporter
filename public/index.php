<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(['settings' => $config]);
$app->post('/stats', function (Request $request, Response $response, array $args) {

    $requestBody = $request->getParsedBody();

    $responseBody['response_type'] = 'in_channel';
    $responseBody['text'] = 'Here\'s the raid report for ' . $requestBody['text'] . ': https://raid.report/ps/' . $requestBody['text'];
    // $responseBody['attachments'] = [
    // 	[
    // 		'color' => 'good',
	   //  	'text' => 'hannah sux',
	   //  	'image_url' => 'https://www.placehold.it/200?text=hannah+sux'
    // 	]
    // ];

    $response = $response->withStatus(200)
      ->withHeader('Content-Type', 'application/json')
      ->write(json_encode($responseBody));

    return $response;
});
$app->run();
