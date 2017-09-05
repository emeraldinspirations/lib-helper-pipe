<?php declare(strict_types=1);

/**
 * Container for Pipe
 *
 * PHP Version 7
 *
 * @category  Library
 * @package   Helper-Pipe
 * @author    Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @copyright 2017 Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @license   MIT ../LICENSE.md
 * @link      https://github.com/emeraldinspirations/lib-objectdesignpattern-pipe
 */

namespace emeraldinspirations\library\helper\pipe;

/**
 * Pipe the output of each callable to the next one
 *
 * @category  Library
 * @package   Helper-Pipe
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

    /**
     * Return callable that routs pipe to parameters per mask
     *
     * Example:
     * <code>
     *  $callable = delegateWithParamMask(['_', Pipe::here()], 'implode');
     *  return $callable([1, 2, 3]);
     *  // Returns: "1_2_3"
     * </code>
     *
     * @param array    $ParameterMask Array of parameters, use `self::here()`
     *        for input from pipe
     * @param callable $Function      The function to pass the parameters to
     *
     * @see self::here() Token representing the input from the pipe
     *
     * @return callable
     */
    static function delegateWithParamMask(
        array $ParameterMask,
        callable $Function
    ) : callable {
        return function ($Parameter) use ($ParameterMask, $Function) {
            $HereToken = self::here();

            $PostMaskParams = array_map(
                function ($Element) use ($HereToken, $Parameter) {
                    if ($Element === $HereToken) {
                        return $Parameter;
                    }
                    return $Element;
                },
                $ParameterMask
            );

            return $Function(...$PostMaskParams);
        };
    }

    /**
     * Return anonymous function that calls a class constructor
     *
     * PHP does not yet have a syntax for creating a callable for the
     * constructor of a class.  Some workarounds involve using
     * ReflectionClass.  Example: https://stackoverflow.com/q/24129450/6699286
     *
     * This function provides an alternate option.  In creates an anonymous
     * function that fulfills the callable need and runs the relevant
     * constructor.
     *
     * @todo Merge with emeraldinspirations/lib-createconstructcallable
     * This code does duplicate a function in the above package, and therefore
     * violates the DRY principle.  Either this package should require the
     * above package, or the above package should be deprecated in favor of
     * this function.
     *
     * @return callable
     */
    static function delegateConstructor(string $Class) : callable
    {
        return function (...$Params) use ($Class) {
            return new $Class(...$Params);
        };
    }

    /**
     * Return singleton token representing the return value of previous function
     *
     * @see self::thenTo Where token is used
     *
     * @return mixed
     */
    static function here()
    {
        static $Singleton;
        return $Singleton ?? $Singleton = new \stdClass();
    }

}
