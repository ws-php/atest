<?php namespace Cn\Amlove\ATest\Yo;

class Error extends \Exception
{

	/**
     * 掷出异常
     *
     * @param  string $message 错误信息
     *
     * @return Error
     */
    public static function obj($message)
    {
        return new Error($message, 10000);
    }

	public static function propertyNotExists($yo_it, $property)
	{
		$msg = "未定义属性: {$yo_it}->{$property}";
		return Error::obj($msg);
	}

}