<?php

define('IVR_FILE', __DIR__ . '/ivr.json');

/**
 * Vypsání JSON
 * @param array $input
 */
function print_json(array $input)
{
    header('Content-Type: application/json');
    echo json_encode($input);
    die();
}


/**
 * Vygenerování náhodného čisla
 * @param $digit
 * @return int
 */
function rand_number($digit)
{
    return rand(pow(10, $digit - 1) - 1, pow(10, $digit) - 1);
}