<?php

namespace App\Interfaces;

interface PaymentInterface
{

    public function validateCard(int $id);

    public function doPayment(bool $isValid);
}