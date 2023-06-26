<?php


namespace Writer;
use Describers\TableBdd as TableBdd;

abstract class ClassWriter implements \GetString
{
    use AbstractAble;

    /**
     * @var string
     */
    private string $content='';

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return ClassWriter
     */
    public function setContent(string $content): ClassWriter
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    abstract public function getClassName(): string;

    /**
     * @return string
     */
    public function getString():string
    {
        $s = $this->getStringAbstract() . 'class ' . static::getClassName() . PhpWriter::RETOUR;
        $s .= '{' . PhpWriter::RETOUR;
        $s .=  $this->getContent() . PhpWriter::RETOUR;
        $s .= '}' . PhpWriter::RETOUR2;
        return $s;
    }

}