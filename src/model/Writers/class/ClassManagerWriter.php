<?php

namespace Writer;

use Describers\TableBdd;

class ClassManagerWriter extends ClassWriter
{
    /**
     * @var ClassTableWriter | null
     */
    private ?ClassTableWriter $tableWriter=null;

    /**
     * @return ClassTableWriter
     */
    public function getTableWriter(): ?ClassTableWriter
    {
        return $this->tableWriter;
    }

    /**
     * @param ClassTableWriter $tableWriter
     * @return ClassManagerWriter
     */
    public function setTableWriter(ClassTableWriter $tableWriter): ClassManagerWriter
    {
        $this->tableWriter =$tableWriter;
        return $this;
    }


    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->getTableWriter()->getClassName() . 'Manager';
    }

    /**
     * ClassManagerWriter constructor.
     * @param ClassTableWriter $oWriterTable
     */
    public function __construct(ClassTableWriter $oWriterTable)
    {
        $this->setTableWriter($oWriterTable);
        $s = '';
        $s .= $this->getConstClassManager();
        $s .= $this->getFunctionGetInstance();
        $s .= $this->getFunctionAdd();
        $s .= $this->getFunctionPdoStateExec();
        $this->setContent($s);
    }

    /**
     * @return string
     */
    public function getConstClassManager()
    {
        $oConst = new ConstantWriter('CLASS_MANAGER', $this->getTableWriter()->getClassName(), Visibility::PUBLIC, 'string');
        return $oConst->getString();
    }

    /**
     * @return string
     */
    public function getFunctionGetInstance():string
    {
        $sContent = PhpWriter::TAB2 . 'return new ' . $this->getClassName() . '();';
        $oFunc = new FunctionWriter('getInstance', $sContent, $this->getClassName());
        $oFunc->setStatic(true)->setVisibility(Visibility::PUBLIC);
        return $oFunc->getString();
    }

    public function getFunctionAdd()
    {
        $sNameParam = 'o' . $this->getTableWriter()->getClassName();
        $aField = $this->getTableWriter()->getTable()->getFields();

        $aStrField = array();
        $sBindValue = '';


        foreach($this->getTableWriter()->getArrStrParamConst() as $sField => $sParamConst)
        {
            if(isset($aField[$sField]))
            {
                $oField = $aField[$sField];
                if($oField->isAutoIncrement()) continue;
                $aStrField[$oField->getNameFieldBdd()] = ':' . $oField->getNameFieldBdd();
                $sFuncGet = $this->getTableWriter()->getGetterFuncName($oField->getNameFieldBdd()) . '()';
                $sBindValue .= PhpWriter::TAB2 . '$oStatement->bindValue(' . "':" . $oField->getNameFieldBdd() . "'" . ', $oClient->' . $sFuncGet . ", " . $oField->getPdoParam() . ");" . PhpWriter::RETOUR;
            } else {
                throw new \Exception('Error getFunctionAdd param dosen\'t exits');
            }
        }


        //PDO PREPARE
        $sField = join(', ', array_keys($aStrField));
        $sValue = join(', ', $aStrField);
        $sContent = PhpWriter::TAB2 . '$oPDO = PDOSingleton::getInstance();' . PhpWriter::RETOUR;
        $sContent .= PhpWriter::TAB2 . '$oStatement = $oPDO->prepare("insert INTO " . self::CLASS_MANAGER . ';
        $sContent .= '"(' . $sField . ') ';
        $sContent .= 'VALUES(' . $sValue . ')");' . PhpWriter::RETOUR;
        $sContent .= PhpWriter::TAB2 . 'if(!$oStatement) return false;' . PhpWriter::RETOUR;

        //PDO BIND VALUE
        $sContent .= $sBindValue;

        //PDO EXEC
        $sContent .= PhpWriter::TAB2 . '$bExec = $oStatement->execute();' . PhpWriter::RETOUR;
        $sContent .= PhpWriter::TAB2 . 'if(!$bExec) return $bExec;' . PhpWriter::RETOUR;
        $sContent .= PhpWriter::TAB2 . PhpWriter::getVarName($sNameParam) .  '->setId($oPDO->lastInsertId());' . PhpWriter::RETOUR;
        $sContent .= PhpWriter::TAB2 . 'return ' . PhpWriter::getVarName($sNameParam) . ';';

        $aParam = array();
        $aParam[] = new FunctionParamWriter($sNameParam, $this->getTableWriter()->getClassName());
        $oFunc = new FunctionWriter('add', $sContent, '', $aParam);
        $oFunc->setVisibility(Visibility::PUBLIC);
        return $oFunc->getString();
    }

    public function getFunctionPdoStateExec()
    {
        $aField = $this->getTableWriter()->getTable()->getFields();
        $aFetchObj = array();
        foreach($this->getTableWriter()->getArrStrParamConst() as $sField => $sParamConst) {
            if (isset($aField[$sField])) {
                $oField = $aField[$sField];
                $aFetchObj[] = '$o->' . $oField->getNameFieldBdd();
            }
        }

        $sNameParam = 'oState';
        $sContent = PhpWriter::TAB2 . '$bExec = $oState->execute();' . PhpWriter::RETOUR;
        $sContent .= PhpWriter::TAB2 . 'if(!$bExec) return $bExec;' . PhpWriter::RETOUR;
        $sContent .= PhpWriter::TAB2 . '$aData = array();' . PhpWriter::RETOUR;
        $sContent .= PhpWriter::TAB2 . 'while ($o = $oState->fetch(PDO::FETCH_OBJ))' . PhpWriter::RETOUR;
        $sContent .= PhpWriter::TAB2 . '{' . PhpWriter::RETOUR;
        $sContent .= PhpWriter::TAB3 . '$aData[$o->id] = new self::CLASS_MANAGER(' . join(', ', $aFetchObj) . ');' . PhpWriter::RETOUR;
        $sContent .= PhpWriter::TAB2 . '}' . PhpWriter::RETOUR;
        $sContent .= PhpWriter::TAB2 . 'return $aData';

        $aParam = array();
        $aParam[] = new FunctionParamWriter($sNameParam, 'PDOStatement');
        $oFunc = new FunctionWriter('pdoStateExec', $sContent, '', $aParam);
        $oFunc->setVisibility(Visibility::PUBLIC);
        return $oFunc->getString();
    }
}


