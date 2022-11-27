<?php

namespace Fcm;

use Fcm\Exception\NotificationException;

interface Request
{
    /**
     * @return string
     */
    public function getUrl(): string;

    /**
     * You should not need to call this function. Instead pass the request object into {@link FcmClient::send()}.
     * @return array An associative array with the shape of a JSON request expected by the FCM API.
     * @throws NotificationException When this object isn't valid, so a request can't be built.
     */
    public function buildJsonBody(): array;
}
