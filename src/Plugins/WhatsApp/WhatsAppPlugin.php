<?php
/**
 * Created by PhpStorm.
 * User: mpande
 * Date: 5/2/20
 * Time: 10:32 PM
 */

namespace Andre\Bionic\Plugins\WhatsApp;


use Andre\Bionic\AbstractBionic;
use Andre\Bionic\Plugins\AbstractBionicPlugin;
use Andre\Bionic\Plugins\Messenger\Messages\Change;
use Andre\Bionic\Plugins\Messenger\Messages\EntryItem;
use Andre\Bionic\Plugins\WhatsApp\Traits\HandlesMedia;
use Andre\Bionic\Plugins\WhatsApp\Traits\SendsMessages;
use GuzzleHttp\Client as HttpClient;

class WhatsAppPlugin extends AbstractBionicPlugin
{
    use SendsMessages, HandlesMedia;

    /**
     * @var HttpClient $httpClient
     */
    protected $httpClient;

    /**
     * @var WhatsAppWebHookEvent $webHookEvent
     */
    protected $webHookEvent;

    /**
     * @var string $graph_api_version
     */
    protected $graph_api_version = 'v13.0';

    /**
     * @var string $phone_number_id
     */
    protected $phone_number_id;

    /**
     * @var string $access_token
     */
    protected $access_token;

    /**
     * @var string $url
     */
    protected $url = "https://graph.facebook.com";

    /**
     * create new whatsApp plugin instance
     *
     * MessengerPlugin constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->httpClient = $this->newHttpClient();
    }

    /**
     * Set phone number id
     *
     * @param string $phone_number_id
     */
    public function setPhoneNumberId($phone_number_id)
    {
        $this->phone_number_id = $phone_number_id;
    }

    /**
     * set new access token
     *
     * @param string $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * set new graph api version
     *
     * @param $graph_api_version
     */
    public function setGraphApiVersion($graph_api_version)
    {
        $this->graph_api_version = $graph_api_version;
    }

    /**
     * create a new web hook event from web hook data
     */
    protected function createWebHookEvent()
    {
        $this->webHookEvent = WhatsAppWebHookEvent::create($this->webHookData);
    }

    /**
     * emit events
     *
     * @param AbstractBionic $bionic
     */
    public function emitEvents(AbstractBionic $bionic)
    {
        $this->bionic = $bionic;
        $this->runPluginTasks();
        $this->iterateOverObjectsAndEmitEvents();
    }

    /**
     * create new http client
     *
     * @return HttpClient
     */
    protected function newHttpClient()
    {
        return new HttpClient([
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'verify' => false
        ]);
    }

    private function iterateOverObjectsAndEmitEvents()
    {
        /**
         * @var EntryItem $entryItem
         * @var Change $change
         * @var WhatsAppValue $value
         * @var Message $message
         */
        try {
            if ($entryItems = $this->webHookEvent->getEntryItems()) {
                $this->bionic->emit('entry', [$this, $entryItems]);

                foreach ($entryItems as $entryItem) {
                    $this->bionic->emit('entry.item', [$this, $entryItem]);

                    if ($changes = $entryItem->getChangesItems()) {
                        $this->bionic->emit('changes', [$this, $changes]);

                        foreach ($changes as $change) {
                            $this->bionic->emit('change', [$this, $change]);

                            if ($value = $change->getValue()) {
                                $meta = $value->getMetadata();
                                $contacts = $value->getContacts();
                                $this->bionic->emit('change.value', [$this, $change, $value]);

                                if ($messages = $value->getMessages()) {
                                    $this->bionic->emit('messages', [$this, $meta, $contacts, $messages]);

                                    foreach ($messages as $message) {
                                        $this->bionic->emit('message', [$this, $meta, $contacts, $message]);

                                        if ($text = $message->getText())
                                            $this->bionic->emit('message.text', [$this, $meta, $contacts, $message, $text]);

                                        if ($location = $message->getLocation())
                                            $this->bionic->emit('message.location', [$this, $meta, $contacts, $message, $location]);

                                        if ($sent_contacts = $message->getContacts())
                                            $this->bionic->emit('message.contacts', [$this, $meta, $contacts, $message, $sent_contacts]);

                                        if ($errors = $message->getErrors())
                                            $this->bionic->emit('message.errors', [$this, $meta, $contacts, $message, $errors]);

                                        if ($image = $message->getImage())
                                            $this->bionic->emit('message.image', [$this, $meta, $contacts, $message, $image]);

                                        if ($document = $message->getDocument())
                                            $this->bionic->emit('message.document', [$this, $meta, $contacts, $message, $document]);

                                        if ($voice = $message->getAudio())
                                            $this->bionic->emit('message.voice', [$this, $meta, $contacts, $message, $voice]);

                                        if ($sticker = $message->getSticker())
                                            $this->bionic->emit('message.sticker', [$this, $meta, $contacts, $message, $sticker]);

                                        if ($system = $message->getSystem())
                                            $this->bionic->emit('message.system', [$this, $meta, $contacts, $message, $system]);
                                    }
                                }

                                if ($statuses = $value->getStatuses()) {
                                    $this->bionic->emit('statuses', [$this, $meta, $statuses]);

                                    foreach ($statuses as $status) {
                                        $this->bionic->emit('status', [$this, $meta, $status]);
                                    }
                                }

                                if ($errors = $value->getErrors()) {
                                    $this->bionic->emit('errors', [$this, $meta, $errors]);

                                    foreach ($errors as $error) {
                                        $this->bionic->emit('error', [$this, $meta, $error]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } catch (\Exception $exception){
            $this->bionic->emit('exception', [$exception]);
        }
    }

    /**
     * check if access token has been provided before making any http request
     */
    protected function checkForAccessToken()
    {
        if (!$this->access_token)
            throw new \InvalidArgumentException('An access token has not been specified!');
    }

    /**
     * check if access token has been provided before making any http request
     */
    protected function checkForPhoneNumberId()
    {
        if (!$this->phone_number_id)
            throw new \InvalidArgumentException('A phone number id has not been specified!');
    }
}