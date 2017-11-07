<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 1:52 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\Plugins\Messenger\Messages\Payload\Payload;

abstract class AbstractAttachment extends AbstractMessage
{
    const IMAGE = 'image';

    const AUDIO = 'audio';

    const VIDEO = 'video';

    const LOCATION = 'location';

    const FILE = 'file';

    const FALLBACK = 'fallback';

    const TEMPLATE = 'template';

    /**
     * @var string $type
     */
    protected $type;

    /**
     * @var array $payload
     */
    protected $payload = [];

    /**
     * AbstractAttachment constructor.
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
     * get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * get payload
     *
     * @return Payload
     */
    public function getPayload()
    {
        return new Payload($this->payload);
    }

    /**
     * set type
     */
    abstract protected function setType();

    /**
     * set payload
     *
     * @param array $payload
     * @return $this
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
        $this->data['payload'] = $this->getPayload()->toArray();
        return $this;
    }
}