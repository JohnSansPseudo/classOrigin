<?php


trait StdAttributes
{
    /**
     * @var string
     */
    private string $id='';

    /**
     * @var array
     */
    private array $class=array();

    /**
     * @var array
     */
    private array $attribute=array();

    /**
     * @var string
     */
    private string $name='';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return array
     */
    public function getClass(): array
    {
        return $this->class;
    }

    /**
     * @param array $class
     */
    public function setClass(array $class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttribute(): array
    {
        return $this->attribute;
    }

    /**
     * @param array $attribute
     */
    public function setAttribute(array $attribute)
    {
        $this->attribute = $attribute;
        return $this;
    }

    /**
     * @return string
     */
    public function getStringId():string
    {
        if($this->getId() !== '') return 'id="' . $this->getId() . '" ';
        return '';
    }

    /**
     * @return string
     */
    public function getStringClass():string
    {
        if(count($this->getClass()) > 0) {
            return 'class="' . implode(', ', $this->getClass()) . '" ';
        } else return '';
    }

    /**
     * @return string
     */
    public function getStringName():string
    {
        if($this->getName() !== '') return 'name="' . $this->getName() . '" ';
        return '';
    }

    /**
     * @return string
     */
    public function getStringAttributes():string
    {
        if(count($this->getAttribute()) > 0){
            $a = array();
            foreach($this->getAttribute() as $k => $v) { $a[] = $k . '="' . $v . '" '; }
            return implode(' ', $a);
        } else {
            return '';
        }
    }


}