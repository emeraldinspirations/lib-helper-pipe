<?php

/**
 * Container for unit tests for Pipe
 *
 * PHP Version 7
 *
 * @category  Library
 * @package   ObjectDesignPattern-Pipe
 * @author    Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @copyright 2017 Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @license   MIT ../LICENSE.md
 * @link      https://github.com/emeraldinspirations/lib-objectdesignpattern-pipe
 */

namespace emeraldinspirations\library\objectDesignPattern\pipe;

/**
 * Unit tests for Pipe
 *
 * @category  Library
 * @package   ObjectDesignPattern-Pipe
 * @author    Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @copyright 2017 Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @license   MIT ../LICENSE.md
 * @version   GIT: $Id$ In Development.
 * @link      https://github.com/emeraldinspirations/lib-objectdesignpattern-pipe
 */
class PipeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Verifies object is constructable
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(
            Pipe::class,
            new Pipe(),
            'Fails if class undefined'
        );
    }

    /**
     * Verify getParams returns array passed at construct
     *
     * @return void
     */
    public function testGetParams()
    {

        $this->assertEquals(
            [],
            (new Pipe())->getParams(),
            'Fails if function undefined or returns value when none passed'
        );

        $this->assertEquals(
            [1,2,3],
            (new Pipe(1, 2, 3))->getParams(),
            'Fails if passed params not retained and returned'
        );

    }

    /**
     * Verify`thenTo` runs callable, stores return, returns new pipe
     *
     * @return void
     */
    public function testThenTo()
    {

        $this->assertInstanceOf(
            Pipe::class,
            $Actual = ($Object = new Pipe())->to()->thenTo(
                function () {
                }
            ),
            'Fails if function undefined'
        );

        $this->assertNotSame(
            $Object,
            $Actual,
            'Fails if returns same instance'
        );

        $this->assertEquals(
            $NewValue = 'NewValue',
            (
                $NewObject = $Object->thenTo(
                    function () use ($NewValue) {
                        return $NewValue;
                    }
                )
            )->return(),
            'Fails if callable not run or value not retained'
        );

        $this->assertEquals(
            [$NewValue],
            $NewObject->getParams(),
            'Fails if parameters not passed to new object'
        );

    }

    /**
     * Verify: `to` runs callable, stores return; `return` returns result
     *
     * @return void
     */
    public function testTo()
    {

        $this->assertInstanceOf(
            Pipe::class,
            $Actual = ($Object = new Pipe())->to(
                function () {
                }
            ),
            'Fails if function undefined or returns wrong type'
        );

        $this->assertSame(
            $Actual,
            $Object,
            'Fails if returns new instance'
        );

        $this->assertNull(
            $Object->return(),
            'Fails if function undefined or returns results on empty results'
        );

        $this->assertSame(
            $StdClass = new \stdClass(),
            ($Object = new Pipe())->to(
                function () use ($StdClass) {
                    return $StdClass;
                }
            )->return(),
            'Fails if callable not ran or return not retained'
        );

        $Params = [1, 2, 3];
        $Object = new Pipe(...$Params);

        $Object->to(
            function (...$Params) use ($StdClass) {
                return $Params;
            }
        );

        $this->assertEquals(
            $Params,
            $Object->return(),
            'Fails if params not passed to callable'
        );

        $OverrridenValue = 'Return overriden';
        $Object->to(
            function () use ($OverrridenValue) {
                return $OverrridenValue;
            }
        );

        $this->assertEquals(
            $OverrridenValue,
            $Object->return(),
            'Fails if return value not overriden with subsiquent to calls'
        );

    }

    /**
     * Verify with a practical example
     *
     * @return void
     */
    public function testPractical()
    {

        $Actual = (new Pipe('test string'))
            ->to('strtoupper')
            ->thenTo('str_split')
            ->thenTo('array_reverse')
            ->thenTo(
                function (array $Array) {
                    return implode('', $Array);
                }
            )
            ->return();

        $this->assertEquals(
            'GNIRTS TSET',
            $Actual
        );

    }

}
