<?php

/**
 * Container for Pipe
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
 * Pipe the output of each callable to the next one
 *
 * @category  Library
 * @package   ObjectDesignPattern-Pipe
 * @author    Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @copyright 2017 Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @license   MIT ../LICENSE.md
 * @version   GIT: $Id$ In Development.
 * @link      https://github.com/emeraldinspirations/lib-objectdesignpattern-pipe
 */
class Pipe
{
    protected $Params;

    /**
     * Return parameters passed at construct
     *
     * @return array
     */
    public function getParams() : array
    {
        return $this->Params;
    }

    /**
     * Construct a new pipe
     *
     * @param mixed ...$Params The params to pass to the first callable
     *
     * @return void
     */
    public function __construct(...$Params)
    {
        $this->Params = $Params;
    }

}
