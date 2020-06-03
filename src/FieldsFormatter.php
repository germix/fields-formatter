<?php

namespace Germix\FieldsFormatter;

use Germix\FieldsFormatter\Exceptions\InvalidFieldsException;
use Germix\FieldsFormatter\Exceptions\InvalidFieldsFormatterEntityException;

/**
 *
 * @author Germán Martínez
 *
 */
class FieldsFormatter
{
    private $customData;

    /**
     * Constructor
     * 
     * @param mixed $data Custom data
     */
    public function __construct($data = null)
    {
        $this->customData = $data;
    }

    /**
     * Format entity or collection of entities
     *
     * @param FieldsFormatterEntity|Traversable|array       $target     Target to format
     * @param array|string                                  $fields     Fields
     *
     * @return array
     *
     * @throws InvalidDefaultFieldsException
     * @throws InvalidFieldsFormatterElementException
     */
    public function format($target, $fields)
    {
        if($target === null)
        {
            return null;
        }
        $json = array();
        $fields = $this->checkFields($fields);
        if($target instanceof FieldsFormatterEntity)
        {
            // If there are no fields, use default
            if(empty($fields))
            {
                $fields = $this->checkFields($target->defaultFormatterFields());
            }

            // Format fields
            for($i = 0; $i < count($fields); $i++)
            {
                $fieldName = $fields[$i];
                $subfieldsNames = null;
                if(is_array($fieldName))
                {
                    $a = $fieldName;
                    $fieldName = $a[0];
                    $subfieldsNames = $a[1];
                }
                $validField = true;
                $fieldValue = $target->formatField($this, $fieldName, $subfieldsNames, $validField, $this->customData);
                if($validField)
                {
                    $json[$fieldName] = $fieldValue;
                }
            }
        }
        else if($target instanceof FieldsFormatterIterator)
        {
            $iter = $target;
            while(null != ($target = $iter->getEntity()))
            {
                array_push($json, $this->format($target, $fields));
            }
        }
        else if($target instanceof \Traversable)
        {
            foreach($target as $e)
            {
                array_push($json, $this->format($e, $fields));
            }
        }
        else if(is_array($target))
        {
            foreach($target as $e)
            {
                array_push($json, $this->format($e, $fields));
            }
        }
        else
        {
            throw new InvalidFieldsFormatterEntityException(get_class($target));
        }
        return $json;
    }

    private function checkFields($fields)
    {
        if($fields == null)
        {
            $fields = [];
        }
        else if(is_string($fields))
        {
            $fields = (new FieldsParser())->parse($fields);
        }
        else if(!is_array($fields))
        {
            throw new InvalidFieldsException();
        }
        return $fields;
    }
}
