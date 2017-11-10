<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 6:53 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages;


class Referral extends Optin
{
    /**
     * @var string $source
     */
    protected $source;

    /**
     * @var string $type
     */
    protected $type;

    /**
     * get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}