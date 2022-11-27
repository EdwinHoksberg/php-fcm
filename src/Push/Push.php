<?php

namespace Fcm\Push;

use Fcm\Exception\NotificationException;


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
    public function addDataArray($dataArray): self
    {
        if (is_array($dataArray)) {
            $this->data = array_merge($this->data, $dataArray);
        } else {
            throw new NotificationException('Data must be an asscoiative array of ("key" => "value") pairs.');
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

    /**
     * @return array JSON body with only the fields of the Push trait.
     * @throws NotificationException When this object isn't valid.
     */
    protected function buildJsonPushBody(): array
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

        return $request;
    }
}
