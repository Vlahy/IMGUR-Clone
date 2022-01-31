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

    public function validateCard(int $id)
    {
        $this->creditCard->validateCard($id);
    }

    public function doPayment(int $id)
    {
        $this->creditCard->doPayment($id);
    }
}