<?php


namespace Writer;

trait StaticAble
{

    /**
     * @var bool
     */
    private bool $static=false;


    /**
     * @return string
     */
    public function getStringStatic()
    {
        if($this->isStatic()) return 'static ';
        else return '';
    }

    /**
     * @return bool
     */
    public function isStatic(): bool
    {
        return $this->static;
    }

    /**
     * @param bool $static
     */
    public function setStatic(bool $static)
    {
        $this->static = $static;
        return $this;
    }
}