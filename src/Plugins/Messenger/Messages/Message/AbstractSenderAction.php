<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-04
 * Time: 1:20 AM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message;


use Andre\Bionic\AbstractMessage;

abstract class AbstractSenderAction extends AbstractMessage
{
    const MARK_SEEN = 'mark_seen';

    const TYPING_ON = 'typing_on';

    const TYPING_OFF = 'typing_off';

    const REACT = 'react';

    const UNREACT = 'unreact';

    /**
     * @var string $sender_action
     */
    protected $sender_action;

    /**
     * SenderAction constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        if(!$this->getSenderAction()){
            $this->setSenderAction();
            $this->data['sender_action'] = $this->getSenderAction();
        }
    }

    /**
     * get sender action
     *
     * @return string
     */
    public function getSenderAction()
    {
        return $this->sender_action;
    }

    /**
     * set sender action
     */
    abstract protected function setSenderAction();
}