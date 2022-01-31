<?php

namespace App\Interfaces;

interface SubscriptionInterface
{

    public function getSubscriptionType(int $id);

    public function getMonthlyLimit(int $id);

    public function checkCurrentUploadLimit(int $id);

    public function subscribeUser(array $data);

    public function cancelSubscription(array $data);

    public function updateSubscription(array $data);

}