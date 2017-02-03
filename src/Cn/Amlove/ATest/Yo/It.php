<?php namespace Cn\Amlove\ATest\Yo;

abstract class It implements JsonSerializable
{

	/**
     * 生成对象实例
     * 
     * @param array $aParams
     * 
     * @return It
     */
    static public function bind(array $aParams)
    {
    	$class = get_called_class();
        $oVO = new $class();
        foreach ($aParams as $key => $val) {
            $oVO->$key = $val;
        }
        return $oVO;
    }

    public function jsonSerialize()
    {
    	$data = [];
    	foreach ($this as $key=>$val)
    	{
    		if ($val !== null) $data[$key] = $val;
    	}
        return $data;
    }

    public function __set($name, $value)
    {
        $callable = [$this, 'set' . ucfirst($name)];
        if ( is_callable($callable))
        {
            call_user_func($callable, $value);
        }
        else
        {
            $this->$name = $value;    
        }
    }

    public function __get($name)
    {
        if (isset($this->$name))
        {
            return ($this->$name);
        }

        return NULL;
    }

}
