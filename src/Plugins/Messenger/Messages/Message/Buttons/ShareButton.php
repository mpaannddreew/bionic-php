<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 11:12 AM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons;



use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\AbstractAttachment;

class ShareButton extends AbstractButton
{

    /**
     * @var array $share_contents
     */
    protected $share_contents = [];

    /**
     * set button type
     */
    protected function setType()
    {
        $this->type = self::ELEMENT_SHARE;
    }

    /**
     * get share contents
     *
     * @return array
     */
    public function getShareContents()
    {
        return $this->share_contents;
    }

    /**
     * set share contents
     *
     * @param AbstractAttachment $share_contents
     * @return $this
     */
    public function setShareContents(AbstractAttachment $share_contents)
    {
        $this->share_contents = ['attachment' => $share_contents->toArray()];
        $this->data['share_contents'] = $this->getShareContents();
        return $this;
    }
}