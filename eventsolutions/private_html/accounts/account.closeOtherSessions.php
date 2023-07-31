<?php
try
{
    $account->closeOtherSessions();
    echo 'Sessions closed successfully.';
}
catch (Exception $e)
{
    echo $e->getMessage();
    die();
}

