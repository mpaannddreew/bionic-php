<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-04
 * Time: 10:32 PM
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
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}