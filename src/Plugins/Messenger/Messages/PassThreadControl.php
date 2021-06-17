<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-11
 * Time: 6:14 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages;


class PassThreadControl extends AbstractThreadControl
{
    /**
     * @var string $new_owner_app_id
     */
    protected $new_owner_app_id;

    /**
     * @var string $previous_owner_app_id
     */
    protected $previous_owner_app_id;

    /**
     * get new owner app id
     *
     * @return string
     */
    public function getNewOwnerAppId()
    {
        return $this->new_owner_app_id;
    }

    /**
     * @return string
     */
    public function getPreviousOwnerAppId()
    {
        return $this->previous_owner_app_id;
    }
}