<?php

namespace Fcm\Push;

use Fcm\Exception\NotificationException;
use Fcm\Request;

abstract class Push implements Request
{
    /**
     * @var array
     */
    protected $recipients = [];

    /**
     * @var array
     */
    protected $topics = [];

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param string|array $iidToken
     * @return self
     */
    public function addRecipient($iidToken): self
    {
        if (\is_string($iidToken)) {
            $this->recipients[] = $iidToken;
        } else if (\is_array($iidToken)) {
            $this->recipients = array_merge($this->recipients, array_values($iidToken));
        } else {
            throw new \InvalidArgumentException('iidToken must be a string or an array of strings');
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
     * @param $dataArray
     * @return self
     * @throws NotificationException
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
     * @return self
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
     * @inheritdoc
     */
    public function buildJsonBody(): array
    {
        if (empty($this->recipients) && empty($this->topics)) {
            throw new NotificationException('Must specify at least one recipient or topic.');
        }

        if (!empty($this->recipients) && !empty($this->topics)) {
            throw new NotificationException('Must not specify both a recipient and a topic.');
        }

        $request = [];

        if (!empty($this->recipients)) {
            if (\count($this->recipients) === 1) {
                $request['to'] = $this->recipients[0];
            } else {
                $request['registration_ids'] = $this->recipients;
            }
        }

        if (!empty($this->topics)) {
            $request['condition'] = implode('||', array_map(function (string $topic) {
                return sprintf("'%s' in topics", $topic);
            }, $this->topics));
        }

        if (!empty($this->data)) {
            $request['data'] = $this->data;
        }

        return $request;
    }
}
