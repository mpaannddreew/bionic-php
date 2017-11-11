<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-04
 * Time: 10:32 PM
 *
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
    const WEB_URL = 'web_url';

    const POST_BACK = 'postback';

    const ELEMENT_SHARE = 'element_share';

    const PHONE_NUMBER = 'phone_number';

    const ACCOUNT_LINK = 'account_link';

    const ACCOUNT_UNLINK = 'account_unlink';

    const PAYMENT = 'payment';

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
        if(!$this->getType())
        {
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