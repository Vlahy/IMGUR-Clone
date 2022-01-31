<?php

namespace App\Models\Enums;

interface SubscriptionTypes
{

    const FREE = 'free';
    const ONE_MONTH = 'one_month';
    const SIX_MONTHS = 'six_months';
    const TWELVE_MONTHS = 'twelve_months';

    const SUBSCRIPTION_TYPES = [
        self::FREE,
        self::ONE_MONTH,
        self::SIX_MONTHS,
        self::TWELVE_MONTHS,
    ];

    const SUBSCRIPTION_PRIORITIES = [
        1 => 'free',
        2 => 'one_month',
        3 => 'six_months',
        4 => 'twelve_months',
    ];
}