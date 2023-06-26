<?php


class Textarea extends FormElement
{
    use StdAttributes;

    /**
     * @var int
     */
    private int $cols=3;

    /**
     * @var int
     */
    private int $rows=1;

    /**
     * @return int
     */
    public function getCols(): int
    {
        return $this->cols;
    }

    /**
     * @param int $cols
     * @return Textarea
     */
    public function setCols(int $cols): Textarea
    {
        $this->cols = $cols;
        return $this;
    }

    /**
     * @return int
     */
    public function getRows(): int
    {
        return $this->rows;
    }

    /**
     * @param int $rows
     * @return Textarea
     */
    public function setRows(int $rows): Textarea
    {
        $this->rows = $rows;
        return $this;
    }

    /**
     * @return string
     */
    public function getStringRows()
    {
        if($this->getRows() !== '') return 'rows="'  . $this->getRows() . '" ';
    }

    /**
     * @return string
     */
    public function getStringCols()
    {
        if($this->getCols() !== '') return 'cols="'  . $this->getCols() . '" ';
    }

    /**
     * @return string
     */
    public function getStringElement():string
    {
        return '<textarea '
                    . $this->getStringRows()
                    . $this->getStringCols()
                    . $this->getStringName()
                    . $this->getStringId()
                    . $this->getStringClass()
                . '></textarea>';
    }

    /**
     * Textarea constructor.
     * @param string $sLabel
     */
    public function __construct(string $sLabel)
    {
        parent::setLabel($sLabel);
    }

    public function getNameAttributeValue($sNameFieldBdd)
    {
        return 'txt' . ucfirst($sNameFieldBdd);
    }

    public function getIdAttributeValue($sNameFieldBdd)
    {
        return 'txt' . ucfirst($sNameFieldBdd);
    }

}