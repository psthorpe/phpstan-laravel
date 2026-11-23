<?php

namespace Managers;

use function PHPStan\Testing\assertType;

enum Driver: string
{
    case Dummy = 'dummy';
    case Other = 'other';
}

enum IntegerDriver: int
{
    case Other = 1;
}

enum PureDriver
{
    case Dummy;
    case Other;
}

class IntegerNamedManager extends ContractManager
{
    protected function create1Driver(): DummyDriverContract
    {
        return new DummyDriver();
    }
}

function testEnumDrivers(
    ContractManager $contract,
    IntegerNamedManager $integer,
    Driver $driver,
    ?Driver $nullable,
    PureDriver $pure,
    string $name,
    bool $condition,
): void {
    assertType('Managers\OtherDriver', $contract->driver(Driver::Other));
    assertType('Managers\DummyDriverContract|Managers\OtherDriver', $contract->driver($driver));
    assertType('Managers\DummyDriverContract|Managers\OtherDriver', $contract->driver($nullable));
    assertType('Managers\DummyDriverContract|Managers\OtherDriver', $contract->driver($condition ? Driver::Other : null));
    assertType('Managers\OtherDriver', $contract->driver(PureDriver::Other));
    assertType('Managers\DummyDriverContract|Managers\OtherDriver', $contract->driver($pure));
    assertType('mixed', $contract->driver(IntegerDriver::Other));
    assertType('Managers\DummyDriverContract|Managers\OtherDriver', $contract->driver($condition ? 'dummy' : Driver::Other));
    assertType('Managers\DummyDriverContract|Managers\OtherDriver', $contract->driver($condition ? PureDriver::Dummy : Driver::Other));
    assertType('mixed', $contract->driver($condition ? $name : Driver::Other));
    assertType('mixed', $contract->driver($condition ? 1 : Driver::Other));
    assertType('mixed', $integer->driver($condition ? IntegerDriver::Other : Driver::Other));
    assertType('mixed', $contract->driver($condition ? 'missing' : Driver::Other));
}
