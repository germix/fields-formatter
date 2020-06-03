<?php

namespace Germix\FieldsFormatter;

/**
 * @author Germán Martínez
 */
abstract class FieldsFormatterException extends \Exception
{
    public function __construct($message, \Throwable $previous = null)
    {
        parent::__construct($message, $previous);
    }
}
