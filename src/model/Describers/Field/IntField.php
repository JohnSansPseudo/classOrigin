<?php

namespace Describers;

class IntField extends FieldBdd
{
    /**
     * @var int|null
     */
    private ?int $min;
    /**
     * @var int|null
     */
    private ?int $max;

    /**
     * IntField constructor.
     * @param string $nameFieldBdd
     * @param string $label
     */
    public function __construct(string $nameFieldBdd, string $label='')
    {
        parent::__construct($nameFieldBdd, $label);
        $this->setType('int');
        $this->setPdoParam('PDO::PARAM_INT');
    }



    /**
     * @return int|null
     */
    public function getMin(): ?int
    {
        return $this->min;
    }

    /**
     * @param int|null $min
     * @return IntField
     */
    public function setMin(?int $min): IntField
    {
        $this->min = $min;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMax(): ?int
    {
        return $this->max;
    }

    /**
     * @param int|null $max
     * @return IntField
     */
    public function setMax(?int $max): IntField
    {
        $this->max = $max;
        return $this;
    }
}