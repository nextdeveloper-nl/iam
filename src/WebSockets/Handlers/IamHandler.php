<?php

namespace NextDeveloper\IAM\WebSockets\Handlers;

use NextDeveloper\IAM\WebSockets\BaseHandler;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;

class IamHandler extends BaseHandler
{
    public function onMessage(ConnectionInterface $conn, MessageInterface $msg)
    {
        // TODO: Implement onMessage() method.
        //dump($msg->getPayload());
    }
}