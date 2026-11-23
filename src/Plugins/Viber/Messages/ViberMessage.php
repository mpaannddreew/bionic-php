<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Viber\Messages;

use Andre\Bionic\AbstractMessage;

abstract class ViberMessage extends AbstractMessage
{
    public const TEXT = 'text';

    public const PICTURE = 'picture';

    public const VIDEO = 'video';

    public const FILE = 'file';

    public const CONTACT = 'contact';

    public const LOCATION = 'location';

    public const URL = 'url';

    /**
     * @var string $type
     */
    protected $type;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->setType();
        if ($this->getType()) {
            $this->data['type'] = $this->getType();
        }
    }

    /**
     * set message type
     * @return void
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
