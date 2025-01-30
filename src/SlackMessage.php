<?php

namespace Bow\Slack;

use Bow\Slack\Attachment\SlackAttachment;

class SlackMessage
{
    /**
     * The Message content
     *
     * @var ?string
     */
    private ?string $text = null;

    /**
     * The username in Slack
     *
     * @var ?string
     */
    private ?string $username = null;

    /**
     * The channel
     *
     * @var ?string
     */
    private ?string $channel = null;

    /**
     * The icon url
     *
     * @var ?string
     */
    private ?string $icon_url = null;

    /**
     * Default icon set in Slack instance
     *
     * @var ?string
     */
    private ?string $icon_emoji = null;

    /**
     * The unfurl_links entry
     *
     * @var ?bool
     */
    private ?bool $unfurl_links = null;

    /**
     * The SlackAttachment instances
     *
     * @var ?array
     */
    private ?array $attachments = null;

    /**
     * SlackMessage constructor
     *
     * @param string|null $text
     * @param string|null $channel
     */
    public function __construct(?string $text = null, ?string $channel = '#general')
    {
        $this->text = $text;
        $this->channel = $channel;
    }

    /**
     * Set the message
     *
     * @param string $text
     * @return SlackMessage
     */
    public function content(string $text): SlackMessage
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return SlackMessage
     */
    public function assignTo(string $username): SlackMessage
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set the channel
     *
     * @param string $channel
     * @return SlackMessage
     */
    public function on(string $channel): SlackMessage
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Set the emoji
     *
     * @param string $emoji
     * @return SlackMessage
     */
    public function withEmoji(string $emoji): SlackMessage
    {
        $this->icon_emoji = $emoji;

        return $this;
    }

    /**
     * Set icon
     *
     * @param string $url
     * @return SlackMessage
     */
    public function withIcon(string $url): SlackMessage
    {
        $this->icon_url = $url;

        return $this;
    }

    /**
     * Set unfurl_links
     *
     * @param boolean $unfurl_links
     * @return SlackMessage
     */
    public function withUnfurlLinks(bool $unfurl_links): SlackMessage
    {
        $this->unfurl_links = $unfurl_links;

        return $this;
    }

    /**
     * Add Attachment
     *
     * @param SlackAttachment $attachment
     * @return SlackMessage
     */
    public function addAttachment(SlackAttachment $attachment): SlackMessage
    {
        if (!isset($this->attachments)) {
            $this->attachments = array($attachment);

            return $this;
        }

        $this->attachments[] = $attachment;

        return $this;
    }

    /**
     * Transform data
     *
     * @return array
     */
    public function toArray(): array
    {
        $data = [
            'text' => $this->text,
        ];

        if (isset($this->username)) {
            $data['username'] = $this->username;
        }

        if (!is_null($this->channel)) {
            $data['channel'] = $this->channel;
        }

        if (!is_null($this->icon_url)) {
            $data['icon_url'] = $this->icon_url;
        }

        if (!is_null($this->icon_emoji)) {
            $data['icon_emoji'] = $this->icon_emoji;
        }

        if (!is_null($this->unfurl_links)) {
            $data['unfurl_links'] = $this->unfurl_links;
        }

        if (!is_null($this->attachments)) {
            $attachments = array();

            foreach ($this->attachments as $attachment) {
                $attachments[] = $attachment->toArray();
            }

            $data['attachments'] = $attachments;
        }

        return $data;
    }
}
