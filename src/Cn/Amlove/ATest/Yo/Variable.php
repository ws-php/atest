<?php namespace Cn\Amlove\ATest\Yo;

class Variable extends It
{

	/**
	 * 变量名称
	 * @var string
	 */
	private $name;

	/**
	 * 变量内容
	 * @var string
	 */
	private $value;

    public function setValue($value)
    {
    	$this->value = trim($value);
    }

}
