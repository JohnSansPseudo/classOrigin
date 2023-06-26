<?php


namespace Writer;


class PhpDocBlocWriter implements \GetString
{

    /**
     * @var string
     */
    private string $type='';

    /**
     * @var string
     */
    private string $name='';

    /**
     * @var string
     */
    private string $typeBloc='';

    /**
     * PhpDocBlocWriter constructor.
     * @param string $type
     * @param string $name
     * @param string $typeBloc
     */
    public function __construct(string $typeBloc, string $type, string $name='')
    {
        $this->setType($type)->setTypeBloc($typeBloc);
        if($name !== '') $this->setName($name);
        $this->type = $type;
        $this->name = $name;
        $this->typeBloc = $typeBloc;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTypeBloc(): string
    {
        return $this->typeBloc;
    }

    /**
     * @param string $typeBloc
     * @return PhpDocBlocWriter
     */
    public function setTypeBloc(string $typeBloc): PhpDocBlocWriter
    {
        $this->typeBloc = $typeBloc;
        return $this;
    }

    /**
     * @param string $type
     * @return PhpDocBlocWriter
     */
    public function setType(string $type): PhpDocBlocWriter
    {
        $this->type = $type;
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
     * @return PhpDocBlocWriter
     */
    public function setName(string $name): PhpDocBlocWriter
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $sName
     * @return string
     */
    public function getStringName(string $sName)
    {
        if($sName === '') return '';
        else return '$' . $sName;
    }

    /**
     * @param array |null $aPhpDoc
     * @return string
     */
    public function getString(?array $aPhpDoc=null):string
    {
        if(!$aPhpDoc)$aPhpDoc = array($this);
        $s = PhpWriter::TAB . '/**' . PhpWriter::RETOUR;
        /**
         *@var PhpDocBlocWriter $oPhpDoc
         */
        foreach($aPhpDoc as $oPhpDoc)
        {
            $s .= PhpWriter::TAB . '* @' . $oPhpDoc->getTypeBloc() . ' ' . $oPhpDoc->getType() . ' ' . $this->getStringName($oPhpDoc->getName()) . PhpWriter::RETOUR;
        }
        $s .= PhpWriter::TAB . '*/' . PhpWriter::RETOUR;
        return $s;
    }


}