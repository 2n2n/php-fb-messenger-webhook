<?php

namespace FBMessenger\MessageTag;

use GuzzleHttp\Client;
use FBMessenger\Interfaces\Me\Messages\MessagePayload;
use FBMessenger\Utils\SenderAction\SenderAction;

class MessageTag implements MessagePayload
{
    protected $_recipient = null;
    protected $_messaging_type = 'MESSAGE_TAG';
    protected $_tag = 'POST_PURCHASE_UPDATE';

    public $_url = 'https://graph.facebook.com/v5.0/me/messages';

    public function __construct($recipient_id)
    {
        $action = new SenderAction($recipient_id);
        $action->send();

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
                'text' => 'stop',
            ],
            'tag' => $this->_tag,
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
