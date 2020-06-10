<?php

namespace FBMessenger\QuickReply;

use GuzzleHttp\Client;
use FBMessenger\Interfaces\Me\Messages\MessagePayload;

class QuickRreply implements MessagePayload
{
    protected $_recipient = null;
    protected $_messaging_type = 'RESPONSE';
    public $_url = 'https://graph.facebook.com/v5.0/me/messages';

    public function __construct($recipient_id)
    {
        $this->_recipient = $recipient_id;
    }

    public function parseBody()
    {
        return [
            'recipient' => [
                'id' => $this->_recipient,
            ],
            'messaging_type' => $this->_messaging_type,
            'message' => [
                'text' => 'pick a color',
                'quick_replies' => [
                    [
                        'content_type' => 'text',
                        'title' => 'Red',
                        'payload' => '<POSTBACK_PAYLOAD>',
                        'image_url' => 'http://example.com/img/red.png',
                    ], [
                        'content_type' => 'text',
                        'title' => 'Green',
                        'payload' => '<POSTBACK_PAYLOAD>',
                        'image_url' => 'http://example.com/img/green.png',
                    ],
                ],
            ],
        ];
    }

    public function send()
    {
        $client = new Client();
        $result = $client->post($this->_url, [
            'query' => [
                'access_token' => env('FBPAGE_ACCESS_TOKEN'),
            ],
            'form_params' => $this->parseBody(),
        ]);
    }
}
