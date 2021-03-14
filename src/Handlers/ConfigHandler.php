<?php


namespace App\Handlers;

use App\Configuration;
use App\Factories\ConfigFactory;

class ConfigHandler
{
    /**
     * @return Configuration
     */
    public static function handleConfiguration(): Configuration
    {
       return ConfigFactory::createConfiguration(
           $_ENV['DEPOSIT_FEE'],
           $_ENV['WITHDRAW_PRIVATE_CLIENT_FEE'],
           $_ENV['WITHDRAW_BUSINESS_CLIENT_FEE']
        );
    }

}