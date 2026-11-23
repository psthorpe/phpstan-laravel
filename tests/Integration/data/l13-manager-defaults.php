<?php

namespace IntegrationEnumDefaults;

use Managers\EnumDefaultManager;
use Managers\PureEnumDefaultManager;

function test(EnumDefaultManager $backed, PureEnumDefaultManager $pure): void
{
    $backed->type();
    $backed->other();
    $pure->type();
    $pure->other();
}
