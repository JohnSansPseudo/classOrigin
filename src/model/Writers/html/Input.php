<?php


class Input extends FormElement
{
    /**
     * @var string
     */
    private string $type='text';

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Input
     */
    public function setType(string $type): Input
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Input constructor.
     * @param $sType string
     * @param $sLabel string
     */
    public function __construct($sType, $sLabel)
    {
        parent::setLabel($sLabel);
        $this->setType($sType);

    }

    public function getNameAttributeValue($sNameFieldBdd)
    {
        return 'inp' . ucfirst($sNameFieldBdd);
    }

    public function getIdAttributeValue($sNameFieldBdd)
    {
        return 'inp' . ucfirst($sNameFieldBdd);
    }


    /**
     * @return string
     */
    public function getStringElement():string
    {
        return '<input type="' . $this->getType() . '" '
            . $this->getStringId()
            . $this->getStringClass()
            . $this->getStringName()
            . $this->getStringValue()
            . $this->getStringAttributes() . '/>';
    }

}