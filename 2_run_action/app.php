<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

GameRocket_Configuration::environment('production');
GameRocket_Configuration::apikey('<use_your_apikey>');
GameRocket_Configuration::secretkey('<use_your_secretkey>');

$app = new Silex\Application();

$app->get('/', function() {
    include 'views/form.php';
    return '';
});

$app->post('/create_player', function (Request $request) {
    $result = GameRocket_Player::create(array(
        'name' => $request->get('name'),
        'locale' => $request->get('locale')
    ));
    
    if ($result->success) {
        // Create the customer in your database with a field which contains Player ID for next calls

        return new Response("<h1>Success! Player ID: " . $result->player->id . "</h1>", 200);
    } else {
        return new Response("<h1>Error: " . $result->message . "</h1>", 200);
    }
});

$app->get('/run_action', function (Request $request) {
    $result = GameRocket_Action::run('hello-world', array(
        'player' => '<use_player_id>',
        'name' => $request->get('name')
    ));
    
    if ($result->success) {
        return new Response("<h1>Success! Result: " . $result->map->data['hello'] . "</h1>", 200);
    } else {
        return new Response("<h1>Error: " . $result->error_description . "</h1>", 200);
    }
});

$app->run();
