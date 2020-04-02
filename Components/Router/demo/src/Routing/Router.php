<?php
namespace App\Routing;


use App\Routing\Exceptions\RouterException;


/**
 * Class Router
 * @package App\Routing
 *
 * Gestionnaire des routes
*/
class Router
{

    /** @var string  */
    private $url;


    /** @var array  */
    private $routes = [];


    /** @var array  */
    private $namedRoutes = [];


    /**
     * Router constructor.
     * @param $url
    */
    public function __construct($url)
    {
        $this->url = $url;
    }


    /**
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
   */
    public function get($path, $callable, $name = null)
    {
        return $this->map('GET', $path, $callable, $name);
    }


    /**
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
    */
    public function post($path, $callable, $name = null)
    {
        return $this->map('POST', $path, $callable, $name);
    }


    /**
     * @param $method
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
    */
    public function map($method, $path, $callable, $name = null)
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;

        if($name)
        {
            $this->namedRoutes[$name] = $route;
        }

        return $route;
    }


    /**
     * @param $requestMethod
     * @return mixed
     * @throws \Exception
    */
    public function run($requestMethod)
    {
         /* debug($this->routes); */
         if(! isset($this->routes[$requestMethod]))
         {
              throw new RouterException('Request method does not exist!');
         }

         // Parcourt de routes
         foreach ($this->routes[$requestMethod] as $route)
         {
             if($route->match($this->url))
             {
                 return $route->call();
             }
         }

         throw new RouterException('No matching routes!');
    }


    /**
     * @param $name
     * @param array $params
     * @return mixed
     * @throws \Exception
    */
    public function url($name, $params = [])
    {
         if(! isset($this->namedRoutes[$name]))
         {
             throw new RouterException('No route matches this name');
         }

        return $this->namedRoutes[$name]->getUrl($params);
    }

}