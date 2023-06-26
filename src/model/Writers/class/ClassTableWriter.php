<?php

namespace Writer;

use Describers\FieldBdd as FieldBdd;
use Describers\TableBdd as TableBdd;

class ClassTableWriter extends ClassWriter
{
    /**
     * @var TableBdd
     */
    private TableBdd $table;

    /**
     * @var string[]
     */
    private array $arrStrParamConst = array();

    /**
     * @return string[]
     */
    public function getArrStrParamConst(): array
    {
        return $this->arrStrParamConst;
    }

    /**
     * @param string[] $arrStrParamConst
     * @return ClassTableWriter
     */
    public function setArrStrParamConst(array $arrStrParamConst): ClassTableWriter
    {
        $this->arrStrParamConst = $arrStrParamConst;
        return $this;
    }

    /**
     * @return TableBdd
     */
    public function getTable(): TableBdd
    {
        return $this->table;
    }

    /**
     * @param TableBdd $table
     * @return classWriter
     */
    public function setTable(TableBdd $table): classWriter
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return ucfirst($this->getTable()->getNameBdd());
    }

    /**
     * ClassTableWriter constructor.
     * @param TableBdd $oTable
     */
    public function __construct(TableBdd $oTable)
    {
        $this->setTable($oTable);
        $s = $this->getProps();
        $s .= $this->getGettersFunctions();
        $s .= $this->getSettersFunctions();
        $s .= $this->getFunctionConstruct();
        $this->setContent($s);
    }

    /**
     * @return string
     */
    private function getProps()
    {
        $sProps = '';
        $oTable = $this->getTable();
        /**
         * @var $oField FieldBdd
         */
        foreach($oTable->getFields() as $oField){
            $oPhpBloc = new PhpDocBlocWriter('var', $oField->getType(), $oField->getNameFieldBdd());
            $sProps .= $oPhpBloc->getString();
            $sProps .= PhpWriter::TAB . 'private ' . $oField->getType() . ' $' . $oField->getNameFieldBdd() . ';'. PhpWriter::RETOUR2;
        }
        $sProps .= PhpWriter::RETOUR;
        return $sProps;
    }

    /**
     * @return string
     */
    private function getGettersFunctions()
    {
        //TODO mettre une option écriture sur une ligne

        $sGetters = '';
        $oTable = $this->getTable();

        /**
         * @var $oField FieldBdd
         */
        foreach($oTable->getFields() as $oField){
            $sFunctionName = $this->getGetterFuncName($oField->getNameFieldBdd());
            $sContent = PhpWriter::TAB2 . 'return $this->' . $oField->getNameFieldBdd() . ';';
            $oFunction = new FunctionWriter($sFunctionName, $sContent, $oField->getType());
            $sGetters .= $oFunction->getString();
        }
        return $sGetters;
    }

    /**
     * @return string
     */
    private function getSettersFunctions()
    {
        //TODO RENVOYER AU CHECK PARAM DES CLASS POUR CHAQUE TYPE
        $sSetters = '';
        $oTable = $this->getTable();
        /**
         * @var $oField FieldBdd
         */
        foreach($oTable->getFields() as $oField){
            $sFunctionName = $this->getSetterFuncName($oField->getNameFieldBdd());
            $aParam = array();
            $aParam[] = new FunctionParamWriter($oField->getNameFieldBdd(), $oField->getType(), $oField->getDefaultValue());
            $sContent = PhpWriter::TAB2 . '$this->' . $this->getPropName($oField->getNameFieldBdd()) . ' = ' . PhpWriter::getVarName($oField->getNameFieldBdd()) . ';' . PhpWriter::RETOUR;
            $sContent .= PhpWriter::TAB2 . 'return $this;';
            $oFunction = new FunctionWriter($sFunctionName, $sContent, $this->getClassName(), $aParam);
            $sSetters .= $oFunction->getString();
        }
        return $sSetters;
    }

    /**
     * @return string
     */
    private function getPropName($sName)
    {
        return $sName;
    }

    /**
     * @return string
     */
    private function getSetterFuncName($sName)
    {
        return 'set' . ucfirst($sName);
    }

    /**
     * @return string
     */
    public function getGetterFuncName($sName)
    {
        return 'get' . ucfirst($sName);
    }

    public function getFunctionConstruct()
    {
        $sContent = '';
        $aParam = [];
        $oTable = $this->getTable();

        /**
         * @var FieldBdd $oField
         */
        foreach($oTable->getFields() as $oField)
        {
            $aParam[] = new FunctionParamWriter($oField->getNameFieldBdd(), $oField->getType(), $oField->getDefaultValue());
            $sContent .= PhpWriter::TAB2 . '$this->' . $this->getSetterFuncName($oField->getNameFieldBdd());
            $sContent .= '(' . PhpWriter::getVarName($oField->getNameFieldBdd()) . ');' . PhpWriter::RETOUR;
        }
        $oFunction = new FunctionWriter('__construct', $sContent, '', $aParam);
        $this->setArrStrParamConst($oFunction->getArrStrParam());

        return $oFunction->getString();
    }

    /**
     * @return string
     */
    /*public function getFunctionToArray()
    {
        $sContent = PhpWriter::TAB2 . '$aData = array();' . PhpWriter::RETOUR;
        foreach($this->getDataTable() as $aData){
            $sColName = $aData['COLUMN_NAME'];
            $sContent .= PhpWriter::TAB2 . "\$aData['" . $sColName . "'] = \$this->" . $this->getGetterFuncName($sColName) . "();" . PhpWriter::RETOUR;
        }
        $sContent .= PhpWriter::TAB2 . 'return $this;';
        $oWriter = new FunctionWriter('toArray', '$aData', $sContent);
        return $oWriter->getFunctionStr();
    }*/

    //FIN PROPS GETTERS SETTERS TYPE HYDRATE TOARRAY




}