<?php

declare(strict_types=1);

include_once __DIR__ . '/../autoload.php';

use PHPUnit\Framework\TestCase;

class ModuleBufferTest extends TestCase
{
    private const DEVICE = '{5C0E3E64-7A5B-4C55-9D7C-0B0F2E8A1A20}';

    protected function setUp(): void
    {
        IPS\Kernel::reset();
        IPS\ModuleLoader::loadLibrary(__DIR__ . '/SanitizationStubs/library.json');
        parent::setUp();
    }

    public function testIntegerBufferIsStoredAsString(): void
    {
        $id = IPS_CreateInstance(self::DEVICE);
        $module = IPS\InstanceManager::getInstanceInterface($id);

        $setBuffer = new ReflectionMethod($module, 'SetBuffer');
        $setBuffer->setAccessible(true);
        $setBuffer->invoke($module, 'KeepAlive', 1760990000);

        $getBuffer = new ReflectionMethod($module, 'GetBuffer');
        $getBuffer->setAccessible(true);
        $this->assertSame('1760990000', $getBuffer->invoke($module, 'KeepAlive'));
    }
}
