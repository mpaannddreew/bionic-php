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
use Andre\Bionic\Traits\SetsProperties;

abstract class AbstractMessage implements MessageInterface
{
    use IsADataWrapper, SetsProperties;

    /**
     * AbstractMessage constructor.
     * @param $data
     */
    public function __construct($data = [])
    {
        $this->data = $data;
        $this->setProperties();
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}