<?php namespace Cn\Amlove\ATest\Yo;

class Script extends It
{

	/**
	 * id
	 * @var int
	 */
	private $id;

	/**
	 * 名称
	 * @var string
	 */
	private $name;

	/**
	 * 事务
	 * @var array
	 */
	private $trans = [
		'variables' => [],
		'files' => [],
		'steps' => [],
	];

	public function setTrans(array $trans)
	{
		$this->setVariables($trans['variables']);
		$this->setFiles($trans['files']);
		$this->setSteps($trans['steps']);
	}

    private function setVariables(array $variables)
    {
    	$this->trans['variables'] = [];

    	foreach ($variables as $name => $value)
    	{
    		$this->trans['variables'][] = Variable::bind(['name'=>$name, 'value'=>$value]);
    	}
    	
    }

    private function setFiles(array $files)
    {
    	$this->trans['files'] = [];

    	foreach ($files as $file)
    	{
    		$this->trans['files'][] = File::init($file);
    	}
    	
    }

    private function setSteps(array $steps)
    {
    	$this->trans['steps'] = [];

    	foreach ($steps as $step)
    	{
    		$this->trans['steps'][] = Step::init($step);
    	}
    	
    }



}
