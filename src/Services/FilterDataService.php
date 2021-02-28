<?php


namespace App\Services;


class FilterDataService
{
    public function filterIds($id, $transactions)
    {
       return  array_search($id, array_column($transactions, 'userId'));

    }
}