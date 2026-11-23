<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Tests\Messenger;

use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;
use Andre\Bionic\Plugins\Messenger\Messages\Message;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Image;
use Andre\Bionic\Plugins\Messenger\MessengerPlugin;
use Andre\Bionic\Tests\TestCase;

/**
 * Payloads in tests/fixtures/messenger follow Meta's messages webhook
 * reference for the Messenger Platform, with sample IDs in place of
 * the documented <PSID> and <PAGE_ID> placeholders.
 */
class WebhookTest extends TestCase
{
    public function testTextMessage(): void
    {
        $bionic = $this->receive(MessengerPlugin::create(), $this->fixture('messenger/text.json'));

        $this->assertSame([
            'page.entry',
            'page.entry.item',
            'page.messaging',
            'page.messaging.item',
            'page.message',
            'page.message.text',
        ], $bionic->eventNames());

        [$plugin, $sender, $recipient, $message, $text] = $bionic->argumentsOf('page.message.text');

        $this->assertInstanceOf(MessengerPlugin::class, $plugin);
        $this->assertInstanceOf(Sender::class, $sender);
        $this->assertSame('6857923157603271', $sender->getId());
        $this->assertInstanceOf(Recipient::class, $recipient);
        $this->assertSame('682498302938465', $recipient->getId());

        $this->assertInstanceOf(Message::class, $message);
        $this->assertSame('m_3vs1PbM0wAAmBNWDl2hWzDDRNQ', $message->getMid());
        $this->assertSame('find flights from SFO to LAX next Thursday', $text->getText());
    }

    public function testImageAttachment(): void
    {
        $bionic = $this->receive(MessengerPlugin::create(), $this->fixture('messenger/image.json'));

        $this->assertContains('page.message.attachments', $bionic->eventNames());
        $this->assertContains('page.message.attachments.image', $bionic->eventNames());
        $this->assertNotContains('page.message.text', $bionic->eventNames());

        $image = $bionic->argumentsOf('page.message.attachments.image')[4];

        $this->assertInstanceOf(Image::class, $image);
        $this->assertSame('https://scontent.xx.fbcdn.net/v/t1.15752-9/image.png', $image->getPayload()->getUrl());
    }

    public function testUnknownAttachmentTypesAreSkipped(): void
    {
        $payload = $this->fixture('messenger/image.json');
        $payload['entry'][0]['messaging'][0]['message']['attachments'] = [
            ['type' => 'appointment_booking', 'payload' => ['booking_id' => '123']],
            ['type' => 'image', 'payload' => ['url' => 'https://example.com/a.png']],
        ];

        $bionic = $this->receive(MessengerPlugin::create(), $payload);

        $attachments = $bionic->argumentsOf('page.message.attachments')[4];

        $this->assertCount(1, $attachments);
        $this->assertInstanceOf(Image::class, $attachments[0]);
    }
}
