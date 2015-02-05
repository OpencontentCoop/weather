<?php

$weather = new Weather;		
$result = $weather->cacheData();
if ( !$isQuiet && $result )
{
    $cli->output( "Weather data updated" );
}