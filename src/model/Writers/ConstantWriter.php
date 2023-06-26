<?php


namespace Writer;


class ConstantWriter implements \GetString
{
    /**
     * @var string
     */
    private string $name='';

    /**
     * @var string
     */
    private string $visibility=Visibility::PUBLIC;

    /*
     * @var mixed | null
     */
    private $value=null;

    /**
     * @var string
     */
    private string $content='';

    /**
     * @var string
     */
    private string $type='string';

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return ConstantWriter
     */
    public function setType(string $type): ConstantWriter
    {
        $this->type = $type;
        return $this;
    }



    /**
     * ConstantWriter constructor.
     * @param string $sName
     * @param $value
     * @param string $sVisibility
     * @param string type
     */
    public function __construct(string $sName, $value, string $sVisibility, string $sType)
    {
        $this->setName($sName)->setValue($value)->setVisibility($sVisibility)->setType($sType);
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
     * @return ConstantWriter
     */
    public function setName(string $name): ConstantWriter
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getVisibility(): string
    {
        return $this->visibility;
    }

    /**
     * @param string $visibility
     * @return ConstantWriter
     */
    public function setVisibility(string $visibility): ConstantWriter
    {
        $this->visibility = $visibility;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return ConstantWriter
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return ConstantWriter
     */
    public function setContent(string $content): ConstantWriter
    {
        $this->content = $content;
        return $this;
    }



    /**
     * @return string
     */
    public function getString():string
    {
        $sQuote = '';
        if($this->getType() === 'string') $sQuote = "'";
        $oPhpDoc = new PhpDocBlocWriter('return', $this->getType());
        $s = $oPhpDoc->getString(array($oPhpDoc));
        $s .= PhpWriter::TAB . $this->getVisibility() . " CONST " . $this->getName() . " = " . $sQuote . $this->getValue() . $sQuote . ";" . PhpWriter::RETOUR2;
        return $s;
    }
}