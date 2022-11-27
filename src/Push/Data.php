<?php

namespace Fcm\Push;

use Fcm\Exception\NotificationException;

class Data extends Push
{
    /**
     * @param array $data
     * @param string $recipient
     */
    public function __construct(array $data = [], string $recipient = '')
    {
        if (!empty($data)) {
            $this->data = $data;
        }

        if (!empty($recipient)) {
            $this->addRecipient($recipient);
        }
    }

    /**
     * @inheritdoc
     */
    public function buildJsonBody(): array
    {
        if (empty($this->data)) {
            throw new NotificationException('Data should not be empty for a Data Notification.');
        }

        return parent::buildJsonBody();
    }
}
