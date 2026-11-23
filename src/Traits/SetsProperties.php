<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Traits;


trait SetsProperties
{
    /**
     * set properties from data passed to constructor
     *
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