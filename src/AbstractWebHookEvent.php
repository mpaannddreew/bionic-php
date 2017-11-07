<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-02
 * Time: 12:15 PM
 */

namespace Andre\Bionic;


use Andre\Bionic\Contracts\WebHookEventInterface;
use Andre\Bionic\Traits\IsADataWrapper;
use Andre\Bionic\Traits\SetsProperties;

abstract class AbstractWebHookEvent implements WebHookEventInterface
{
    use IsADataWrapper, SetsProperties;

    /**
     * AbstractWebHookEvent constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->setProperties();
    }

    /**
     * get webhook event data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}