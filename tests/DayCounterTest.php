<?php
use App\Traits\DayCounter;
use PHPUnit\Framework\TestCase;

class DayCounterTest extends TestCase
{
    private $testTraitClass;

    /**
     * Setup object for testing trait
     */
    protected function setUp()
    {
        $this->testTraitClass = new class {
            use \App\Traits\DayCounter;
        };
    }

    protected function tearDown()
    {
        $this->testTraitClass = null;
    }

    /**
     * Test first monday in month
     */
    public function testFirstMondayDate()
    {
        $this->assertEquals(7, $this->testTraitClass->getFirstMondayDate(1, 2019));
        $this->assertEquals(4, $this->testTraitClass->getFirstMondayDate(2, 2019));
        $this->assertEquals(1, $this->testTraitClass->getFirstMondayDate(7, 2019));
    }

    /**
     * Test working days count method
     */
    public function testWorkingDays()
    {
        $this->assertEquals(23, $this->testTraitClass->getWorkingDays(5, 1, 2019));
        $this->assertEquals(20, $this->testTraitClass->getWorkingDays(5, 2, 2019));
        $this->assertEquals(23, $this->testTraitClass->getWorkingDays(5, 7, 2019));
        $this->assertEquals(19, $this->testTraitClass->getWorkingDays(4, 7, 2019));
        $this->assertEquals(5, $this->testTraitClass->getWorkingDays(1, 7, 2019));
        $this->assertEquals(10, $this->testTraitClass->getWorkingDays(2, 7, 2019));
        $this->assertEquals(15, $this->testTraitClass->getWorkingDays(3, 7, 2019));
        $this->assertEquals(19, $this->testTraitClass->getWorkingDays(4, 7, 2019));
    }
}