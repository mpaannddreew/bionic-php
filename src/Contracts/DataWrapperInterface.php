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
    /**
     * array representation of data
     */
    public function toArray();

    /**
     * json representation of data
     */
    public function toJson();

    /**
     * string representation of data
     */
    public function __toString();
}