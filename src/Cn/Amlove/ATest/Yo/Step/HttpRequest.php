<?php namespace Cn\Amlove\ATest\Yo\Step;

use Cn\Amlove\ATest\Yo\It;

class HttpRequest extends It
{

	private $type = 'HttpRequest';

	private $actionId;
	private $actionName;
	private $url;
	private $protocol;
	private $method;
	private $headers;
	private $authorization;
	private $parameters;
	private $formdata;
	private $postProcessors;

	public function setPostProcessors($postProcessors)
	{
		
	}

}