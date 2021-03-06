<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 1:52 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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

    const SHARE = 'share';

    const STORY_MENTION = 'story_mention';

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
     * @return Payload|null
     */
    public function getPayload()
    {
        if ($this->payload)
            return Payload::create($this->payload);

        return null;
    }

    /**
     * set type
     */
    abstract protected function setType();

    /**
     * set payload
     *
     * @param AbstractMessage $payload
     * @return $this
     */
    public function setPayload(AbstractMessage $payload)
    {
        $this->payload = $payload->toArray();
        $this->data['payload'] = $this->getPayload()->toArray();
        return $this;
    }
}