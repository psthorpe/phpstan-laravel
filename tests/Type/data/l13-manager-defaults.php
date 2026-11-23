<?php

namespace Managers;

use Illuminate\Support\Manager;
use UnitEnum;

use function PHPStan\Testing\assertType;

class EnumDefaultManager extends Manager
{
    public function getDefaultDriver(): UnitEnum
    {
        return Driver::Dummy;
    }

    protected function createDummyDriver(): DummyDriverContract
    {
        return new DummyDriver();
    }

    protected function createOtherDriver(): OtherDriver
    {
        return new OtherDriver();
    }
}

class PureEnumDefaultManager extends EnumDefaultManager
{
    public function getDefaultDriver(): UnitEnum
    {
        return PureDriver::Dummy;
    }
}

function testEnumDefaults(EnumDefaultManager $backed, PureEnumDefaultManager $pure, ?Driver $driver, bool $condition): void
{
    assertType('Managers\DummyDriverContract', $backed->driver());
    assertType('Managers\DummyDriverContract', $backed->driver(null));
    assertType('Managers\DummyDriverContract|Managers\OtherDriver', $backed->driver($driver));
    assertType('Managers\DummyDriverContract|Managers\OtherDriver', $backed->driver($condition ? Driver::Other : null));
    assertType('Managers\DummyDriverContract', $pure->driver());
    assertType('Managers\DummyDriverContract', $pure->driver(null));
    assertType('Managers\DummyDriverContract|Managers\OtherDriver', $pure->driver($condition ? PureDriver::Other : null));
}
