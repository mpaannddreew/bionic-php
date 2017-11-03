<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 12:29 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\EndPoint;


use Andre\Bionic\AbstractMessage;

class AbstractEndPoint extends AbstractMessage
{
    /**
     * @var $id
     */
    protected $id;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}