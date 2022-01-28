<?php

namespace App\Interfaces;

interface PaymentInterface
{

    public function checkPayment();

    public function doPayment();
}