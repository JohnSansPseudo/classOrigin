<?php


namespace Describers;


class SqlTypeInterpreter
{
    /**
     * @var array
     */
    private array $aSqlField=array();

    /**
     * @var string
     */
    private string $varType='';

    /**
     * @var bool | \FormElement
     */
    private $formElement=false;



    /**
     * SqlTypeInterpreter constructor.
     * @param array $aSqlField
     */
    public function __construct(array $aSqlField)
    {
        $this->setArrSqlField($aSqlField);
        $this->setObj();
    }

    public function setObj()
    {

        $aField = $this->getArrSqlField();
        switch($aField['DATA_TYPE'])
        {
            case 'int':
            case 'smallint':
            case 'mediumint':
            case 'bigint':
                $this->setVarType(VarType::INT);
                if($aField['COLUMN_KEY'] === 'PRI' || $aField['EXTRA'] === 'auto_increment') {
                    $this->setFormElement(false);
                } else{
                    $oElement = new \Input('number', ucfirst($aField['COLUMN_NAME']));
                    $oElement->setName($oElement->getNameAttributeValue($aField['COLUMN_NAME']));
                    $oElement->setId($oElement->getIdAttributeValue($aField['COLUMN_NAME']));
                    $this->setFormElement($oElement);
                }
                break;
            case 'tinytext':
            case 'text':
            case 'mediumtext':
            case 'longtext':
                $this->setVarType(VarType::STRING);
                $oElement = new \Textarea(ucfirst($aField['COLUMN_NAME']));
                $oElement->setName($oElement->getNameAttributeValue($aField['COLUMN_NAME']));
                $oElement->setId($oElement->getIdAttributeValue($aField['COLUMN_NAME']));
                $this->setFormElement($oElement);
                break;
            case 'enum':
                $this->setVarType(VarType::STRING);
                $sValue = str_replace(array('enum', '(', ')', "'"), '', $aField['COLUMN_TYPE']);
                $aValue = explode(',', $sValue);
                $oElement = new \Select($aValue, ucfirst($aField['COLUMN_NAME']));
                $oElement->setName($oElement->getNameAttributeValue($aField['COLUMN_NAME']));
                $oElement->setId($oElement->getIdAttributeValue($aField['COLUMN_NAME']));
                $this->setFormElement($oElement);
                break;
            case 'tinyint':
                $this->setVarType(VarType::BOOL);

                $oElement = new \Select(array(0 => 'No', 1 => 'Yes'), ucfirst($aField['COLUMN_NAME']));
                $oElement->setName($oElement->getNameAttributeValue($aField['COLUMN_NAME']));
                $oElement->setId($oElement->getIdAttributeValue($aField['COLUMN_NAME']));
                $this->setFormElement($oElement);

                break;
            case 'decimal':
            case 'float':
            case 'double':
                $this->setVarType(VarType::FLOAT);

                $oElement = new \Input('number', ucfirst($aField['COLUMN_NAME']));
                $oElement->setName($oElement->getNameAttributeValue($aField['COLUMN_NAME']));
                $oElement->setId($oElement->getIdAttributeValue($aField['COLUMN_NAME']));
                $this->setFormElement($oElement);

                break;
            case 'date':
                $this->setVarType(VarType::STRING);
                $oElement = new \Input('date', ucfirst($aField['COLUMN_NAME']));
                $oElement->setName($oElement->getNameAttributeValue($aField['COLUMN_NAME']));
                $oElement->setId($oElement->getIdAttributeValue($aField['COLUMN_NAME']));
                $this->setFormElement($oElement);

                break;
            case 'char':
                $this->setVarType(VarType::STRING);
                $oElement = new \Input('text', ucfirst($aField['COLUMN_NAME']));
                $oElement->setName($oElement->getNameAttributeValue($aField['COLUMN_NAME']));
                $oElement->setId($oElement->getIdAttributeValue($aField['COLUMN_NAME']));
                $this->setFormElement($oElement);
                break;
            case 'time':
                $this->setVarType(VarType::STRING);
                $oElement = new \Input('time', ucfirst($aField['COLUMN_NAME']));
                $oElement->setName($oElement->getNameAttributeValue($aField['COLUMN_NAME']));
                $oElement->setId($oElement->getIdAttributeValue($aField['COLUMN_NAME']));
                $this->setFormElement($oElement);
                break;
            case 'datetime':
                $this->setVarType(VarType::STRING);
                $oElement = new \Input('datetime-local', ucfirst($aField['COLUMN_NAME']));
                $oElement->setName($oElement->getNameAttributeValue($aField['COLUMN_NAME']));
                $oElement->setId($oElement->getIdAttributeValue($aField['COLUMN_NAME']));
                $this->setFormElement($oElement);
                break;
            case 'year':
                $this->setVarType(VarType::INT);
                $oElement = new \Input('number', ucfirst($aField['COLUMN_NAME']));
                $oElement->setName($oElement->getNameAttributeValue($aField['COLUMN_NAME']));
                $oElement->setId($oElement->getIdAttributeValue($aField['COLUMN_NAME']));
                $this->setFormElement($oElement);
                break;
            case 'timestamp':
                $this->setVarType(VarType::INT);
                $this->setFormElement(false);
                break;
            case 'varchar':
                $this->setVarType(VarType::STRING);
                if($aField['CHARACTER_MAXIMUM_LENGTH'] &&  $aField['CHARACTER_MAXIMUM_LENGTH'] >= 80) {
                    $oElement = new \TEXTAREA(ucfirst($aField['COLUMN_NAME']));
                    $oElement->setName($oElement->getNameAttributeValue($aField['COLUMN_NAME']));
                    $oElement->setId($oElement->getIdAttributeValue($aField['COLUMN_NAME']));
                    $this->setFormElement($oElement);

                } else {
                    $oElement = new \INPUT('text', ucfirst($aField['COLUMN_NAME']));
                    $oElement->setName($oElement->getNameAttributeValue($aField['COLUMN_NAME']));
                    $oElement->setId($oElement->getIdAttributeValue($aField['COLUMN_NAME']));
                    $this->setFormElement($oElement);
                }
                break;
            case 'json':
                $this->setVarType(VarType::STRING);
                $this->setFormElement(false);
                break;
            default : ; break;
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getArrSqlField(): array
    {
        return $this->aSqlField;
    }

    /**
     * @param array $aSqlField
     * @return SqlTypeInterpreter
     */
    public function setArrSqlField(array $aSqlField): SqlTypeInterpreter
    {
        $this->aSqlField = $aSqlField;
        return $this;
    }



    /**
     * @return string
     */
    public function getVarType(): string
    {
        return $this->varType;
    }

    /**
     * @param string $varType
     * @return SqlTypeInterpreter
     */
    public function setVarType(string $varType): SqlTypeInterpreter
    {
        $this->varType = $varType;
        return $this;
    }

    /**
     * @return bool | \FormElement
     */
    public function getFormElement()
    {
        return $this->formElement;
    }

    /**
     * @param bool | \FormElement $formElType
     * @return SqlTypeInterpreter
     */
    public function setFormElement($formElType)
    {
        $this->formElement = $formElType;
        return $this;
    }


}