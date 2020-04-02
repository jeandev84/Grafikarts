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
*/

# ex: /posts/48-salut-les-gens
$router->get('/posts/:id-:slug', function ($id, $slug) use ($router) {

    // echo "L'article avec le Slug : <b>$slug</b> et ID : <b>$id</b>";

    echo $router->url('posts.show', ['id' => 1, 'slug' => 'salut-les-gens']);

}, 'posts.show')
->with('id', '[0-9]+')
->with('slug', '[a-z\-0-9]+');


$router->get('/posts/:id', function ($id) {
    /* echo 'Afficher l\' article '. $id; */

?>

    <form action="" method="POST">
        <input type="text" name="name">
        <button type="submit">Envoyer</button>
    </form>
<?php
    
});

$router->post('/posts/:id', function ($id) {
    echo 'Poster pour l\' article '. $id;
    debug($_POST);
});


# Router run
$router->run(
    $request->getMethod()
);