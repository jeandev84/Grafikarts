<?php
namespace App\Routing;


/**
 * Class Route
 * @package App\Routing
 *
 * Represente une route
*/
class Route
{
    /** @var string */
    private $path;

    /** @var \Closure */
    private $callable;


    /** @var array */
    private $matches = [];


    /** @var array  */
    private $params = [];



    /**
     * Route constructor.
     * @param $path
     * @param $callable
    */
    public function __construct($path, $callable)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }


    /**
     * @param $param
     * @param $regex
     * @return Route
    */
    public function with($param, $regex)
    {
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this;
    }


    /**
     * Determine if route match
     *
     * ([^/]+) - on veut n'importe quoi qui ne soit pas un slashe qui peut se repeter plusieurs fois
    */
    public function match($url)
    {
       /* On supprime les slashes venant de l'URL */
       $url = trim($url, '/');

       /* On remplace toute expression [:id, :slug par example] par son expression reguliere
          Example /posts/:id  sera remplace par /posts/([0-9]+) selon ce qu'on aurait ecrit

          $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
       */
       $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);


       /* On cree  l'expression reguliere correspondante
          (drapeau i permet de verifier les majuscules et minuscules )
       */
       $regex = '#^' . $path . '$#i';


       /* On verifie s'il y ' a une route correspondante */
       if(! preg_match($regex, $url, $matches))
       {
            return false;
       }

       /* On elimine le premier element du tableau des matches */
       array_shift($matches);

       $this->matches = $matches;   /* debug($matches); */

       return true;
    }


    /**
     * @param $match
     * @return string
     *
     * route : /posts/:id-:slug
     * match : Array
             (
                 [0] => :id
                [1] => id
            )
            Array
           (
               [0] => :slug
               [1] => slug
           )
           Array
           (
              [0] => :id
              [1] => id
           )
    */
    private function paramMatch($match)
    {
        if(isset($this->params[$match[1]]))
        {
            return '(' . $this->params[$match[1]] . ')';
        }

        /* debug($match); */
        return '([^/]+)';
    }


    /**
     * Call fonction
    */
    public function call()
    {
        debug($this->matches);
       call_user_func_array($this->callable, $this->matches);
    }


    /**
     * @param $params
     * @return string|string[]
    */
    public function getUrl($params)
    {
       $path = $this->path;
       foreach ($params as $k => $v)
       {
           $path = str_replace(":$k", $v, $path);
       }
       return $path;
    }
}