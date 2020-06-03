<?php

namespace Germix\FieldsFormatter;

/**
 *
 * @author Germán Martínez
 *
 */
interface FieldsFormatterEntity
{
    /**
     * Format field
     * 
     * @param FieldsFormatter   $formatter      Formatter
     * @param string            $field          Field name
     * @param array             $subfields      Sub fields for an object field
     * @param boolean           $valid          Indicate that it is a valid field
     * @param mixed             $data           Custom data
     *
     * @return null|string|array
     */
    public function formatField($formatter, $field, $subfields, &$valid, $data);

    /**
     * Get default fields
     *
     * @return null|array|string Null, array of fields, comma separated string of fields
     */
    public function defaultFormatterFields();
}
