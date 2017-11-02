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

abstract class AbstractWebHookEvent implements WebHookEventInterface
{
    use IsADataWrapper;

    /**
     * AbstractWebHookEvent constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}