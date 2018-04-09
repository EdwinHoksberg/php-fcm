<?php

namespace Fcm\Push;

trait Push
{
    /**
     * @var array
     */
    private $recipients = [];

    /**
     * @var array
     */
    private $topics = [];

    /**
     * @var array
     */
    private $data = [];

    /**
     * @param string|array $iidToken
     *
     * @return self
     */
    public function addRecipient($iidToken): self
    {
        if (\is_string($iidToken)) {
            $this->recipients[] = $iidToken;
        }

        if (\is_array($iidToken)) {
            $this->recipients = array_merge($this->recipients, $iidToken);
        }

        return $this;
    }

    /**
     * @param $topic
     *
     * @return self
     */
    public function addTopic($topic): self
    {
        if (\is_string($topic)) {
            $this->topics[] = $topic;
        }

        if (\is_array($topic)) {
            $this->topics = array_merge($this->topics, $topic);
        }

        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return Push
     */
    public function addData($name, $value): self
    {
        $this->data[$name] = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getUrl(): string
    {
        return 'https://fcm.googleapis.com/fcm/send';
    }
}
