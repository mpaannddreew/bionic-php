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
}