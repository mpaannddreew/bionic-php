<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-02
 * Time: 12:10 PM
 */

namespace Andre\Bionic;


use Andre\Bionic\Contracts\MessageInterface;
use Andre\Bionic\Traits\IsADataWrapper;

abstract class AbstractMessage implements MessageInterface
{
    use IsADataWrapper;

    /**
     * AbstractMessage constructor.
     * @param $data
     */
    public function __construct($data = [])
    {
        $this->data = $data;
        $this->setAttributes();
    }

    protected function setAttributes()
    {
        foreach ($this->data as $key => $value){
            if (property_exists($this, $key))
                $this->{$key} = $value;
        }
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}