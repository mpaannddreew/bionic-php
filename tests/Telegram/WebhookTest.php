<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Tests\Telegram;

use Andre\Bionic\Plugins\Telegram\Chat;
use Andre\Bionic\Plugins\Telegram\Message;
use Andre\Bionic\Plugins\Telegram\Messages\Location;
use Andre\Bionic\Plugins\Telegram\PhotoSize;
use Andre\Bionic\Plugins\Telegram\TelegramPlugin;
use Andre\Bionic\Plugins\Telegram\User;
use Andre\Bionic\Tests\TestCase;

/**
 * Payloads in tests/fixtures/telegram are Update objects as described in the
 * Telegram Bot API reference (https://core.telegram.org/bots/api#update).
 */
class WebhookTest extends TestCase
{
    public function testTextMessage(): void
    {
        $bionic = $this->receive(TelegramPlugin::create(), $this->fixture('telegram/text.json'));

        $this->assertSame(['message', 'message.text'], $bionic->eventNames());

        [$plugin, $update_id, $message, $user, $chat, $text] = $bionic->argumentsOf('message.text');

        $this->assertInstanceOf(TelegramPlugin::class, $plugin);
        $this->assertSame(10000, $update_id);

        $this->assertInstanceOf(Message::class, $message);
        $this->assertSame(1365, $message->getMessageId());
        $this->assertSame('bot_command', $message->getEntities()[0]->getType());

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame(1111111, $user->getId());
        $this->assertSame('Test', $user->getFirstName());
        $this->assertSame('Testusername', $user->getUsername());
        $this->assertFalse($user->isBot());

        $this->assertInstanceOf(Chat::class, $chat);
        $this->assertSame('private', $chat->getType());

        $this->assertSame('/start', $text->getText());
    }

    public function testPhotoWithCaption(): void
    {
        $bionic = $this->receive(TelegramPlugin::create(), $this->fixture('telegram/photo.json'));

        $this->assertSame(['message', 'message.image'], $bionic->eventNames());

        $arguments = $bionic->argumentsOf('message.image');
        [$photos, $caption] = [$arguments[5], $arguments[6]];

        $this->assertCount(2, $photos);
        $this->assertInstanceOf(PhotoSize::class, $photos[1]);
        $this->assertSame('AgACAgQAAxkBAAIBZ2Large', $photos[1]->getFileId());
        $this->assertSame(800, $photos[1]->getWidth());
        $this->assertSame('Taj Mahal', $caption);
    }

    public function testEditedMessageLocation(): void
    {
        $bionic = $this->receive(TelegramPlugin::create(), $this->fixture('telegram/edited_location.json'));

        $this->assertSame(['edited-message', 'edited-message.location'], $bionic->eventNames());

        $location = $bionic->argumentsOf('edited-message.location')[5];

        $this->assertInstanceOf(Location::class, $location);
        $this->assertSame(27.175015, $location->getLatitude());
        $this->assertSame(78.042155, $location->getLongitude());
    }
}
