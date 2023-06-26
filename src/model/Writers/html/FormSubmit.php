<?php


class FormSubmit implements GetString
{

    use StdAttributes;

    /**
     * @var string
     */
    private string $submitName='';

    /**
     * @return string
     */
    public function getSubmitName(): string
    {
        return $this->submitName;
    }

    /**
     * @param string $submitName
     * @return FormSubmit
     */
    public function setSubmitName(string $submitName): FormSubmit
    {
        $this->submitName = $submitName;
        return $this;
    }

    /**
     * FormSubmit constructor.
     * @param string $sName
     */
    public function __construct(string $sName)
    {
        $this->setId($this->generateIdName($sName))->setSubmitName($this->generateSubmitName($sName));
    }

    /**
     * @param $sName string
     * @return string
     */
    public function generateIdName($sName):string
    {
        return 'btnAdd' . ucfirst($sName);
    }

    /**
     * @param $sName string
     * @return string
     */
    public function generateSubmitName($sName):string
    {
        return 'Add ' . $sName;
    }

    /**
     * @return string
     */
    public function getString():string
    {
        return '<button 
                    type="submit" '
                    . $this->getStringId()
                    . $this->getStringClass()
                    . $this->getStringName()
                    . $this->getStringAttributes() . '>' . $this->getSubmitName() . '</button>';
    }

}