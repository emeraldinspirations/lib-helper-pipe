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

}
