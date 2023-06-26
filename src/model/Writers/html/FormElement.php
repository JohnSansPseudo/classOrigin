<?php


abstract class FormElement implements GetString
{
    CONST INPUT = 'input';
    CONST SELECT = 'select';
    CONST TEXTAREA = 'textarea';

    use StdAttributes;

    /**
     * @var bool
     */
    private bool $required=false;

    /**
     * @var string
     */
    private string $label='';

    /**
     * @var null | mixed
     */
    private $value=null;

    /**
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed|null $value
     * @return FormElement
     */
    public function setValue( $value): FormElement
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return FormElement
     */
    public function setLabel(string $label): FormElement
    {
        $this->label = $label;
        return $this;
    }

    /**
     * FormElement constructor.
     * @param $sLabel
     */
    public function __construct($sLabel)
    {
        $this->setLabel($sLabel);
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @param bool $required
     * @return FormElement
     */
    public function setRequired(bool $required): FormElement
    {
        $this->required = $required;
        return $this;
    }

    /**
     * @return string
     */
    public function getStringRequired():string
    {
        if($this->isRequired() === true) return 'required="required" ';
        return '';
    }

    /**
     * @return string
     */
    public function getStringValue():string
    {
        if($this->getValue() !== null) return 'value="' . $this->getValue() . '" ';
        return '';
    }

    /**
     * @return string
     */
    public function getStringLabel():string
    {
        $sFor = '';
        if($this->getName() !== '') $sFor = 'for="' . $this->getName() . '"';
        return '<label ' . $sFor . '>' . $this->getLabel() . '</label>';
    }

    /**
     * @return string
     */
    public function getString():string
    {
        return '<div class="elf">' . $this->getStringLabel() .  static::getStringElement() . '<p class="error"></p><p class="success"></p></div>';
    }

    /**
     * @return string
     */
    abstract public function getStringElement(): string;

}




