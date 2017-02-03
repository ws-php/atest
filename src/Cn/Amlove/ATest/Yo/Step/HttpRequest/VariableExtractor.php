<?php namespace Cn\Amlove\ATest\Yo\Step\HttpRequest;

use Cn\Amlove\ATest\Yo\It;

class VariableExtractor extends It
{

	private $matchBody;
	private $property;
	private $variable;

	public function setProperty($property)
	{
		if ('regex' == $this->matchBody)
		{
			$this->property = ['index'=> $property['index'], 
				'start'=> $property['start'], 'end'=> $property['end']];
		}
		else
		{
			$this->property = $property;
		}
	}

	public static function matchBodys()
	{
		// 映射关系
		return [
		];
	}

}