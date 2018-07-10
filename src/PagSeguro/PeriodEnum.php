<?php
/**
 * Created by PhpStorm.
 * User: Allfa
 * Date: 10/07/2018
 * Time: 11:45
 */

namespace Allfa\PagSeguro;

use MyCLabs\Enum\Enum;

class PeriodEnum extends enum
{
    const WEEKLY = 0;
    const MONTHLY = 1;
    const BIMONTHLY = 2;
    const TRIMONTHLY = 3;
    const SEMIANNUALLY = 4;
    const YEARLY = 5;
}