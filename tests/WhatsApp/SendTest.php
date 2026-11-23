<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Tests\WhatsApp;

use Andre\Bionic\Plugins\WhatsApp\Messages\Image;
use Andre\Bionic\Plugins\WhatsApp\Messages\Interactive;
use Andre\Bionic\Plugins\WhatsApp\Messages\Template;
use Andre\Bionic\Plugins\WhatsApp\Messages\Text;
use Andre\Bionic\Plugins\WhatsApp\WhatsAppPlugin;
use Andre\Bionic\Plugins\WhatsApp\WhatsAppValue;
use Andre\Bionic\Tests\TestCase;
use GuzzleHttp\Psr7\Response;

/**
 * Request shapes follow Meta's Cloud API reference (POST /<PHONE_NUMBER_ID>/messages,
 * GET /<MEDIA_ID>). Responses are the documented success responses.
 */
class SendTest extends TestCase
{
    private const MESSAGES_URL = 'https://graph.facebook.com/v27.0/106540352242922/messages';

    private WhatsAppPlugin $plugin;

    protected function setUp(): void
    {
        $this->plugin = WhatsAppPlugin::create([
            'phone_number_id' => '106540352242922',
            'access_token' => 'test-token',
        ]);
    }

    private function sentResponse(): Response
    {
        return new Response(200, ['Content-Type' => 'application/json'], json_encode([
            'messaging_product' => 'whatsapp',
            'contacts' => [['input' => '+16505551234', 'wa_id' => '16505551234']],
            'messages' => [['id' => 'wamid.HBgLMTY0NjcwNDM1OTUVAgARGBI1RjQyNUE3NEYxMzAzMzQ5MkEA']],
        ]));
    }

    private function assertMessagesRequest(array $expectedBody): void
    {
        $request = $this->lastRequest();

        $this->assertSame('POST', $request->getMethod());
        $this->assertSame(self::MESSAGES_URL, (string) $request->getUri());
        $this->assertSame('Bearer test-token', $request->getHeaderLine('Authorization'));
        $this->assertSame('application/json', $request->getHeaderLine('Content-Type'));
        $this->assertSame($expectedBody, $this->lastRequestJson());
    }

    public function testSendText(): void
    {
        $this->mockHttp($this->plugin, $this->sentResponse());

        $value = $this->plugin->sendMessage('text', Text::create([
            'preview_url' => false,
            'body' => 'Hello from Bionic',
        ]), '+16505551234');

        $this->assertMessagesRequest([
            'type' => 'text',
            'to' => '+16505551234',
            'text' => ['preview_url' => false, 'body' => 'Hello from Bionic'],
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
        ]);

        $this->assertInstanceOf(WhatsAppValue::class, $value);
        $this->assertSame('whatsapp', $value->getMessagingProduct());
        $this->assertSame('wamid.HBgLMTY0NjcwNDM1OTUVAgARGBI1RjQyNUE3NEYxMzAzMzQ5MkEA', $value->getMessages()[0]->getId());
        $this->assertSame('16505551234', $value->getContacts()[0]->getWaId());
    }

    public function testSendImageByLink(): void
    {
        $this->mockHttp($this->plugin, $this->sentResponse());

        $this->plugin->sendMessage('image', Image::create([
            'link' => 'https://example.com/taj-mahal.jpg',
            'caption' => 'Taj Mahal',
        ]), '+16505551234');

        $this->assertMessagesRequest([
            'type' => 'image',
            'to' => '+16505551234',
            'image' => ['link' => 'https://example.com/taj-mahal.jpg', 'caption' => 'Taj Mahal'],
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
        ]);
    }

    public function testSendTemplate(): void
    {
        $this->mockHttp($this->plugin, $this->sentResponse());

        $template = Template::named('order_confirmation', 'en_US', [
            [
                'type' => 'body',
                'parameters' => [
                    ['type' => 'text', 'parameter_name' => 'first_name', 'text' => 'Jessica'],
                    ['type' => 'text', 'parameter_name' => 'order_number', 'text' => 'SKBUP2-4CPIG9'],
                ],
            ],
        ]);

        $this->plugin->sendMessage('template', $template, '+16505551234');

        $this->assertMessagesRequest([
            'type' => 'template',
            'to' => '+16505551234',
            'template' => [
                'name' => 'order_confirmation',
                'language' => ['code' => 'en_US'],
                'components' => [
                    [
                        'type' => 'body',
                        'parameters' => [
                            ['type' => 'text', 'parameter_name' => 'first_name', 'text' => 'Jessica'],
                            ['type' => 'text', 'parameter_name' => 'order_number', 'text' => 'SKBUP2-4CPIG9'],
                        ],
                    ],
                ],
            ],
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
        ]);

        $this->assertSame('order_confirmation', $template->getName());
        $this->assertSame(['code' => 'en_US'], $template->getLanguage());
    }

    public function testTemplateWithoutComponentsOmitsThem(): void
    {
        $this->assertSame(
            ['name' => 'hello_world', 'language' => ['code' => 'en_US']],
            Template::named('hello_world', 'en_US')->toArray()
        );
    }

    public function testSendInteractiveReplyButtons(): void
    {
        $this->mockHttp($this->plugin, $this->sentResponse());

        $interactive = Interactive::buttons(
            'Your workshop is at 9am tomorrow. Need to reschedule?',
            ['change-button' => 'Change', 'cancel-button' => 'Cancel'],
            ['type' => 'image', 'image' => ['id' => '2762702990552401']],
            'Lucky Shrub'
        );

        $this->plugin->sendMessage('interactive', $interactive, '+16505551234');

        $this->assertMessagesRequest([
            'type' => 'interactive',
            'to' => '+16505551234',
            'interactive' => [
                'type' => 'button',
                'header' => ['type' => 'image', 'image' => ['id' => '2762702990552401']],
                'body' => ['text' => 'Your workshop is at 9am tomorrow. Need to reschedule?'],
                'footer' => ['text' => 'Lucky Shrub'],
                'action' => [
                    'buttons' => [
                        ['type' => 'reply', 'reply' => ['id' => 'change-button', 'title' => 'Change']],
                        ['type' => 'reply', 'reply' => ['id' => 'cancel-button', 'title' => 'Cancel']],
                    ],
                ],
            ],
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
        ]);
    }

    public function testSendInteractiveList(): void
    {
        $this->mockHttp($this->plugin, $this->sentResponse());

        $sections = [
            [
                'title' => 'I want it ASAP!',
                'rows' => [
                    ['id' => 'priority_express', 'title' => 'Priority Mail Express', 'description' => 'Next Day to 2 Days'],
                    ['id' => 'priority_mail', 'title' => 'Priority Mail', 'description' => '1-3 Days'],
                ],
            ],
        ];

        $this->plugin->sendMessage(
            'interactive',
            Interactive::list('Which shipping option do you prefer?', 'Shipping Options', $sections),
            '+16505551234'
        );

        $this->assertMessagesRequest([
            'type' => 'interactive',
            'to' => '+16505551234',
            'interactive' => [
                'type' => 'list',
                'body' => ['text' => 'Which shipping option do you prefer?'],
                'action' => ['button' => 'Shipping Options', 'sections' => $sections],
            ],
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
        ]);
    }

    public function testMarkRead(): void
    {
        $this->mockHttp($this->plugin, new Response(200, [], '{"success":true}'));

        $response = $this->plugin->markRead('wamid.HBgLMTY1MDM4Nzk0MzkVAgARGBJDQjZCMzlEQUE4OTJBMTE4RTUA');

        $this->assertMessagesRequest([
            'messaging_product' => 'whatsapp',
            'status' => 'read',
            'message_id' => 'wamid.HBgLMTY1MDM4Nzk0MzkVAgARGBJDQjZCMzlEQUE4OTJBMTE4RTUA',
        ]);
        $this->assertSame(['success' => true], json_decode((string) $response->getBody(), true));
    }

    public function testRetrieveMedia(): void
    {
        $media = [
            'messaging_product' => 'whatsapp',
            'url' => 'https://lookaside.fbsbx.com/whatsapp_business/attachments/?mid=1003383421387256',
            'mime_type' => 'image/jpeg',
            'sha256' => 'SfInY0gGKTsJlUWbwxC1k+FAD0FZHvzwfpvO0zX0GUI=',
            'file_size' => '303833',
            'id' => '1003383421387256',
        ];
        $this->mockHttp($this->plugin, new Response(200, [], json_encode($media)));

        $this->assertSame($media, $this->plugin->retrieveMedia('1003383421387256'));

        $request = $this->lastRequest();
        $this->assertSame('GET', $request->getMethod());
        $this->assertSame('https://graph.facebook.com/v27.0/1003383421387256', (string) $request->getUri());
        $this->assertSame('Bearer test-token', $request->getHeaderLine('Authorization'));
    }

    public function testRetrieveMediaForPhoneNumber(): void
    {
        $this->mockHttp($this->plugin, new Response(200, [], '{"id":"1003383421387256"}'));

        $this->plugin->retrieveMedia('1003383421387256', '106540352242922');

        $this->assertSame(
            'https://graph.facebook.com/v27.0/1003383421387256?phone_number_id=106540352242922',
            (string) $this->lastRequest()->getUri()
        );
    }

    public function testRetrieveMediaUrlStillReturnsTheResponse(): void
    {
        $this->mockHttp($this->plugin, new Response(200, [], '{"url":"https://lookaside.fbsbx.com/x"}'));

        $response = $this->plugin->retrieveMediaURL('1003383421387256');

        $this->assertSame('https://lookaside.fbsbx.com/x', json_decode((string) $response->getBody(), true)['url']);
        $this->assertSame('https://graph.facebook.com/v27.0/1003383421387256', (string) $this->lastRequest()->getUri());
    }

    public function testDownloadMedia(): void
    {
        $this->mockHttp($this->plugin, new Response(200, ['Content-Type' => 'image/jpeg'], 'JPEG-BYTES'));

        $url = 'https://lookaside.fbsbx.com/whatsapp_business/attachments/?mid=1003383421387256&ext=1';

        $this->assertSame('JPEG-BYTES', $this->plugin->downloadMedia($url));

        $request = $this->lastRequest();
        $this->assertSame('GET', $request->getMethod());
        $this->assertSame($url, (string) $request->getUri());
        $this->assertSame('Bearer test-token', $request->getHeaderLine('Authorization'));
    }

    public function testDownloadMediaToSink(): void
    {
        $this->mockHttp($this->plugin, new Response(200, [], 'JPEG-BYTES'));

        $sink = fopen('php://temp', 'w+');

        $this->assertSame('', $this->plugin->downloadMedia('https://lookaside.fbsbx.com/x', $sink));

        rewind($sink);
        $this->assertSame('JPEG-BYTES', stream_get_contents($sink));
        fclose($sink);
    }

    public function testGraphApiVersionIsConfigurable(): void
    {
        $plugin = WhatsAppPlugin::create([
            'phone_number_id' => '106540352242922',
            'access_token' => 'test-token',
            'graph_api_version' => 'v23.0',
        ]);
        $this->mockHttp($plugin, $this->sentResponse(), $this->sentResponse());

        $plugin->sendMessage('text', Text::create(['body' => 'Hi']), '+16505551234');
        $this->assertSame('https://graph.facebook.com/v23.0/106540352242922/messages', (string) $this->lastRequest()->getUri());

        $plugin->setGraphApiVersion('v25.0');
        $plugin->sendMessage('text', Text::create(['body' => 'Hi']), '+16505551234');
        $this->assertSame('https://graph.facebook.com/v25.0/106540352242922/messages', (string) $this->lastRequest()->getUri());
    }

    public function testSendingWithoutCredentialsThrows(): void
    {
        $plugin = WhatsAppPlugin::create(['phone_number_id' => '106540352242922']);
        $this->mockHttp($plugin);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('An access token has not been specified!');

        $plugin->sendMessage('text', Text::create(['body' => 'Hi']), '+16505551234');
    }
}
