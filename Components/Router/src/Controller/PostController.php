<?php
namespace App\Controller;


/**
 * Class PostController
 * @package App\Controller
 */
class PostController
{

    /**
     * URL example: http://localhost:8080/posts/salut-les-gens-48
     * @param $slug
     * @param $id
    */
    public function show($slug, $id)
    {
        # Affichera dans notre cas je suis l'article '48' avec pour slug 'salut-les-gens'.
        echo sprintf("Je suis l'article <b>%s</b> avec pour slug <b>%s</b>", $id, $slug);
        echo isset($_GET['page']) ? '<br>Je suis en page '. $_GET['page'] : '';
    }
}