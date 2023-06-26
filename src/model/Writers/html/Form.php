<?php


class Form implements GetString
{
    use StdAttributes;

    /**
     * @var string
     */
    private string $method='POST';

    /**
     * @var string
     */
    private string $action='';

    /**
     * @var FormElement[]
     */
    private array $formElement=array();

    /**
     * @var FormSubmit|null
     */
    private ?FormSubmit $formSubmit=null;

    /**
     * @return FormSubmit|null
     */
    public function getFormSubmit(): ?FormSubmit
    {
        return $this->formSubmit;
    }

    /**
     * @param FormSubmit|null $formSubmit
     * @return Form
     */
    public function setFormSubmit(?FormSubmit $formSubmit): Form
    {
        $this->formSubmit = $formSubmit;
        return $this;
    }

    /**
     * @return FormElement[]
     */
    public function getFormElement(): array
    {
        return $this->formElement;
    }

    /**
     * @param FormElement[] $formElement
     * @return Form
     */
    public function setFormElement(array $formElement): Form
    {
        $this->formElement = $formElement;
        return $this;
    }

    /**
     * @param FormElement $elf
     */
    public function addFormElement(FormElement $elf)
    {
        $this->formElement[] = $elf;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return Form
     */
    public function setMethod(string $method): Form
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     * @return Form
     */
    public function setAction(string $action): Form
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return string
     */
    public function getStringAction():string
    {
        return 'action="' . $this->getAction() . '" ';
    }

    /**
     * @return string
     */
    public function  getStringMethod():string
    {
        return 'method="' . $this->getMethod() . '" ';
    }

    /**
     * @return string
     */
    public function getStringSubmit():string
    {
        return '';
    }

    /**
     * Form constructor.
     * @param string $action
     * @param string $method
     * @param FormElement[] $aFormElement
     * @param FormSubmit $oSubmit
     */
    public function __construct(string $action, array $aFormElement, FormSubmit $oSubmit)
    {
        $this->setAction($action)->setFormElement($aFormElement)->setFormSubmit($oSubmit);
    }

    /**
     * @return string
     */
    public function getString():string
    {
        $sElf = '';
        foreach($this->getFormElement() as $oElf)
        {
            $sElf .= $oElf->getString();
        }
        return '<form ' . $this->getStringMethod() . $this->getStringAction() . '>
                    ' . $sElf . '
                    ' . $this->getFormSubmit()->getString() . '
                    <p class="error"></p>
                    <p class="success"></p>
                </form>';
    }


}