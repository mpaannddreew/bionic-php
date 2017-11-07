<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 11:12 AM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons;



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
     * @param array $share_contents
     * @return $this
     */
    public function setShareContents($share_contents)
    {
        $this->share_contents = $share_contents;
        $this->data['share_contents'] = $this->getShareContents();
        return $this;
    }


}