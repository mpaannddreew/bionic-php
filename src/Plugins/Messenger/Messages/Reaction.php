<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 16/06/2021
 * Time: 22:38
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

class Reaction extends AbstractMessage
{
    /**
     * @var string $mid
     */
    protected $mid;

    /**
     * @var string $action
     */
    protected $action;

    /**
     * @var string $reaction
     */
    protected $reaction;

    /**
     * @var string $emoji
     */
    protected $emoji;

    /**
     * @return string
     */
    public function getMid()
    {
        return $this->mid;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getReaction()
    {
        return $this->reaction;
    }

    /**
     * @return string
     */
    public function getEmoji()
    {
        return $this->emoji;
    }
}