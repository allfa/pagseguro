<?php
/**
 * Created by PhpStorm.
 * User: Allfa
 * Date: 10/07/2018
 * Time: 09:29
 */
namespace Allfa\PagSeguro;

use MyCLabs\Enum\Enum;

class PreApprovalStatus extends Enum
{
    const PENDING = 1;
    const ACTIVE = 2;
    const CANCELLED = 3;
    const CANCELLED_BY_SENDER = 4;
    const CANCELLED_BY_VENDOR = 5;
    const EXPIRED = 6;
}