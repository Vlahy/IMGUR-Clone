<?php

namespace App\Interfaces;

interface CreditCardInterface
{

    public function validateCard();

    public function doPayment();

}