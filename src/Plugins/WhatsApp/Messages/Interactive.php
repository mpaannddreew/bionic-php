<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\WhatsApp\Messages;

use Andre\Bionic\AbstractMessage;

/**
 * An interactive message.
 *
 * Outgoing: send it with WhatsAppPlugin::sendMessage('interactive', $interactive, $to).
 * The data is the "interactive" object of the Cloud API request
 * (type, header, body, footer, action).
 *
 * Incoming: Message::getInteractive() returns the user's reply, whose type is
 * "button_reply" or "list_reply".
 */
class Interactive extends AbstractMessage
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $header = [];

    /**
     * @var array
     */
    protected $body = [];

    /**
     * @var array
     */
    protected $footer = [];

    /**
     * @var array
     */
    protected $action = [];

    /**
     * @var array
     */
    protected $button_reply = [];

    /**
     * @var array
     */
    protected $list_reply = [];

    /**
     * Build a reply-buttons message (up to 3 buttons)
     *
     * @param string $body body text
     * @param array $buttons button titles keyed by button id, e.g. ['yes' => 'Yes', 'no' => 'No']
     * @param array $header optional header object, e.g. ['type' => 'text', 'text' => 'Hello']
     * @param string|null $footer optional footer text
     * @return static
     */
    public static function buttons($body, array $buttons, array $header = [], $footer = null)
    {
        $replies = [];

        foreach ($buttons as $id => $title) {
            $replies[] = ['type' => 'reply', 'reply' => ['id' => (string) $id, 'title' => $title]];
        }

        return static::create(static::build('button', $body, ['buttons' => $replies], $header, $footer));
    }

    /**
     * Build a list message
     *
     * @param string $body body text
     * @param string $button label of the button that opens the list
     * @param array $sections sections, each ['title' => ..., 'rows' => [['id' => ..., 'title' => ..., 'description' => ...]]]
     * @param array $header optional header object, e.g. ['type' => 'text', 'text' => 'Hello']
     * @param string|null $footer optional footer text
     * @return static
     */
    public static function list($body, $button, array $sections, array $header = [], $footer = null)
    {
        return static::create(static::build('list', $body, ['button' => $button, 'sections' => $sections], $header, $footer));
    }

    /**
     * @param string $type
     * @param string $body
     * @param array $action
     * @param array $header
     * @param string|null $footer
     * @return array
     */
    protected static function build($type, $body, array $action, array $header, $footer)
    {
        $data = ['type' => $type];

        if ($header) {
            $data['header'] = $header;
        }

        $data['body'] = ['text' => $body];

        if ($footer !== null) {
            $data['footer'] = ['text' => $footer];
        }

        $data['action'] = $action;

        return $data;
    }

    /**
     * button, list (outgoing) or button_reply, list_reply (incoming)
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return array
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * @return array
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * The tapped button: ['id' => ..., 'title' => ...]
     *
     * @return array
     */
    public function getButtonReply()
    {
        return $this->button_reply;
    }

    /**
     * The chosen row: ['id' => ..., 'title' => ..., 'description' => ...]
     *
     * @return array
     */
    public function getListReply()
    {
        return $this->list_reply;
    }

    /**
     * The id of the tapped button or chosen list row
     *
     * @return string|null
     */
    public function getReplyId()
    {
        return $this->button_reply['id'] ?? $this->list_reply['id'] ?? null;
    }

    /**
     * The title of the tapped button or chosen list row
     *
     * @return string|null
     */
    public function getReplyTitle()
    {
        return $this->button_reply['title'] ?? $this->list_reply['title'] ?? null;
    }
}
