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
     * @var string $id
     */
    protected $id;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->data['id'] = $this->getId();
        return $this;
    }
}