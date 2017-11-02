<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-02
 * Time: 11:16 AM
 */

namespace Andre\Bionic\Contracts;


interface DataWrapperInterface
{
    public function toArray();

    public function toJson();

    public function __toString();
}