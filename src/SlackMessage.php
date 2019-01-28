<?php

namespace Bow\Slack;

use Bow\Slack\Attachment\SlackAttachment;

class SlackMessage
{
    /**
     * The Message content
     *
     * @var string
     */
    private $text;

    /**
     * The username in Slack
     *
     * @var string
     */
    private $username;

    /**
     * The channel
     *
     * @var string
     */
    private $channel;

    /**
     * The icon url
     *
     * @var string
     */
    private $icon_url;

    /**
     * Default icon set in Slack instance
     *
     * @var string
     */
    private $icon_emoji;

    /**
     * The unfurl_links entry
     *
     * @var string
     */
    private $unfurl_links;

    /**
     * The SlackAttachment instances
     *
     * @var array
     */
    private $attachments;

    /**
     * SlackMessage constructor
     *
     * @param string $text
     */
    public function __construct($text = null, $channel = '#general')
    {
        $this->text = $text;

        $this->channel = $channel;
    }

    /**
     * Set the message
     *
     * @param strint $text
     */
    public function content($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Set user name
     *
     * @param string $username
     *
     * @return SlackMessage
     */
    public function assignTo($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set the channel
     *
     * @param string $channel
     *
     * @return SlackMessage
     */
    public function on($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Set the emoji
     *
     * @param string $emoji
     *
     * @return SlackMessage
     */
    public function withEmoji($emoji)
    {
        $this->icon_emoji = $emoji;

        return $this;
    }

    /**
     * Set icon
     *
     * @param string $url
     *
     * @return SlackMessage
     */
    public function withIcon($url)
    {
        $this->icon_url = $url;

        return $this;
    }

    /**
     * Set unfurl_links
     *
     * @param boolean $unfurl_links
     *
     * @return SlackMessage
     */
    public function withUnfurlLinks($unfurl_links)
    {
        $this->unfurl_links = $unfurl_links;

        return $this;
    }

    /**
     * Add Attachment
     *
     * @param SlackAttachment $attachment
     *
     * @return SlackMessage
     */
    public function addAttachment(SlackAttachment $attachment)
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
    public function toArray()
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
