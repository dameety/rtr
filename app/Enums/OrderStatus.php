<?php

namespace App\Enums;


use BenSampo\Enum\Enum;

final class OrderStatus extends Enum
{
    const DELIVERED = "delivered";
    const PENDING = "pending";
}
