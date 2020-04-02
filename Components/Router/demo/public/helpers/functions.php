<?php

/**
 * @param $variable
 * @param bool $die
 */
function debug($variable, $die = false)
{
    echo '<pre>';
    print_r($variable);
    echo '</pre>';
    if($die) die;
}