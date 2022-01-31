<?php

namespace App\Interfaces;

interface CreditCardInterface
{

    public function validateCard(int $id);

    public function doPayment(int $id);

}