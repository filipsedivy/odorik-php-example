<?php

require_once __DIR__ . '/functions.php';

if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

if($action == 'createSession')
{
    session_regenerate_id();
    print_json(array(
        'status'    => 'success',
        'sessionId' => session_id()
    ));
}

if($action == 'ivrCode')
{
    $ivrCode = null;
    $sessionId = filter_input(INPUT_GET, 'sessionId', FILTER_SANITIZE_STRING);
    if(is_null($sessionId))
    {
        $ivrCode = rand_number(4);
    }
    else
    {
        if($sessionId !== session_id())
        {
            $ivrCode = rand_number(4);
        }
        else
        {
            $ivrCode = filter_input(INPUT_SESSION, 'ivrCode', FILTER_SANITIZE_STRING);
        }
    }
    $_SESSION['ivrCode'] = $ivrCode;
    print_json(array(
        'status'    => 'success',
        'ivrCode'   => $ivrCode
    ));
}

if($action == 'ivrCheck')
{
    if(!file_exists(IVR_FILE))
    {
        print_json(array(
            'status'    => 'error',
            'code'      => 'store_not_exists'
        ));
    }

    $dtmf = filter_input(INPUT_GET, 'ivrCode', FILTER_SANITIZE_STRING);
    $ivr = json_decode(file_get_contents(IVR_FILE), true);
    foreach($ivr as $key => $data)
    {
        if($data["dtmf"] == $dtmf)
        {
            print_json(array(
                'status'    => 'success',
                'from'      => $data['from'],
                'to'        => $data['to'],
                'dtmf'      => $data['dtmf'],
                'line'      => $data['line']
            ));
        }
    }

    print_json(array(
        'status'    => 'error',
        'code'      => 'dtmf_not_found'
    ));
}