<?php

namespace App\Adapters;

use App\Interfaces\CreditCardInterface;
use App\Interfaces\PaymentInterface;

class PaymentAdapter implements PaymentInterface
{

    private CreditCardInterface $creditCard;

    public function __construct(CreditCardInterface $creditCard)
    {
        $this->creditCard = $creditCard;
    }

    public function checkPayment()
    {
        $this->creditCard->validateCard();
    }

    public function doPayment()
    {
        $this->creditCard->doPayment();
    }
}