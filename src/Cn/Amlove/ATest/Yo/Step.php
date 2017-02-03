<?php namespace Cn\Amlove\ATest\Yo;

use Cn\Amlove\ATest\Yo\Step\HttpRequest;
use Cn\Amlove\ATest\Yo\Step\Delay;

class Step
{

	public static function init(array $data)
	{
		$obj = null;
		$type = strtoupper(trim($data['type']));
		switch ($type)
		{
			case 'HTTP':
				$obj = HttpRequest::bind('value' => $data['delay']);
				break;
			case 'DELAY':
				$obj = Delay::bind('value' => $data['delay']);
				break;
		}

		// if (empty($obj)) 抛异常;

		return $obj;
	}

}