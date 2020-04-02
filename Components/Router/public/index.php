<?php

require __DIR__ . '/helpers/functions.php';
require __DIR__ . '/../vendor/autoload.php';


# Instance of Request and Router
$request = new \App\Http\Request();
$router = new \App\Routing\Router(
    $request->get('url') ?? $request->server('REQUEST_URI')
);



# Route collection
$router->get('/', function () {
    echo 'Home Page';
});


$router->get('/posts', function () {
    echo 'Tous les articles';
});

/*
OK
# ex: /posts/salut-les-gens-48
$router->get('/posts/:slug-:id', function ($slug, $id) {
    echo "L'article avec le Slug : <b>$slug</b> et ID : <b>$id</b>";
});

# ex: /posts/48-salut-les-gens
$router->get('/posts/:id-:slug', function ($id, $slug) use ($router) {

    // echo "L'article avec le Slug : <b>$slug</b> et ID : <b>$id</b>";

    echo $router->url('posts.show', ['id' => 1, 'slug' => 'salut-les-gens']);

}, 'posts.show')
->with('id', '[0-9]+')
->with('slug', '[a-z\-0-9]+');

$router->get('/posts/:slug-:id/:page', 'PostController@show', 'posts.show')
    ->with('id', '[0-9]+')
    ->with('slug', '[a-z\-0-9]+')
    ->with('page', '[0-9]+');
$router->get('/posts/:id', 'PostController@show');
*/


$router->get('/posts/:slug-:id', 'PostController@show', 'posts.show');
//->with('slug', '[a-z\-0-9]+')
//->with('id', '[0-9]+');

$router->post('/posts/:id', function ($id) {
    echo 'Poster pour l\' article '. $id;
    debug($_POST);
});


# Router run
$router->run(
    $request->getMethod()
);