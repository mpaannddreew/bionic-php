<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 11:18 AM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons;


class LoginButton extends AbstractButton
{

    /**
     * @var string $url
     */
    protected $url;

    /**
     * set button type
     */
    protected function setType()
    {
        $this->type = self::ACCOUNT_LINK;
    }

    /**
     * get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * set url
     *
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        $this->data['url'] = $this->getUrl();
        return $this;
    }
}