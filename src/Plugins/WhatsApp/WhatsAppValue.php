<?php
/**
 * Created by PhpStorm.
 * User: mpande
 * Date: 5/2/20
 * Time: 10:34 PM
 */

namespace Andre\Bionic\Plugins\WhatsApp;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\Plugins\WhatsApp\Contacts\Contact;

class WhatsAppValue extends AbstractMessage
{
    /**
     * @var string $messaging_product
     */
    protected $messaging_product;

    /**
     * @var array $metadata
     */
    protected $metadata = [];

    /**
     * @var array $contacts
     */
    protected $contacts = [];

    /**
     * @var array $contact_objects
     */
    protected $contact_objects = [];

    /**
     * @var array $messages
     */
    protected $messages = [];

    /**
     * @var array $message_objects
     */
    protected $message_objects = [];

    /**
     * @var array $statuses
     */
    protected $statuses = [];

    /**
     * @var array $status_objects
     */
    protected $status_objects = [];

    /**
     * @var array $errors
     */
    protected $errors = [];

    /**
     * @var array $error_objects
     */
    protected $error_objects = [];

    public function __construct($data)
    {
        parent::__construct($data);
        $this->populateContacts();
        $this->populateMessages();
        $this->populateStatuses();
    }

    /**
     * populate contacts
     */
    protected function populateContacts() {
        foreach ($this->contacts as $contact) {
            array_push($this->contact_objects, Contact::create($contact));
        }
    }

    /**
     * populate messages
     */
    protected function populateMessages() {
        foreach ($this->messages as $message) {
            array_push($this->message_objects, Message::create($message));
        }
    }

    /**
     * populate statuses
     */
    protected function populateStatuses() {
        foreach ($this->statuses as $status) {
            array_push($this->status_objects, Status::create($status));
        }
    }

    /**
     * populate errors
     */
    protected function populateErrors() {
        foreach ($this->errors as $error) {
            array_push($this->error_objects, Error::create($error));
        }
    }

    /**
     * Get contacts
     *
     * @return array
     */
    public function getContacts() {
        return $this->contact_objects;
    }

    /**
     * Get messages
     *
     * @return array
     */
    public function getMessages() {
        return $this->message_objects;
    }

    /**
     * Get statuses
     *
     * @return array
     */
    public function getStatuses() {
        return $this->status_objects;
    }

    /**
     * Get errors
     *
     * @return array
     */
    public function getErrors() {
        return $this->error_objects;
    }
}