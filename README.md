![emeraldinspirations logo](http://vps56132.vps.ovh.ca/logo.gitHub.png)
# lib-helper-pipe
> A helper in [emeraldinspiration](https://github.com/emeraldinspirations)'s [library](https://github.com/emeraldinspirations/library).

A PHP implementation of the Shell Pipe `|` concept

Inspired by:
- [PHP RFC: Pipe Operator](https://wiki.php.net/rfc/pipe-operator)
- Shell's Pipe `|` Operator
- Javascript's `Promise API`

PHP does not yet have a syntax for piping the output of one function into the input of another function without nesting the call:

```php
<?php

return implode('', array_reverse(str_split(strtoupper('test string'))));

// Returns "GNIRTS TSET"
```

This is messy, and hard to read.  Plus it puts the functions in reverse order.

This class provides an alternate option.  It allows using the `this` function to crate a cleaner looking pipe from one function to another:

```php
<?php

use emeraldinspirations\library\helper\pipe\Pipe;

return (new Pipe('test string'))
    ->to('strtoupper')
    ->thenTo('str_split')
    ->thenTo('array_reverse')
    ->thenTo(
        Pipe::delegateWithParamMask(
            ['', Pipe::here()],
            'implode'
        )
    )
    ->thenTo(
        function ($Param) {
            return [$Param];
        }
    )
    ->thenTo(
        Pipe::delegateConstructor(\ArrayObject::class)
    )
    ->return();

// Returns ArrayObject Object
//  (
//      [storage:ArrayObject:private] => Array
//          (
//              [0] => GNIRTS TSET
//          )
//  )
```

## Installing / Getting started

This project has no dependencies, so can simply be required with
[composer](https://getcomposer.org/)

```shell
composer require emeraldinspirations/lib-helper-pipe
```

## Future Features

In the example above there is the need to prepend a parameter to the `implode`
function.  A future feature may include some way to add additional parameters
to `thenTo` calls.

```php
<?php

// Example with (callable $Function, array $Prepend = [], array $Append = [])
    // ...
    ->thenTo('implode', [''], [])
    // ...


// Example with (callable $Function, array $ParameterMask = [self::Here])
    // ...
    ->thenTo('implode', ['', Pipe::Here])
    // ...
```

## Licensing

The code in this project is licensed under [MIT license](LICENSE).
