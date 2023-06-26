<?php


namespace Describers;


class BoolField extends FieldBdd
{
    /**
     * BoolField constructor.
     * @param string $nameFieldBdd
     * @param string $label
     */
    public function __construct(string $nameFieldBdd, string $label='')
    {
        parent::__construct($nameFieldBdd, $label);
        $this->setType('bool');
        $this->setPdoParam('PDO::PARAM_INT');

        if($this->getLabel() !== '') {
            $oElement = new \Select(array(0 => 'No', 1 => 'Yes'), $this->getLabel());
            $oElement->setName($this->getNameAttributeValue());
            $oElement->setId($this->getIdAttributeValue());
            $this->setFormElement($oElement);
        }
    }

    public function getNameAttributeValue()
    {
        return 'sel' . ucfirst($this->getNameFieldBdd());
    }

    public function getIdAttributeValue()
    {
        return 'sel' . ucfirst($this->getNameFieldBdd());
    }


}