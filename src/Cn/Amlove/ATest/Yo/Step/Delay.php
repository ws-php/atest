<?php namespace Cn\Amlove\ATest\Yo\Step;

use Cn\Amlove\ATest\Yo\It;

class Delay extends It
{

	private $type = 'delay';
	private $value;

    public function setValue($value)
    {
    	$this->value = intval($value);
    }

}