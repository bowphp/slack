<?php

namespace Bow\Slack\Attachment;

class SlackAttachmentField
{
    /**
     * The file title
     *
     * @var string
     */
    public $title;

    /**
     * The file value
     *
     * @var string
     */
    public $value;

    /**
     * Short
     *
     * @param boolean
     */
    public $short;

    /**
     * SlackAttachmentField Constructor
     *
     * @param string $title
     * @param string $value
     * @param string $short
     */
    public function __construct($title, $value, $short = null)
    {
        $this->title = $title;
        $this->value = $value;
        $this->short = $short;
    }

    /**
     * Set the Short
     *
     * @param boolean $short
     *
     * @return SlackAttachmentField
     */
    public function setShort($short)
    {
        $this->short = $short;

        return $this;
    }

    /**
     * Transform information
     *
     * @return array
     */
    public function toArray()
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
