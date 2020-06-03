<?php

namespace Germix\FieldsFormatter\Exceptions;

use Germix\FieldsFormatter\FieldsFormatterException;

/**
 * @author Germán Martínez
 */
final class InvalidFieldsFormatterEntityException extends FieldsFormatterException
{
    public function __construct(string $className, \Throwable $previous = null)
    {
        parent::__construct('Invalid field formatting entity (' . $className. ')', $previous);
    }
}
