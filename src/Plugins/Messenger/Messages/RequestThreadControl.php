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


class RequestThreadControl extends AbstractThreadControl
{
    /**
     * @var string $requested_owner_app_id
     */
    protected $requested_owner_app_id;

    /**
     * get requested app id
     *
     * @return string
     */
    public function getRequestedOwnerAppId()
    {
        return $this->requested_owner_app_id;
    }
}