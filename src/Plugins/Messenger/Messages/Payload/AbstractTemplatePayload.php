<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 5:37 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Payload;


use Andre\Bionic\AbstractMessage;

abstract class AbstractTemplatePayload extends AbstractMessage
{
    const BUTTON = 'button';

    const LIST_ = 'list';

    const GENERIC = 'generic';

    /**
     * @var $template_type
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
     * @return mixed
     */
    public function getTemplateType()
    {
        return $this->template_type;
    }

    /**
     * set template type
     */
    abstract public function setTemplateType();

}