<?php

namespace core;


class Validator
{
    private $key;

    private $value;

    public function __construct($key, $value)
    {
        $this->setKey($key);
        $this->setValue($value);
    }

    /**
     * @param $key
     * @param $value
     * @return Validator
     */
    public static function instance($key, $value)
    {
        $validator = new Validator($key, $value);

        return $validator;
    }


    /**
     * @return string
     */
    private function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    private function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    private function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    private function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Check value is empty
     * If value is empty generate error
     * @return $this
     */
    public function isRequired()
    {
        if (empty($this->getValue()) && !is_bool($this->getValue())) {
            $_SESSION['validation-errors'][$this->getKey()] = 'Veld is verplicht';
        }

        return $this;
    }

    public function isBoolean()
    {
        if (!$this->getValue() != 0 && !$this->getValue() != 1 && !is_bool($this->getValue())) {
            $_SESSION['validation-errors'][$this->getKey()] = 'Veld is geen boolean';
        }

        return $this;
    }

    /**
     * Check $this value is not equel to argument value
     * Generate error
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function isEqualTo($key, $value)
    {
        if ($this->getValue() != $value) {
            $_SESSION['validation-errors'][$this->getKey()] = "Veld moet overeenkomen met $key";
        }

        return $this;
    }

    /**
     * Check instance exist
     * If not generate error
     *
     * @param Model $instance
     * @param $attribute
     * @param bool $errorHandling
     * @return $this
     */
    public function exists($instance, $attribute = 'id', $errorHandling = true)
    {
        $instance->getQueryBuilder()->where($attribute, $this->getValue());

        if (!$instance->first()) {
            $key = $this->getKey();

            if ($errorHandling) {
                $_SESSION['validation-errors'][$this->getKey()] = "$key bestaat niet";
            }
        }
        
        return $this;
    }

    /**
     * Check instance not exist
     * If generate error
     * @param Model $instance
     * @return $this
     */
    public function doesNotExist($instance, $attribute = 'id')
    {
        $instance->getQueryBuilder()->where($attribute, $this->getValue());

        if ($instance->first()) {
            $key = $this->getKey();
            $_SESSION['validation-errors'][$this->getKey()] = "$key bestaat al";
        }

        return $this;
    }

    /**
     * Destroy session
     */
    public static function resetErrors()
    {
        unset($_SESSION['validation-errors']);
    }

    /**
     * Check errors exists
     * @return bool
     */
    public static function hasErrors()
    {
        return isset($_SESSION['validation-errors']);
    }

    /**
     * Get errors
     *
     * @return array
     */
    public static function getErrors()
    {
        return (self::hasErrors()) ? $_SESSION['validation-errors'] : [];
    }

}