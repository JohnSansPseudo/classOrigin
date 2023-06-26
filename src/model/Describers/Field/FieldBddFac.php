<?php

namespace Describers;

class FieldBddFac
{
    /**
     * @param string $sType
     * @param string $sName
     * @param string $sLabel
     * @return IntField|StringField|null
     */
    public static function getInstanceFieldBdd(string $sType, string $sName, string $sLabel='')
    {
        switch ($sType)
        {
            case VarType::INT : $oInstance = new IntField($sName, $sLabel); break;
            case VarType::STRING : $oInstance = new StringField($sName, $sLabel); break;
            case VarType::BOOL : $oInstance = new BoolField($sName, $sLabel); break;
            default : $oInstance = null; break;
        }
        return $oInstance;
    }
}