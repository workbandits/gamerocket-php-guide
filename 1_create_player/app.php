<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

GameRocket_Configuration::environment('development');
GameRocket_Configuration::apikey('b76a0c95125649dbb2eeab5713794e60');
GameRocket_Configuration::secretkey('b59637c9427b4950bd0db43ca86a0645');

$app = new Silex\Application();

$app->get('/', function() {
            include 'views/form.php';
            return '';
        });

$app->post('/create_customer', function (Request $request) {
    $result = GameRocket_Player::create(array(
        'name' => $request->get('name'),
        'locale' => $request->get('locale')
    ));
    
    if ($result->success) {
        // Create the customer in your database with a field which contains Player ID for next calls

        return new Response("<h1>Success! Player ID: " . $result->player->id . "<h1>", 200);
    } else {
        return new Response("<h1>Error: " . $result->message . "<h1>", 200);
    }
});

$app->run();
