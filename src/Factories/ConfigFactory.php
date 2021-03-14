<?php
namespace App\Factories;

use App\Configuration;

class ConfigFactory
{

    public static function createConfiguration($depositFee,$withdrawPrivateClientFee, $withdrawBusinessClientFee)
    {
        return new Configuration($depositFee,$withdrawPrivateClientFee, $withdrawBusinessClientFee);
    }
}