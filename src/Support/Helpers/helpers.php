<?php

use Illuminate\Support\Str;

if (!function_exists('request_id')) {
    /**
     * Generates the unique id for the current request lifecycle
     *
     * @return string
     */
    function request_id()
    {
        static $request_id;

        if (empty($request_id)) {
            $request_id = Str::random();
        }

        return $request_id;
    }
}

if (!function_exists('events')) {
    /**
     * Fire the given events
     *
     * @param array $args
     */
    function events(...$args)
    {
        foreach ($args as $arg) {
            event($arg);
        }
    }
}

if (!function_exists('vd')) {
    /**
     * Dumps the given arguments
     *
     * @param array $args
     */
    function vd(...$args)
    {
        var_dump(...$args);
    }
}

if (!function_exists('vdd')) {
    /**
     * Dumps the given arguments and die
     *
     * @param array $args
     */
    function vdd(...$args)
    {
        var_dump(...$args);
        die(1);
    }
}

if (!function_exists('valueAsIterable')) {
    /**
     * If the given value is not an array or the Collection then return the given value as an array.
     *
     * @param $value
     * @return array|\Illuminate\Support\Collection
     */
    function valueAsIterable($value)
    {
        if (is_array($value)) {
            return $value;
        }

        if ($value instanceof \Illuminate\Support\Collection) {
            return $value;
        }

        if (is_iterable($value)) {
            return $value;
        }

        if ($value === null) {
            return [];
        }

        return [$value];
    }
}

if (!function_exists('callIfCallable')) {
    /**
     * Calls the given closure if it is a callable
     *
     * @param callable|null $closure
     * @param array $args
     */
    function callIfCallable(callable $closure = null, ...$args)
    {
        if ($closure instanceof \Closure) {
            $closure(...$args);
        }
    }
}

if (!function_exists('validation_failed')) {
    /**
     * Throw the ValidationFailed exception with the given arguments
     *
     * @param string $attribute
     * @param string $message
     */
    function validation_failed(string $attribute, string $message)
    {
        throw new \Ilnurshax\Era\Validation\ManuallyValidationFailed($attribute, $message);
    }
}

if (!function_exists('frontend()')) {
    function frontend()
    {
        return \Application\Frontend\Frontend::make();
    }
}

if (!function_exists('validation_failed_if')) {
    /**
     * Throw the ValidationFailed exception with the given arguments
     * if condition is true
     *
     * @param bool $condition
     * @param string $attribute
     * @param string $message
     */
    function validation_failed_if(bool $condition, string $attribute, string $message)
    {
        if ($condition) {
            throw new \Ilnurshax\Era\Validation\ManuallyValidationFailed($attribute, $message);
        }
    }
}

if (!function_exists('validation_failed_unless')) {
    /**
     * Throw the ValidationFailed exception with the given arguments
     * unless the condition true
     *
     * @param bool $condition
     * @param string $attribute
     * @param string $message
     */
    function validation_failed_unless(bool $condition, string $attribute, string $message)
    {
        if (!$condition) {
            throw new \Ilnurshax\Era\Validation\ManuallyValidationFailed($attribute, $message);
        }
    }
}

if (!function_exists('msr')) {
    function msr(string $comment, array $data = [])
    {
        logger(measure($comment), $data);
    }
}

if (!function_exists('measure')) {
    function measure(string $comment = '')
    {
        /** @var \Carbon\Carbon|null $previous */
        static $previous;

        $current = \Carbon\Carbon::now();

        if (!empty($previous)) {
            $diffBetweenPreviousAndCurrent = " |^| Diff: {$previous->diffInMicroseconds($current)} ms";
        }

        $previous = $current;

        return (!empty($comment) ? '' : '|^| ') . 'Time: ' . $current->format('i:s.u') . ($diffBetweenPreviousAndCurrent ?? '') . ' |^| Memory: ' . human_memory_usage() . ' |^| ' . $comment;
    }
}

if (!function_exists('human_memory_usage')) {
    function human_memory_usage()
    {
        $mem_usage = memory_get_usage(true);

        if ($mem_usage < 1024) {
            return $mem_usage . " bytes";
        } elseif ($mem_usage < 1048576) {
            return round($mem_usage / 1024, 2) . " kilobytes";
        } else {
            return round($mem_usage / 1048576, 2) . " megabytes";
        }
    }
}
