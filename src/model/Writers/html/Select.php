<?php


class Select extends FormElement
{
    /**
     * @var array
     */
    private array $data = array();

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $aData
     * @return Select
     */
    public function setData(array $aData): Select
    {
        $this->data = $aData;
        return $this;
    }

    /**
     * Select constructor.
     * @param $aData array
     * @param $sLabel string
     */
    public function __construct($aData, $sLabel)
    {
        parent::setLabel($sLabel);
        $this->setData($aData);
    }

    /**
     * @return string
     */
    public function getStringElement():string
    {
        $oOption = new \HtmlSelectOption($this->getData());
        return '<select '
                . $this->getStringId()
                . $this->getStringClass()
                . $this->getStringName()
                . $this->getStringValue()
                . $this->getStringAttributes() . '>' . $oOption->getString() . '</select>';
    }


    public function getNameAttributeValue($sNameFieldBdd)
    {
        return 'sel' . ucfirst($sNameFieldBdd);
    }

    public function getIdAttributeValue($sNameFieldBdd)
    {
        return 'sel' . ucfirst($sNameFieldBdd);
    }
}