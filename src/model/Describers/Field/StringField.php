<?php

namespace Describers;

class StringField extends FieldBdd
{
    CONST EMAIL = 'email';
    CONST PHONE = 'phone';

    CONST PDO_PARAM = 'PDO::PARAM_STR';

    /**
     * @var int|null
     */
    private ?int $minLength;

    /**
     * @var int|null
     */
    private ?int $maxLength;

    /**
     * StringField constructor.
     * @param string $nameFieldBdd
     * @param string $label
     */
    public function __construct(string $nameFieldBdd, string $label='')
    {
        parent::__construct($nameFieldBdd, $label);
        $this->setType('string');
        $this->setPdoParam('PDO::PARAM_STR');

        if($this->getLabel() !== '') {
            $oElement = new \Input('text', $this->getLabel());
            $oElement->setName($this->getNameAttributeValue());
            $oElement->setId($this->getIdAttributeValue());
            $this->setFormElement($oElement);
        }
    }

    public function getNameAttributeValue()
    {
        return 'inp' . ucfirst($this->getNameFieldBdd());
    }

    public function getIdAttributeValue()
    {
        return 'inp' . ucfirst($this->getNameFieldBdd());
    }


    /**
     * @var string
     */
    private string $regex;

    /**
     * @return string
     */
    public function getRegex(): string
    {
        return $this->regex;
    }

    /**
     * @param string $regex
     * @return StringField
     */
    public function setRegex(string $regex): StringField
    {
        $this->regex = $regex;
        return $this;
    }


    /**
     * @return int|null
     */
    public function getMinLength(): ?int
    {
        return $this->minLength;
    }

    /**
     * @param int|null $minLength
     * @return StringField
     */
    public function setMinLength(?int $minLength): StringField
    {
        $this->minLength = $minLength;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxLength(): ?int
    {
        return $this->maxLength;
    }

    /**
     * @param int|null $maxLength
     * @return StringField
     */
    public function setMaxLength(?int $maxLength): StringField
    {
        $this->maxLength = $maxLength;
        return $this;
    }
}