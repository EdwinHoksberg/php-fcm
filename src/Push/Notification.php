<?php

namespace Fcm\Push;

use Fcm\Exception\NotificationException;
use Fcm\Request;

class Notification implements Request
{
    use Push;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $body;

    /**
     * @param string $title
     * @param string $body
     * @param string $recipient
     */
    public function __construct(string $title = '', string $body = '', string $recipient = '')
    {
        $this->title = $title;
        $this->body = $body;

        if (!empty($recipient)) {
            $this->addRecipient($recipient);
        }
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $body
     *
     * @return $this
     */
    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getBody(): array
    {
        if (empty($this->recipients) && empty($this->topics)) {
            throw new NotificationException('Must minimaly specify a single recipient or topic.');
        }

        if (!empty($this->recipients) && !empty($this->topics)) {
            throw new NotificationException('Must either specify a recipient or topic, not more then one.');
        }

        $request = [];

        if (!empty($this->recipients)) {
            if (\count($this->recipients) === 1) {
                $request['to'] = current($this->recipients);
            } else {
                $request['registration_ids'] = $this->recipients;
            }
        }

        if (!empty($this->topics)) {
            $request['condition'] = array_reduce($this->topics, function ($carry, string $topic) {
                $topicSyntax = "'%s' in topics";

                if (end($this->topics) === $topic) {
                    return $carry .= sprintf($topicSyntax, $topic);
                }

                return $carry .= sprintf($topicSyntax, $topic) . '||';
            });
        }

        if (!empty($this->data)) {
            $request['data'] = $this->data;
        }

        $request['notification']['title'] = $this->title;
        $request['notification']['body'] = $this->body;

        return $request;
    }
}
