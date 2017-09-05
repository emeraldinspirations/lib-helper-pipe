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
    protected $Return;

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

    /**
     * Return this after running callable with params
     *
     * @param callable $Function (optional) The function to pass the parameters
     *        to and retain the input from
     *
     * @return $this
     */
    public function to(callable $Function = null) : Pipe
    {
        $this->Return = is_null($Function)
            ? $this->Params
            : $Function(...$this->Params);

        return $this;
    }

    /**
     * Return the results of running the callable
     *
     * @return mixed
     */
    public function return()
    {
        return $this->Return;
    }

    /**
     * Return new Pipe object after running callable with params
     *
     * @param callable $Function (optional) The function to pass the parameters
     *        to and retain the input from
     *
     * @return self
     */
    public function thenTo(callable $Function) : self
    {
        $Return = new Pipe();
        $Return->Return = $Function(...[$this->Return]);
        $Return->Params = [$Return->Return];
        return $Return;
    }

}
