<?php

\BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter::webSocket(
    '/iam',
    \NextDeveloper\IAM\WebSockets\Handlers\IamHandler::class
);