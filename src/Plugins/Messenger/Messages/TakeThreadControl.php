<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-11
 * Time: 6:16 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages;


class TakeThreadControl extends AbstractThreadControl
{
    /**
     * @var string $previous_owner_app_id
     */
    protected $previous_owner_app_id;

    /**
     * get previous owner app id
     *
     * @return string
     */
    public function getPreviousOwnerAppId()
    {
        return $this->previous_owner_app_id;
    }
}