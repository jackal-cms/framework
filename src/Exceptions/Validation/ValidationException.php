<?php

namespace Quagga\Quagga\Exceptions\Validation;

use Exception;

class ValidationException extends Exception
{
    /**
     * Create a new validation exception from a plain array of messages.
     *
     * @param  array  $messages
     * @return static
     */
    public static function withMessages(array $messages)
    {
        return new static(implode('\n', $messages));
    }
}
