<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 12:29 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\EndPoint;


use Andre\Bionic\AbstractMessage;

abstract class AbstractEndPoint extends AbstractMessage
{
    /**
     * @var string $id
     */
    protected $id;

    /**
     * @var string $user_ref
     */
    protected $user_ref;

    /**
     * get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * set id
     *
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->data['id'] = $this->getId();
        return $this;
    }

    /**
     * @return string
     */
    public function getUserRef()
    {
        return $this->user_ref;
    }

    /**
     * @param string $user_ref
     * @return $this
     */
    public function setUserRef($user_ref)
    {
        $this->user_ref = $user_ref;
        $this->data['user_ref'] = $this->getUserRef();
        return $this;
    }
}