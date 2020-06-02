<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/1/20
 * Time: 10:25 PM
 */

namespace Andre\Bionic\Plugins\Viber\Messages;


use Andre\Bionic\AbstractMessage;

abstract class ViberMessage extends AbstractMessage
{
    CONST TEXT = 'text';

    CONST PICTURE = 'picture';

    CONST VIDEO = 'video';

    CONST FILE = 'file';

    CONST CONTACT = 'contact';

    CONST LOCATION = 'location';

    CONST URL = 'url';

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
    protected abstract function setType();

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}