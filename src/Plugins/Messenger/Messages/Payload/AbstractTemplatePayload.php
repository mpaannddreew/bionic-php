<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 5:37 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Payload;


use Andre\Bionic\AbstractMessage;

abstract class AbstractTemplatePayload extends AbstractMessage
{
    const BUTTON = 'button';

    const LIST_ = 'list';

    const GENERIC = 'generic';

    /**
     * @var string $template_type
     */
    protected $template_type;

    /**
     * AbstractTemplatePayload constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        if(!$this->getTemplateType()){
            $this->setTemplateType();
            $this->data['template_type'] = $this->getTemplateType();
        }
    }

    /**
     * get template type
     *
     * @return string
     */
    public function getTemplateType()
    {
        return $this->template_type;
    }

    /**
     * set template type
     */
    abstract protected function setTemplateType();
}