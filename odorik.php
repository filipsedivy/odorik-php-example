<?php

// Uložení vstupních hodnot DTMF

require_once __DIR__ . '/functions.php';

$inputs = filter_input_array(INPUT_GET, array(
    'from'  => FILTER_SANITIZE_STRING,
    'to'    => FILTER_SANITIZE_STRING,
    'dtmf'  => FILTER_SANITIZE_STRING,
    'line'  => FILTER_SANITIZE_STRING
));

if(!file_exists(IVR_FILE))
{
    file_put_contents(IVR_FILE, json_encode(array()));
}

$ivr = json_decode(file_get_contents(IVR_FILE), true);
$ivr[] = array(
    'from'  => $inputs['from'],
    'to'    => $inputs['to'],
    'dtmf'  => $inputs['dtmf'],
    'line'  => $inputs['line']
);

unlink(IVR_FILE);
file_put_contents(IVR_FILE, json_encode($ivr));