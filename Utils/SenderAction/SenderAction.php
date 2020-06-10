<?php

namespace FBMessenger\Utils\SenderAction;

use GuzzleHttp\Client;
use FBMessenger\Interfaces\Me\Messages\MessagePayload;

class SenderAction implements MessagePayload
{
    protected $_recipient = null;

    public $_url = 'https://graph.facebook.com/v2.6/me/messages';

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
            'sender_action' => 'mark_seen',
        ];
    }

    public function send()
    {
        $client = new Client();
        $client->post($this->_url, [
            'query' => [
                'access_token' => env('FBPAGE_ACCESS_TOKEN'),
            ],
            'form_params' => $this->parseBody(),
        ]);
    }
}
