<?php


class MultiSelector extends FormElement
{
    /**
     * @var array
     */
    private array $arrData=array();
    /**
     * @var string
     */
    private string $title='';

    /**
     * @var array
     */
    private array $arrIdSelected=array();

    /**
     * @return array
     */
    public function getArrData(): array
    {
        return $this->arrData;
    }

    /**
     * @param array $arrData
     * @return MultiSelector
     */
    public function setArrData(array $arrData): MultiSelector
    {
        $this->arrData = $arrData;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return MultiSelector
     */
    public function setTitle(string $title): MultiSelector
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return array
     */
    public function getArrIdSelected(): array
    {
        return $this->arrIdSelected;
    }

    /**
     * @param array $arrIdSelected
     * @return MultiSelector
     */
    public function setArrIdSelected(array $arrIdSelected): MultiSelector
    {
        $this->arrIdSelected = $arrIdSelected;
        return $this;
    }

    /**
     * MultiSelector constructor.
     * @param array $aData
     * @param string $sTitle
     * @param string $sLabel
     */
    public function __construct(array $aData, string $sTitle, string $sLabel)
    {
        parent::__construct($sLabel);
        $this->setArrData($aData)->setTitle($sTitle);
    }

    /***
     * @return string
     */
    private function getBodyHtml():string
    {
        $sBody = '';
        foreach($this->getArrData() as $id => $sName)
        {
            $bChecked = false;
            if(count($this->getArrIdSelected()) && in_array($id, $this->getArrIdSelected())) $bChecked = true;

            $sBody .= $this->getRowSelMul($id, $sName, $bChecked);
        }
        return '<div class="rowSection">' . $sBody . '</div>';
    }

    /**
     * @param $id
     * @param $sName string
     * @param $bChecked bool
     * @return string
     */
    private function getRowSelMul($id, string $sName, bool $bChecked)
    {
        $sChecked = '';
        if($bChecked) $sChecked = ' checked=checked';
        return '<div class="ctnRowMultiSelect mHover ">
                    <input type="checkbox" value="' . $id .'" class="mHover" ' . $sChecked . '/>
                    <label class="mHover">' . $sName . '</label>
                </div>';
    }

    /**
     * @return string
     */
    public function getStringElement():string
    {
        return  '<div class="MultiSelect form-select mHover">
                    <div class="ctnMultiSelect hide">
                        <div class="head">
                            <div class="title">' . $this->getTitle() . '</div>
                        </div><div class="body">' . $this->getBodyHtml() . '</div>
                    </div>
                </div>';
    }

}