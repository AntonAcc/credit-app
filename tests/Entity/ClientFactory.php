<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Client;

class ClientFactory
{
    public static function create(): Client
    {
        return new Client(
            'John',              // name
            'Doe',               // lastName
            30,                  // age
            '123-45-6789',       // ssn
            '123 Main Street',   // address
            'CA',                // state
            'john.doe@email.com',// email
            '1234567890',        // phoneNumber
            700,                 // creditScore
            5000.00              // monthlyIncome
        );
    }
}
