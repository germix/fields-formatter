<?php

namespace Germix\FieldsFormatter\Exceptions;

use Germix\FieldsFormatter\FieldsFormatterException;

/**
 * @author Germán Martínez
 */
final class InvalidFieldsException extends FieldsFormatterException
{
    public function __construct(\Throwable $previous = null)
    {
        parent::__construct('Invalid fields', $previous);
    }
}
