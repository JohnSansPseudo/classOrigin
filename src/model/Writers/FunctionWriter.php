<?php


namespace Writer;


class FunctionWriter implements \GetString
{
    use AbstractAble;
    use StaticAble;

    /**
     * @var string
     */
    private string $visibility=Visibility::PUBLIC;

    /**
     * @var string
     */
    private string $content='';
    /**
     * @var string
     */
    private string $name='';

    /**
     * @var FunctionParamWriter[]
     */
    private array $param=[];

    /**
     * @var string[]
     */
    private array $arrStrParam = array();

    /**
     * @var string
     */
    private string $return='';

    /**
     * @return string[]
     */
    public function getArrStrParam(): array
    {
        return $this->arrStrParam;
    }

    /**
     * @param string[] $arrStrParam
     * @return FunctionWriter
     */
    public function setArrStrParam(array $arrStrParam): FunctionWriter
    {
        $this->arrStrParam = $arrStrParam;
        return $this;
    }

    /**
     * @return string
     */
    public function getReturn(): string
    {
        return $this->return;
    }

    /**
     * @param string $return
     * @return FunctionWriter
     */
    public function setReturn(string $return): FunctionWriter
    {
        $this->return = $return;
        return $this;
    }

    public function getStringReturn()
    {
        if($this->getReturn() === '') return '';
        else return ':' . $this->getReturn();
    }



    /**
     * FunctionWriter constructor.
     * @param string $name
     * @param string $content
     * @param array $param
     * @param string $sReturn
     */
    public function __construct(string $name, string $content, string $sReturn='', array $param=[])
    {
        $this->setName($name)->setContent($content)->setParam($param)->setReturn($sReturn);
    }

    /**
     * @return string
     */
    public function getVisibility(): string
    {
        return $this->visibility;
    }

    /**
     * @param string $visibility
     * @return FunctionWriter
     */
    public function setVisibility(string $visibility): FunctionWriter
    {
        $this->visibility = $visibility;
        return $this;
    }



    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return FunctionWriter
     */
    public function setContent(string $content): FunctionWriter
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return FunctionWriter
     */
    public function setName(string $name): FunctionWriter
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return FunctionParamWriter[]
     */
    public function getParam(): array
    {
        return $this->param;
    }

    /**
     * @param FunctionParamWriter[] $param
     * @return FunctionWriter
     */
    public function setParam(array $param): FunctionWriter
    {
        $this->param = $param;
        $this->arrangeParam();
        return $this;
    }

    /**
     * @return array
     */
    private function arrangeParam():array
    {
        $aStr = array();
        $aStrDef = array();
        foreach($this->getParam() as $oParam)
        {
            if($oParam->getDefaultVal() === null) $aStr[$oParam->getName()] = $oParam->getString();
            else $aStrDef[$oParam->getName()] = $oParam->getString();
        }
        $aFinal = array_merge($aStr, $aStrDef);
        $this->setArrStrParam($aFinal);
        return $aFinal;
    }

    /**
     * @return string
     */
    public function getStringParams()
    {
        return implode(', ', $this->getArrStrParam());
    }


    public function getStringDocBloc()
    {
        $aDoc = array();
        if(count($this->getParam()) > 0){
            foreach($this->getParam() as $oParam)
            {
                $aDoc[] = new PhpDocBlocWriter('param', $oParam->getType(), $oParam->getName());
            }
        }

        if($this->getReturn() !== '')
        {
            $aDoc[] = new PhpDocBlocWriter('return', $this->getReturn(), '');
        }
        return $aDoc[0]->getString($aDoc);
    }



    /**
     * @return string
     */
    public function getString():string
    {
        $s = $this->getStringDocBloc();
        $s .= PhpWriter::TAB . $this->getStringStatic() . $this->getStringAbstract() . $this->getVisibility();
        $s .= ' function ' . $this->getName() . '(' . $this->getStringParams() . ')' . $this->getStringReturn() . PhpWriter::RETOUR;
        $s .= PhpWriter::TAB . '{' . PhpWriter::RETOUR;
        $s .= $this->getContent() . PhpWriter::RETOUR;
        $s .= PhpWriter::TAB . '}' . PhpWriter::RETOUR2;
        return $s;
    }
}