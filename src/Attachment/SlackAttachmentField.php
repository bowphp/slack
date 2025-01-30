<?php

namespace Bow\Slack\Attachment;

class SlackAttachmentField
{
    /**
     * The file title
     *
     * @var string
     */
    public string $title;

    /**
     * The file value
     *
     * @var string
     */
    public string $value;

    /**
     * Short
     *
     * @var bool
     */
    public ?bool $short = null;

    /**
     * SlackAttachmentField Constructor
     *
     * @param string $title
     * @param string $value
     * @param string|null $short
     */
    public function __construct(string $title, string $value, ?string $short = null)
    {
        $this->title = $title;
        $this->value = $value;
        $this->short = $short;
    }

    /**
     * Set the Short
     *
     * @param bool $short
     * @return SlackAttachmentField
     */
    public function setShort(bool $short): SlackAttachmentField
    {
        $this->short = $short;

        return $this;
    }

    /**
     * Transform information
     *
     * @return array
     */
    public function toArray(): array
    {
        $data = [
            'title' => $this->title,
            'value' => $this->value,
        ];

        if ($this->short) {
            $data['short'] = $this->short;
        }

        return $data;
    }
}
