<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class CustomerFilter extends ApiFilter
{
    protected $safeParms = [
        'id' => ['eq'],
        'name' => ['eq'],
        'email' => ['eq'],
        'address' => ['eq'],
        'city' => ['eq'],
        'state' => ['eq'],
        'type' => ['eq'],
        'postalCode' => ['eq', 'gt', 'lt']
    ];

    protected $columnMap = [
        'postalCode' => 'postal_code'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lqe' => '<=',
        'gt' => '>',
        'gte' => '>='
    ];
}
