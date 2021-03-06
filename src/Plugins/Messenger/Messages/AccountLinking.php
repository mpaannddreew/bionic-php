<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 7:01 PM
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

class AccountLinking extends AbstractMessage
{
    /**
     * @var string $status
     */
    protected $status;

    /**
     * @var string $authorization_code
     */
    protected $authorization_code;

    /**
     * get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * get authorization code
     *
     * @return string
     */
    public function getAuthorizationCode()
    {
        return $this->authorization_code;
    }
}