<?php


abstract class ManagerObjTable
{

    //abstract function createTable(): bool;
    static abstract function getTableName(): string;
    const CLASS_MANAGER = self::CLASS;


    /**
     * @param $id int
     * @return bool
     */
    public function deleteById(int $id)
    {
        $oPDO = PDOSingleton::getInstance();
        $oStatement = $oPDO->prepare("DELETE FROM " . static::CLASS_MANAGER . " WHERE id=:id");
        $oStatement->bindParam(':id', $id, PDO::PARAM_INT);
        return $oStatement->execute();
    }

    /**
     * @param $id int
     * @param $aData array
     * @return bool
     */
    public function updateById(int $id, array $aData):bool
    {
        $oPDO = PDOSingleton::getInstance();
        $aDataRem = array();
        foreach($aData as $key => $val) { $aDataRem[] = $key . '=:' . $key; }
        $sData = join(', ', $aDataRem);
        $oStatement = $oPDO->prepare("UPDATE " . static::CLASS_MANAGER . " SET " . $sData . " WHERE id=:id");
        $oStatement->bindValue(':id', $id, PDO::PARAM_INT);
        foreach($aData as $k => $v)
        {
            $oStatement->bindValue(':' . $k, $v);
        }
        //dbrDie($oStatement->queryString);
        return $oStatement->execute();
    }

    /*
     * @param string $sOrderBy
     * @return array | bool
     */
    public function getAllData(string $sOrderBy='')
    {
        $oPDO = PDOSingleton::getInstance();
        $oStatement = $oPDO->prepare("SELECT * FROM " . static::CLASS_MANAGER . " " .$sOrderBy);
        return static::statementGetExecute($oStatement);
    }


    /**
     * @param array $aParam
     * @param string $sOrDerBy
     * @return array | bool
     */
    public function getDataByWhere(array $aParam, string $sOrDerBy='')
    {
        $oPDO = PDOSingleton::getInstance();
        $aDataRem = array();
        foreach($aParam as $key => $val) { $aDataRem[] = $key . '=:' . $key; }
        $sData = join(' AND ', $aDataRem);
        $oStatement = $oPDO->prepare("SELECT * FROM " . static::CLASS_MANAGER . " WHERE " . $sData . " " . $sOrDerBy);
        foreach($aParam as $k => $v)
        {
            $oStatement->bindValue(':' . $k, $v);
        }
        return static::satementGetExecute($oStatement);
    }

    /*public function add($oObj)
    {
        $oPDO = PDOSingleton::getInstance();
        $aData = $this->objectToArray($oObj, array('aErr'));
        $aDataRem = array();
        foreach($aData as $key => $val) { $aDataRem[] = ':' . $key; }
        $sKey = '(' . join(', ', array_keys($aData)) . ')';
        $sValues = join(', ', $aDataRem);
        $oStatement = $oPDO->prepare("insert INTO " . static::getTableName() . $sKey . " VALUES(" . $sValues . ")");
        if(!$oStatement) return false;
        foreach($aData as $k => $v)
        {
            $oStatement->bindValue(':' . $k, $v);
        }
        $bExec = $oStatement->execute();
        if(!$bExec) return $bExec;
        $oObj->setId($oPDO->lastInsertId());
        return $oObj;
    }*/


}