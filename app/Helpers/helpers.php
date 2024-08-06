<?php

if (! function_exists("getVoterFromRequest")) {
    function getVoterFromRequest(): object
    {
        return (object) request()['voter'];
    }
}