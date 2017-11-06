<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 9:00 PM
 */

namespace Andre\Bionic\Traits;


trait SetsProperties
{
    /**
     * set attributes
     */
    protected function setProperties()
    {
        foreach ($this->data as $key => $value){
            if (property_exists($this, $key))
                $this->{$key} = $value;
        }
    }
}