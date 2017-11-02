<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-02
 * Time: 11:20 AM
 */

namespace Andre\Bionic\Traits;


trait IsADataWrapper
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @return array
     */
    public function toArray(){
        return $this->data;
    }

    /**
     * @param int $options
     * @return string
     */
    public function toJson($options = 0){
        return json_encode($this->toArray(), $options);
    }

    /**
     * @return string
     */
    public function __toString(){
        return $this->toJson();
    }
}