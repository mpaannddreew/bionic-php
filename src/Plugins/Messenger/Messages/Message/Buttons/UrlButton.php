<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 11:06 AM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons;


class UrlButton extends AbstractButton
{
    /**
     * @var string $url
     */
    protected $url;

    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string
     */
    protected $webview_height_ratio = 'full';

    /**
     * @var bool
     */
    protected $messenger_extensions;

    /**
     * @var string $fallback_url
     */
    protected $fallback_url;

    /**
     * @var string $webview_share_button
     */
    protected $webview_share_button;

    /**
     * set button type
     */
    protected function setType()
    {
        $this->type = self::WEB_URL;
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

    /**
     * get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * set title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->data['title'] = $this->getTitle();
        return $this;
    }

    /**
     * get webview height ratio
     *
     * @return string
     */
    public function getWebviewHeightRatio()
    {
        return $this->webview_height_ratio;
    }

    /**
     * set webview height ratio
     *
     * @param string $webview_height_ratio
     * @return $this
     */
    public function setWebviewHeightRatio($webview_height_ratio)
    {
        $this->webview_height_ratio = $webview_height_ratio;
        $this->data['webview_height_ratio'] = $this->getWebviewHeightRatio();
        return $this;
    }

    /**
     * get messenger  extensions
     *
     * @return bool
     */
    public function isMessengerExtensions()
    {
        return $this->messenger_extensions;
    }

    /**
     * set messenger extensions
     *
     * @param bool $messenger_extensions
     * @return $this
     */
    public function setMessengerExtensions($messenger_extensions)
    {
        $this->messenger_extensions = $messenger_extensions;
        $this->data['messenger_extensions'] = $this->isMessengerExtensions();
        return $this;
    }

    /**
     * get fallback url
     *
     * @return string
     */
    public function getFallbackUrl()
    {
        return $this->fallback_url;
    }

    /**
     * set fallback url
     *
     * @param string $fallback_url
     * @return $this
     */
    public function setFallbackUrl($fallback_url)
    {
        $this->fallback_url = $fallback_url;
        $this->data['fallback_url'] = $this->getFallbackUrl();
        return $this;
    }

    /**
     * get webview share button
     *
     * @return string
     */
    public function getWebviewShareButton()
    {
        return $this->webview_share_button;
    }

    /**
     * set webview share button
     *
     * @param string $webview_share_button
     * @return $this
     */
    public function setWebviewShareButton($webview_share_button)
    {
        $this->webview_share_button = $webview_share_button;
        $this->data['webview_share_button'] = $this->getWebviewShareButton();
        return $this;
    }
}