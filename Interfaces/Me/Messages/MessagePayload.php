<?php

namespace FBMessenger\Interfaces\Me\Messages;

interface MessagePayload
{
    public function parseBody();

    public function send();
}
