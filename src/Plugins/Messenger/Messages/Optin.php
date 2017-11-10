<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 6:59 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages;


use Andre\Bionic\AbstractMessage;

class Optin extends AbstractMessage
{
    /**
     * @var string $ref
     */
    protected $ref;

    /**
     * @var string $user_ref
     */
    protected $user_ref;

    /**
     * get ref
     *
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
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