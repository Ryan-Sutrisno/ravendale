<?php

function dd(mixed $data)
{
    echo '<pre>';
    die(var_dump($data));
    echo '</pre>';
}