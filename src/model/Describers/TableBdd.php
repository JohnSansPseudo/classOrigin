<?php


namespace Describers;

use Describers as Field;

class TableBdd
{
    /**
     * @var string
     */
    private string $nameBdd;
    /**
     * @var bool
     */
    private bool $final;
    /**
     * @var string
     */
    private string $extends;
    /**
     * @var string
     */
    private string $use;

    /**
     * @var string[]
     */
    private array $fields;

    /**
     * @var Field\FieldBdd[]
     */
    private array $managerClassConstant;

    /**
     * classValue constructor.
     * @param string $nameBdd
     */
    public function __construct(string $nameBdd)
    {
        $this->nameBdd = $nameBdd;
    }

    /**
     * @return string
     */
    public function getNameBdd(): string
    {
        return $this->nameBdd;
    }

    /**
     * @param string $nameBdd
     * @return TableBdd
     */
    public function setNameBdd(string $nameBdd): TableBdd
    {
        $this->nameBdd = $nameBdd;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFinal(): bool
    {
        return $this->final;
    }

    /**
     * @param bool $final
     * @return TableBdd
     */
    public function setFinal(bool $final): TableBdd
    {
        $this->final = $final;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtends(): string
    {
        return $this->extends;
    }

    /**
     * @param string $extends
     * @return TableBdd
     */
    public function setExtends(string $extends): TableBdd
    {
        $this->extends = $extends;
        return $this;
    }

    /**
     * @return string
     */
    public function getUse(): string
    {
        return $this->use;
    }

    /**
     * @param string $use
     * @return TableBdd
     */
    public function setUse(string $use): TableBdd
    {
        $this->use = $use;
        return $this;
    }

    /**
     * @return FieldBdd[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param string $sNameField
     * @return FieldBdd | false
     */
    public function getField(string $sNameField): FieldBdd
    {
        if(isset($this->fields[$sNameField])) return $this->fields[$sNameField];
        else return false;
    }


    /**
     * @param FieldBdd[] $aField
     */
    public function setFields(array $aField)
    {
        foreach($aField as $oField){ $this->setField($oField); }
    }

    /**
     * @param FieldBdd $oField
     */
    public function setField(FieldBdd $oField)
    {
        $this->fields[$oField->getNameFieldBdd()] = $oField;
    }

}