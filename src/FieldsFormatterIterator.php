<?php

namespace Germix\FieldsFormatter;

/**
 *
 * @author Germán Martínez
 *
 */
interface FieldsFormatterIterator
{
	public function getEntity() : ?FieldsFormatterEntity;
}
