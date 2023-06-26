<?php

namespace Describers;

abstract class FieldBdd
{
    /**
     * FieldBdd constructor.
     * @param string $nameFieldBdd
     * @param string $label
     */
    public function __construct(string $nameFieldBdd, string $label)
    {
        $this->setNameFieldBdd($nameFieldBdd)->setLabel($label);

    }

    /**
     * @var string
     */
    private string $nameFieldBdd;
    /**
     * @var bool
     */
    private bool $nullable=false;
    /**
     * @var mixed
     */
    private $defaultValue=null;
    /**
     * @var bool
     */
    private bool $primaryKey=false;

    /**
     * @var bool
     */
    private bool $autoIncrement=false;

    /**
     * @var string
     */
    private string $foreignKey='';    //FOREIGN KEY (idOpening) REFERENCES " . OpeningTimes::getTableName() . " (id))";

    /**
     * @var array
     */
    private array $fieldBdd = array();

    /**
     * @var string
     */
    private string $pdoParam = 'PDO::PARAM_STR';

    /**
     * @var string
     */
    private string $label='';


    /**
     * @var string
     */
    private string $type=VarType::STRING;

    /**
     * @var bool | \FormElement
     */
    private $formElement=false;

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return FieldBdd
     */
    public function setLabel(string $label): FieldBdd
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return \FormElement | bool
     */
    public function getFormElement()
    {
        return $this->formElement;
    }

    /**
     * @param \FormElement | bool $formElement
     * @return FieldBdd
     */
    public function setFormElement($formElement): FieldBdd
    {
        $this->formElement = $formElement;
        return $this;
    }

    /**
     * @return string
     */
    public function getPdoParam(): string
    {
        return $this->pdoParam;
    }

    /**
     * @param string $pdoParam
     * @return FieldBdd
     */
    public function setPdoParam(string $pdoParam): FieldBdd
    {
        $this->pdoParam = $pdoParam;
        return $this;
    }

    /**
     * @return array
     */
    public function getFieldBdd(): array
    {
        return $this->fieldBdd;
    }

    /**
     * @param array $fieldBdd
     * @return FieldBdd
     */
    public function setFieldBdd(array $fieldBdd): FieldBdd
    {
        $this->fieldBdd = $fieldBdd;
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
     * @return FieldBdd
     */
    public function setType(string $type): FieldBdd
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAutoIncrement(): bool
    {
        return $this->autoIncrement;
    }

    /**
     * @param bool $autoIncrement
     * @return FieldBdd
     */
    public function setAutoIncrement(bool $autoIncrement): FieldBdd
    {
        $this->autoIncrement = $autoIncrement;
        return $this;
    }


    /**
     * @return string
     */
    public function getNameFieldBdd(): string
    {
        return $this->nameFieldBdd;
    }

    /**
     * @param string $nameFieldBdd
     * @return FieldBdd
     */
    public function setNameFieldBdd(string $nameFieldBdd): FieldBdd
    {
        $this->nameFieldBdd = $nameFieldBdd;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNullable(): bool
    {
        return $this->nullable;
    }

    /**
     * @param bool $nullable
     * @return FieldBdd
     */
    public function setNullable(bool $nullable): FieldBdd
    {
        $this->nullable = $nullable;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @param mixed $defaultValue
     * @return FieldBdd
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPrimaryKey(): bool
    {
        return $this->primaryKey;
    }

    /**
     * @param bool $primaryKey
     * @return FieldBdd
     */
    public function setPrimaryKey(bool $primaryKey): FieldBdd
    {
        $this->primaryKey = $primaryKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getForeignKey(): string
    {
        return $this->foreignKey;
    }

    /**
     * @param string $foreignKey
     * @return FieldBdd
     */
    public function setForeignKey(string $foreignKey): FieldBdd
    {
        $this->foreignKey = $foreignKey;
        return $this;
    }
}