<?php


namespace Writer;


class FunctionParamWriter implements \GetString
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $type;

    /**
     * @var mixed
     */
    private $defaultVal;

    /**
     * @return mixed
     */
    public function getDefaultVal()
    {
        return $this->defaultVal;
    }

    /**
     * @param mixed $defaultVal
     * @return FunctionParamWriter
     */
    public function setDefaultVal($defaultVal)
    {
        $this->defaultVal = $defaultVal;
        return $this;
    }

    /**
     * FunctionParamWriter constructor.
     * @param string $name
     * @param string $type
     * @param mixed $defaultVal
     */
    public function __construct(string $name, string $type, $defaultVal=null)
    {
        $this->setName($name)->setType($type);
        if($defaultVal !== null) $this->setDefaultVal($defaultVal);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return FunctionParamWriter
     */
    public function setName(string $name): FunctionParamWriter
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return FunctionParamWriter
     */
    public function setType(string $type): FunctionParamWriter
    {
        $this->type = $type;
        return $this;
    }



    /**
     * @return string
     */
    public function getString():string
    {
        $s = $this->getType() . ' ' . PhpWriter::getVarName($this->getName());
        if($this->getDefaultVal() === null) return $s;
        else return $s .= '=' . $this->getDefaultVal();
    }


}