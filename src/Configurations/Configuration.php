<?php

namespace App\Configurations;


class Configuration
{

    private $depositFee;

    private $withdrawPrivateClientFee;

    private $withdrawBusinessClientFee;


    public function __construct($depositFee,$withdrawPrivateClientFee, $withdrawBusinessClientFee)
    {
        $this->depositFee = $depositFee;
        $this->withdrawPrivateClientFee = $withdrawPrivateClientFee;
        $this->withdrawBusinessClientFee = $withdrawBusinessClientFee;
    }



    /**
     * @return mixed
     */
    public function getDepositFee()
    {
        return $this->depositFee;
    }

    /**
     * @return mixed
     */
    public function getWithdrawPrivateClientFee()
    {
        return $this->withdrawPrivateClientFee;
    }

    /**
     * @return mixed
     */
    public function getWithdrawBusinessClientFee()
    {
        return $this->withdrawBusinessClientFee;
    }


}