<?php

namespace Germix\FieldsFormatter\Exceptions;

use Germix\FieldsFormatter\FieldsFormatterException;
use Germix\FieldsFormatter\Token as FieldsFormatterToken;

/**
 * @author Germán Martínez
 */
final class UnexpectedTokenException extends FieldsFormatterException
{
    public function __construct($expectedToken, FieldsFormatterToken $foundToken, \Throwable $previous = null)
    {
        parent::__construct('Expected \'' . $expectedToken . '\', but found \'' . $foundToken->id() . '\'', $previous);
    }
}
