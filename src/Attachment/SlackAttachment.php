<?php

namespace Bow\Slack\Attachment;

class SlackAttachment
{
    // Required
    private $fallback = "";

    // Optionals
    private $color;
    private $pretext;
    private $author_name;
    private $author_icon;
    private $author_link;
    private $title;
    private $title_link;
    private $text;
    private $fields;
    private $markdown_in;
    private $image_url;
    private $thumb_url;

    // Footer
    private $footer;
    private $footer_icon;
    private $ts;

    // Actions
    private $actions;

    public public function __construct($fallback)
    {
        $this->fallback = $fallback;
    }

    /**
     * Accepted values: "good", "warning", "danger" or any hex color code
     *
     * @param string $color
     *
     * @return SlackAttachment
     */
    public public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Set the description
     *
     * @param string $text
     *
     * @return SlackAttachment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Optional text that appears above the attachment block
     *
     * @param string $pretext
     *
     * @return SlackAttachment
     */
    public function setPretext($pretext)
    {
        $this->pretext = $pretext;

        return $this;
    }

    /**
     * The author parameters will display a small section at the top of a message attachment.
     *
     * @param string $author_name [description]
     * @param optional string $author_link A valid URL that will hyperlink the author_name text mentioned above. Set to NULL to ignore this value.
     * @param optional string $author_icon A valid URL that displays a small 16x16px image to the left of the author_name text. Set to NULL to ignore this value.
     *
     * @return SlackAttachment
     */
    public function setAuthor($author_name, $author_link = null, $author_icon = null)
    {
        $this->setAuthorName($author_name);

        if (isset($author_link)) {
            $this->setAuthorLink($author_link);
        }

        if (isset($author_icon)) {
            $this->setAuthorIcon($author_icon);
        }

        return $this;
    }

    /**
     * Set the author name
     *
     * @param string $author_name
     */
    public function setAuthorName($author_name)
    {
        $this->author_name = $author_name;

        return $this;
    }

    /**
     * Enable text formatting for: "pretext", "text" or "fields".
     * Setting "fields" will enable markup formatting for the value of each field.
     *
     * @param string $markdown_in description
     *
     * @return SlackAttachment
     */
    public function enableMarkdownFor($markdown_in)
    {
        if (!isset($this->markdown_in_fields)) {
            $this->markdown_in_fields = (array) $markdown_in;

            return $this;
        }

        $this->markdown_in_fields[] = $markdown_in;

        return $this;
    }

    /**
     * A valid URL that displays a small 16x16px image to the left of the author_name text.
     *
     * @param string $author_icon
     *
     * @return SlackAttachment
     */
    public function setAuthorIcon($author_icon)
    {
        $this->author_icon = $author_icon;

        return $this;
    }

    /**
     * A valid URL that will hyperlink the author_name text mentioned above.
     *
     * @param string $author_link
     *
     * @return SlackAttachment
     */
    public function setAuthorLink($author_link)
    {
        $this->author_link = $author_link;

        return $this;
    }

    /**
     * The title is displayed as larger, bold text near the top of a message attachment.
     *
     * @param string $title
     * @param optional string $link By passing a valid URL in the link parameter (optional), the
     * title text will be hyperlinked.
     *
     * @return SlackAttachment
     */
    public function setTitle($title, $link = null)
    {
        $this->title = $title;

        if (isset($link)) {
            $this->title_link = $link;
        }

        return $this;
    }

    /**
     * A valid URL to an image file that will be displayed inside a message attachment. We currently
     *  support the following formats: GIF, JPEG, PNG, and BMP.
     *
     *  Large images will be resized to a maximum width of 400px or a maximum height of 500px, while
     *   still maintaining the original aspect ratio.
     *
     * @param string $url
     *
     * @return SlackAttachment
     */
    public function setImage($url)
    {
        $this->image_url = $url;

        return $this;
    }

    /**
     * A valid URL to an image file that will be displayed as a thumbnail on the right side of a
     * message attachment. We currently support the following formats: GIF, JPEG, PNG, and BMP.
     *
     * The thumbnail's longest dimension will be scaled down to 75px while maintaining the aspect
     * ratio of the image. The filesize of the image must also be less than 500 KB.
     *
     * For best results, please use images that are already 75px by 75px.
     *
     * @param string $url HTTP url of the thumbnail
     *
     * @return SlackAttachment
     */
    public function setThumbnail($url)
    {
        $this->thumb_url = $url;

        return $this;
    }

    /**
     * Add some brief text to help contextualize and identify an attachment. Limited to 300
     * characters, and may be truncated further when displayed to users in environments with limited
     *  screen real estate.
     *
     * @param string $text max 300 characters
     *
     * @return SlackAttachment
     */
    public function setFooterText($text)
    {
        $this->footer = $text;

        return $this;
    }

    /**
     * To render a small icon beside your footer text, provide a publicly accessible URL string in
     * the footer_icon field. You must also provide a footer for the field to be recognized.
     *
     * We'll render what you provide at 16px by 16px. It's best to use an image that is similarly
     * sized.
     *
     * @param string $url 16x16 image url
     *
     * @return SlackAttachment
     */
    public function setFooterIcon($url)
    {
        $this->footer_icon = $url;

        return $this;
    }

    /**
     * Does your attachment relate to something happening at a specific time?
     *
     * By providing the ts field with an integer value in "epoch time", the attachment will display
     * an additional timestamp value as part of the attachment's footer. Use ts when referencing
     * articles or happenings. Your message will have its own timestamp when published.
     *
     * Example: Providing 123456789 would result in a rendered timestamp of Nov 29th, 1973.
     * @param int $timestamp Integer value in "epoch time"
     *
     * @return SlackAttachment
     */
    public function setTimestamp($timestamp)
    {
        $this->ts = $timestamp;

        return $this;
    }

    /**
     * Add new attachment field
     *
     * @param SlackAttachmentField $field
     *
     * @return SlackAttachment
     */
    public function addFieldInstance(SlackAttachmentField $field)
    {
        if (!isset($this->fields)) {
            $this->fields = array($field);

            return $this;
        }

        $this->fields[] = $field;

        return $this;
    }

    /**
     * Shortcut without defining SlackAttachmentField
     *
     * @param SlackAttachment $paramname descriptionSlackAttachmentField
     *
     * @return SlackAttachment
     */
    public function addField($title, $value, $short = null)
    {
        return $this->addFieldInstance(
            new SlackAttachmentField($title, $value, $short)
        );
    }

    private public function addAction($action)
    {
        if (!isset($this->actions)) {
            $this->actions = array($action);
            return $this;
        }
        $this->actions[] = $action;
        return $this;
    }

    /**
     * @param string $text  A UTF-8 string label for this button. Be brief but descriptive and
     * actionable.
     * @param string $url   The fully qualified http or https URL to deliver users to. Invalid URLs
     * will result in a message posted with the button omitted
     * @param string $style  (optional) Setting to primary turns the button green and indicates the
     * best forward action to take. Providing danger turns the button red and indicates it some kind
     *  of destructive action. Use sparingly. Be default, buttons will use the UI's default text
     *  color.
     */
    public function addButton($text, $url, $style = null)
    {
        $action = (object) [
            "type" => "button",
            "text" => $text,
            "url" => $url,
        ];
        if (isset($style)) {
            $action->style = $style;
        }
        $this->addAction($action);
        return $this;
    }

    public function toArray()
    {
        $data = array(
            'fallback' => $this->fallback,
        );

        if (isset($this->color)) {
            $data['color'] = $this->color;
        }

        if (isset($this->pretext)) {
            $data['pretext'] = $this->pretext;
        }

        if (isset($this->author_name)) {
            $data['author_name'] = $this->author_name;
        }

        if (isset($this->markdown_in_fields)) {
            $data['markdown_in'] = $this->markdown_in_fields;
        }

        if (isset($this->author_link)) {
            $data['author_link'] = $this->author_link;
        }

        if (isset($this->author_icon)) {
            $data['author_icon'] = $this->author_icon;
        }

        if (isset($this->title)) {
            $data['title'] = $this->title;
        }

        if (isset($this->title_link)) {
            $data['title_link'] = $this->title_link;
        }

        if (isset($this->text)) {
            $data['text'] = $this->text;
        }

        if (isset($this->fields)) {
            $fields = array();

            foreach ($this->fields as $field) {
                $fields[] = $field->toArray();
            }

            $data['fields'] = $fields;
        }

        if (isset($this->image_url)) {
            $data['image_url'] = $this->image_url;
        }

        if (isset($this->thumb_url)) {
            $data['thumb_url'] = $this->thumb_url;
        }

        if (isset($this->footer)) {
            $data['footer'] = $this->footer;
        }

        if (isset($this->footer_icon)) {
            $data['footer_icon'] = $this->footer_icon;
        }

        if (isset($this->ts)) {
            $data['ts'] = $this->ts;
        }

        if (isset($this->actions)) {
            $data['actions'] = (array) $this->actions;
        }

        return $data;
    }
}
