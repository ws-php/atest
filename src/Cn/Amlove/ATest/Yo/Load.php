<?php namespace Cn\Amlove\ATest\Yo;

class Load
{

	public static function fromJson(array $json)
	{
		$script = Script::bind([
			'id' => $json['id'],
			'name' => $json['name'],
			'trans' => $json['trans'],
			]);

		return $script;
	}

}