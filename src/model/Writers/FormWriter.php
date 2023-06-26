<?php


namespace Writer;


class FormWriter
{
    /**
     * @var ClassTableWriter
     */
    private ClassTableWriter $oWriterClassTable;

    /**
     * @return ClassTableWriter
     */
    public function getWriterClassTable(): ClassTableWriter
    {
        return $this->oWriterClassTable;
    }

    /**
     * @param ClassTableWriter $oWriterClassTable
     * @return FormWriter
     */
    public function setWriterClassTable(ClassTableWriter $oWriterClassTable): FormWriter
    {
        $this->oWriterClassTable = $oWriterClassTable;
        return $this;
    }

    public function __construct(ClassTableWriter $oWriterClassTable)
    {
        $this->setWriterClassTable($oWriterClassTable);
    }

    public function getFormAdd()
    {
        $oTable = $this->getWriterClassTable()->getTable();
        $sAction = '?????';
        $aFormElement = [];
        foreach ($oTable->getFields() as $oField)
        {
            if($oField->getFormElement() !== false) $aFormElement[] = $oField->getFormElement();
        }

        $oSubmit = new \FormSubmit($oTable->getNameBdd());
        $oForm = new \Form($sAction, $aFormElement, $oSubmit);
        return $oForm->getString();
    }
}