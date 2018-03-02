<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use JonnyW\PhantomJs\Client;

require '../vendor/autoload.php';
require '../src/classes/Upload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(['settings' => $config]);
$app->get('/stats', function (Request $request, Response $response, array $args) {
    $upload = new Upload();

    $phantomClient = Client::getInstance();
    $phantomClient->getEngine()->setPath(dirname(__FILE__).'/bin/phantomjs');
    $phantomClient->getEngine()->debug(true);

    $phantomRequest  = $phantomClient->getMessageFactory()->createRequest('https://google.com', 'GET', 5000);
    $phantomResponse = $phantomClient->getMessageFactory()->createResponse();

    $phantomClient->send($phantomRequest, $phantomResponse);

    // $requestBody = $request->getParsedBody();

    // $responseBody['response_type'] = 'in_channel';
    // $responseBody['text'] = $requestBody['text'];
    // $responseBody['attachments'] = [
    // 	[
    // 		'color' => 'good',
	   //  	'text' => 'hannah sux',
	   //  	'image_url' => 'https://www.placehold.it/200?text=hannah+sux'
    // 	]
    // ];

    // $response = $response->withStatus(200)
    //   ->withHeader('Content-Type', 'application/json')
    //   ->write(json_encode($responseBody));

    $log = $phantomClient->getLog();

    echo "<pre>" . json_encode($log, JSON_PRETTY_PRINT) . "</pre>";
});
$app->run();
