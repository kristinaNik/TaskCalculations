<?php


namespace App\EnumTypes;


class OperationType
{
    //name
    public const DEPOSIT = 'deposit';
    public const WITHDRAW = 'withdraw';

    //value
    public const DEPOSIT_FEE = 0.03;
    public const WITHDRAW_PRIVATE_CLIENT_FEE = 0.3;
    public const WITHDRAW_BUSINESS_CLIENT_FEE = 0.5;
}