<?php
namespace App\Http;


/**
 * Class Request
 * @package App\Http
*/
class Request
{
    /**
     * @param $key
     * @return mixed|null
    */
    public function get($key)
    {
        return $_GET[$key] ?? null;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function post($key)
    {
        return $_POST[$key] ?? null;
    }


    /**
     * @param $key
     * @return mixed|null
    */
    public function server($key)
    {
        return $_SERVER[$key] ?? null;
    }

    /**
     * Request method
    */
    public function getMethod()
    {
        return $this->server('REQUEST_METHOD');
    }
}