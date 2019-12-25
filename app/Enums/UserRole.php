<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRole extends Enum
{
    const DRIVER = "driver";
    const CUSTOMER = "customer";
    const ADMIN = "admin";
}
