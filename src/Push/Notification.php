<?php

namespace Fcm\Push;

class Notification extends Push
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $sound;

    /**
     * @var string
     */
    private $icon;

    /**
     * @var string
     */
    private $color;

    /**
     * @var string
     */
    private $tag;

    /**
     * @var string
     */
    private $subtitle;

    /**
     * @var int
     */
    private $badge;

    /**
     * @var string
     */
    private $click_action;

    /**
     * @var string|null
     */
    private $image_url;
    
    
    /**
     * @var string
     */
    private $android_channel_id;

    /**
     * @param string $title
     * @param string $body
     * @param string $recipient
     */
    public function __construct(string $title = '', string $body = '', string $recipient = '', string $sound = '', string $icon = '', string $color = '', int $badge = 0, string $tag = '', string $subtitle = '', array $data = [], string $click_action = '', string $image_url = null , string $android_channel_id = "")
    {
        $this->title = $title;
        $this->body = $body;
        $this->sound = $sound;
        $this->color = $color;
        $this->icon = $icon;
        $this->badge = $badge;
        $this->tag = $tag;
        $this->subtitle = $subtitle;
        $this->image_url = $image_url;

        if (!empty($click_action)) {
            $this->click_action = $click_action;
        }

        $this->android_channel_id = $android_channel_id;
        

        if (!empty($data)) {
            $this->data = $data;
        }

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
     * @param string $sound
     *
     * @return $this
     */
    public function setSound(string $sound): self
    {
        $this->sound = $sound;

        return $this;
    }

    /**
     * @param string $icon
     *
     * @return $this
     */
    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @param string $color
     *
     * @return $this
     */
    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @param int $badge
     *
     * @return $this
     */
    public function setBadge(int $badge): self
    {
        $this->badge = $badge;

        return $this;
    }

    /**
     * @param string $tag
     *
     * @return $this
     */
    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @param string $subtitle
     *
     * @return $this
     */
    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * @param string $click_action
     *
     * @return $this
     */
    public function setClickAction(string $click_action): self
    {
        $this->click_action = $click_action;

        return $this;
    }

     /**
     * @param string $android_channel_id
     *
     * @return $this
     */
    public function setAndroidChannelID(string $android_channel_id): self
    {
        $this->android_channel_id = $android_channel_id;

        return $this;
    }
    
    /**
     * @inheritdoc
     */
    public function buildJsonBody(): array
    {
        $request = parent::buildJsonBody();

        $request['notification']['title'] = $this->title;
        $request['notification']['body'] = $this->body;
        $request['notification']['sound'] = $this->sound;
        $request['notification']['icon'] = $this->icon;
        $request['notification']['color'] = $this->color;
        $request['notification']['tag'] = $this->tag;
        $request['notification']['subtitle'] = $this->subtitle;
        if ($this->badge > 0) {
            $request['notification']['badge'] = $this->badge;
        }
        if($this->android_channel_id != "")
            $request['notification']['android_channel_id'] = $this->android_channel_id;

        if (!empty($this->click_action)) {
            $request['notification']['click_action'] = $this->click_action;
        }

        if ($this->image_url) {
            $request['notification']['image'] = $this->image_url;
        }
        if (!empty($this->data)) {
            $request['data'] = $this->data;
        }
        return $request;
    }

    /**
     * @return string|null
     */
    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    /**
     * @param string|null $image_url
     */
    public function setImageUrl(?string $image_url): void
    {
        $this->image_url = $image_url;
    }
}
