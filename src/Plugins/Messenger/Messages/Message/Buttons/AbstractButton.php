<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons;

use Andre\Bionic\AbstractMessage;

abstract class AbstractButton extends AbstractMessage
{
    public const WEB_URL = 'web_url';

    public const POST_BACK = 'postback';

    public const ELEMENT_SHARE = 'element_share';

    public const PHONE_NUMBER = 'phone_number';

    public const ACCOUNT_LINK = 'account_link';

    public const ACCOUNT_UNLINK = 'account_unlink';

    public const PAYMENT = 'payment';

    /**
     * @var string $type
     */
    protected $type;

    /**
     * AbstractButton constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        if (!$this->getType()) {
            $this->setType();
            $this->data['type'] = $this->getType();
        }
    }

    /**
     * set button type
     */
    abstract protected function setType();

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
