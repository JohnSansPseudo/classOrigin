<?php


class HtmlSelectOption
{
    /**
     * @var array
     */
    private array $aData;

    /**
     * @var string
     */
    private string $sMethodVal;

    
    private $idDefault=null;

    /**
     * @var mixed
     */
    private $mOptionNull=null;

    /**
     * @var array
     */
    private array $aIdExclude=array();

    /**
     * @var array
     */
    private array $aErr = array();

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->aData;
    }


    /**
     * @return array
     */
    public function getErrArray(): array
    {
        return $this->aErr;
    }

    /**
     * @param array $aData
     * @return HtmlSelectOption
     */
    public function setArrData(array $aData): HtmlSelectOption
    {
        $oParam = new \ParamArray($aData, self::class . ' $aData', 1);
        if($oParam->getStringError() !== '') $this->aErr[] = $oParam->getStringError();
        else $this->aData = $aData;
        $this->aData = $aData;
        return $this;
    }


    public function getIdDefault()
    {
        return $this->idDefault;
    }

    /**
     * @return HtmlSelectOption
     */
    public function setIdDefault($idDefault): HtmlSelectOption
    {
        $this->idDefault = $idDefault;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptionNull()
    {
        return $this->mOptionNull;
    }

    /**
     * @return HtmlSelectOption
     */
    public function setOptionNull($mOptionNull):HtmlSelectOption
    {
        $this->mOptionNull = $mOptionNull;
        return $this;
    }

    /**
     * @return array
     */
    public function getArrIdExclude(): array
    {
        return $this->aIdExclude;
    }

    /**
     * @param array $aIdExclude
     * @return HtmlSelectOption
     */
    public function setArrIdExclude(array $aIdExclude): HtmlSelectOption
    {
        $this->aIdExclude = $aIdExclude;
        return $this;
    }

    /**
     * @param array $aData
     */
    public function __construct($aData)
    {
        $this->setArrData($aData);
    }

    /**
     * @return string
     */
    public function getString():string
    {
        $sOption = '';
        if($this->getOptionNull() !== null) $sOption = '<option value="' . $this->getOptionNull() . '">--</option>';
        foreach($this->getData() as $k => $mValue) {
            if(count($this->getArrIdExclude()) && in_array($k, $this->getArrIdExclude())) continue;
            $sSelected = '';
            if($this->getIdDefault() === $k) $sSelected = ' selected="selected"';
            $sOption .= '<option value="' . $k . '" ' . $sSelected . '>' . $mValue . '</option>';
        }
        return $sOption;
    }

}