<?php
/**
 * Created by PhpStorm.
 * User: mpande
 * Date: 5/2/20
 * Time: 10:34 PM
 */

namespace Andre\Bionic\Plugins\WhatsApp;


use Andre\Bionic\AbstractWebHookEvent;
use Andre\Bionic\Plugins\WhatsApp\Contacts\Contact;

class WhatsAppWebHookEvent extends AbstractWebHookEvent
{
    protected $contacts = [];

    protected $contact_objects = [];

    protected $messages = [];

    protected $message_objects = [];

    protected $statuses = [];

    protected $status_objects = [];

    protected $errors = [];

    protected $error_objects = [];

    public function __construct($data)
    {
        parent::__construct($data);
        $this->populateContacts();
        $this->populateMessages();
        $this->populateStatuses();
    }

    protected function populateContacts() {
        foreach ($this->contacts as $contact) {
            array_push($this->contact_objects, Contact::create($contact));
        }
    }

    protected function populateMessages() {
        foreach ($this->messages as $message) {
            array_push($this->message_objects, Message::create($message));
        }
    }

    protected function populateStatuses() {
        foreach ($this->statuses as $status) {
            array_push($this->status_objects, Status::create($status));
        }
    }

    protected function populateErrors() {
        foreach ($this->errors as $error) {
            array_push($this->error_objects, Error::create($error));
        }
    }

    public function getContacts() {
        return $this->contact_objects;
    }

    public function getMessages() {
        return $this->message_objects;
    }

    public function getStatuses() {
        return $this->status_objects;
    }

    public function getErrors() {
        return $this->error_objects;
    }
}