<?php

namespace JavierSeixas;

use Prophecy\Argument\Token\TokenInterface;
use Prophecy\Comparator\Factory as ComparatorFactory;
use Prophecy\Util\StringUtil;

/**
 * Exact Ignorable value token.
 * This value token allows to compare to objects, ignoring some properties in both
 *
 * @author Javier Seixas
 */
class ExactIgnorableValueToken implements TokenInterface
{
    private $value;
    private $string;
    private $util;
    private $comparatorFactory;
    private $ignorableFields;

    /**
     * Initializes token.
     *
     * @param mixed             $value
     * @param StringUtil        $util
     * @param ComparatorFactory $comparatorFactory
     */
    public function __construct($value, array $ignorableFields = [], StringUtil $util = null, ComparatorFactory $comparatorFactory = null)
    {
        $this->value = $value;
        $this->util  = $util ?: new StringUtil();

        $this->ignorableFields = $ignorableFields;
        $this->comparatorFactory = $comparatorFactory ?: ComparatorFactory::getInstance();
    }

    /**
     * Scores 10 if argument matches preset value.
     *
     * @param $argument
     *
     * @return bool|int
     */
    public function scoreArgument($argument)
    {
        $propertiesValue = (new \ReflectionObject($this->value))->getProperties();
        $propertiesArgument = (new \ReflectionObject($argument))->getProperties();

        if (count($propertiesArgument) !== count($propertiesValue)) {
            return false;
        }

        foreach ($propertiesValue as $key => $property) {
            if (in_array($property->getName(), $this->ignorableFields)) {
                continue;
            }
            $property->setAccessible(true);

            if ($property->getValue($this->value) != $property->getValue($argument)) {
                return false;
            }
        }

        return 10;
    }

    /**
     * Returns preset value against which token checks arguments.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Returns false.
     *
     * @return bool
     */
    public function isLast()
    {
        return false;
    }

    /**
     * Returns string representation for token.
     *
     * @return string
     */
    public function __toString()
    {
        if (null === $this->string) {
            $this->string = sprintf('exact(%s)', $this->util->stringify($this->value));
        }

        return $this->string;
    }
}

