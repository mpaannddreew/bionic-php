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

class WhatsAppPlugin extends AbstractBionicPlugin
{
    /**
     * @var WhatsAppWebHookEvent $webHookEvent
     */
    protected $webHookEvent;

    /**
     * @var string $access_token
     */
    protected $access_token;

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
                                $this->bionic->emit('change.value', [$this, $change, $value]);

                                if ($messages = $value->getMessages()) {
                                    $contacts = $value->getContacts();
                                    $this->bionic->emit('messages', [$this, $contacts, $messages]);

                                    foreach ($messages as $message) {
                                        $this->bionic->emit('message', [$this, $contacts, $message]);

                                        if ($text = $message->getText())
                                            $this->bionic->emit('message.text', [$this, $contacts, $text]);

                                        if ($location = $message->getLocation())
                                            $this->bionic->emit('message.location', [$this, $contacts, $location]);

                                        if ($sent_contacts = $message->getContacts())
                                            $this->bionic->emit('message.contacts', [$this, $contacts, $sent_contacts]);

                                        if ($errors = $message->getErrors())
                                            $this->bionic->emit('message.errors', [$this, $errors]);

                                        if ($image = $message->getImage())
                                            $this->bionic->emit('message.image', [$this, $image]);

                                        if ($document = $message->getDocument())
                                            $this->bionic->emit('message.document', [$this, $document]);

                                        if ($voice = $message->getVoice())
                                            $this->bionic->emit('message.voice', [$this, $voice]);

                                        if ($sticker = $message->getSticker())
                                            $this->bionic->emit('message.sticker', [$this, $sticker]);

                                        if ($system = $message->getSystem())
                                            $this->bionic->emit('message.system', [$this, $system]);
                                    }
                                }

                                if ($statuses = $value->getStatuses()) {
                                    $this->bionic->emit('statuses', [$this, $statuses]);

                                    foreach ($statuses as $status) {
                                        $this->bionic->emit('status', [$this, $status]);
                                    }
                                }

                                if ($errors = $value->getErrors()) {
                                    $this->bionic->emit('errors', [$this, $errors]);

                                    foreach ($errors as $error) {
                                        $this->bionic->emit('error', [$this, $error]);
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
}