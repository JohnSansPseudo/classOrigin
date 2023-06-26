<?php

namespace Writer;

trait AbstractAble
{
    /**
     * @var bool
     */
    private bool $abstract=false;

    /**
     * @return bool
     */
    public function isAbstract(): bool
    {
        return $this->abstract;
    }

    /**
     * @param bool $abstract
     */
    public function setAbstract(bool $abstract)
    {
        $this->abstract = $abstract;
    }


    /**
     * @return string
     */
    public function getStringAbstract()
    {
        if($this->isAbstract()) return 'abstract ';
        else return '';
    }
}