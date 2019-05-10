# Bow Slack Webhook

Easy to use PHP library to post messages in Slack using incoming webhook integrations.

# Setup

Log in at [slack.com](slack.com) with your team. Go to the page with all your integrations.
Add a new incoming webhook.

Confirm "Add Incoming WebHook integration"
Next, you will find your WebHook URL which you need to use this library. Save it somewhere secure.

When you scroll all the way down, you get more options to change your default username,
description and icon. You can overwrite these in your code.

# Usage

## Installation

### Composer

Install the package via [composer](https://getcomposer.org):

```
composer require bowphp/slack-webhook
```

Add `bowphp/slack-webhook` to your `composer.json` file:

```json
{
  "require": {
    "bowphp/slack-webhook": "~1.0"
  }
}
```

## Simple message

```php
use Bow\Slack\Slack;
use Bow\Slack\SlackMessage;

// Use the url you got earlier
$webhook = 'https://hooks.slack.com/services/XXXXXXXXX/XXXXXXXXX/XXXXXXXXXXXXXXXXXXXXXXXX';
$slack = new Slack($webhook);

// Create a new message
$message = new SlackMessage;
$message->content("Hello world!");

// Send it!
if ($slack->send($message)) {
    echo "Hurray 😄";
} else {
    echo "Failed 😢";
}
```

## Send to a channel

```php
// Use the url you got earlier
$slack = new Slack($webhook);

// Create a new message
$message = new SlackMessage;
$message->content("Hello world!")->on("#general");

// Send it!
$slack->send($message);
```

## Send to a user

```php
// Use the url you got earlier
$slack = new Slack($webhook);

// Create a new message
$message = new SlackMessage;
$message
  ->content("Hello world!")
  ->on("@simonbackx");

// Send it!
$slack->send($message);
```

## Overwriting defaults

You can overwrite the defaults on two levels: in a Slack instance (defaults for all messages using this Slack instance) or SlackMessage instances (only for the current message). These methods will not modify your root defaults at Slack.com, but will overwrite them temporary in your code.

```php
$slack = new Slack($webhook);
$message = new SlackMessage;

// Unfurl links: automatically fetch and create attachments for detected URLs
$message->withUnf(true);

// Set the default icon for messages to a custom image
$message->withIcom("http://www.domain.com/robot.png")

// Use a 👻 emoji as default icon for messages if it is not overwritten in messages
$message->withEmoji(":ghost:");

$message->content("Hello world!");

// Set the message channel
$message->on("#general");

// Send it!
$slack->send($message);
```

## Attachments

### Create an attachment

Check out https://api.slack.com/docs/attachments for more details

```php
use Bow\Slack\Attachment\SlackAttachment;
use Bow\Slack\SlackMessage;
use Bow\Slack\Slack;

// Use the url you got earlier
$slack = new Slack($webhook);

// Create a new message
$message = new SlackMessage;

$attachment = new SlackAttachment("Required plain-text summary of the attachment.");
$attachment->setColor("#36a64f");
$attachment->setText("*Optional text* that appears within the attachment");
$attachment->setPretext("Optional text that appears above the attachment block");
$attachment->setTitle("Title", "Optional link e.g. http://www.google.com/");
$attachment->setImage("http://www.domain.com/picture.jpg");
$attachment->setAuthor(
    "Author name",
    "http://flickr.com/bobby/", //Optional author link
    "http://flickr.com/bobby/picture.jpg" // Optional author icon
);

/**
 * Slack messages may be formatted using a simple markup language similar to Markdown. Supported
 * formatting includes: ```pre```, `code`, _italic_, *bold*, and even ~strike~.; full details are
 * available on the Slack help site.
 *
 * By default bot message text will be formatted, but attachments are not. To enable formatting on
 * attachment fields, you can use enableMarkdownFor
 */
$attachment->enableMarkdownFor("text");
$attachment->enableMarkdownFor("pretext");
$attachment->enableMarkdownFor("fields");

 // Add fields, last parameter stand for short (smaller field) and is optional
$attachment->addField("Title", "Value");
$attachment->addField("Title2", "Value2", true);
$attachment->addField("Title", "Value", false);

// Add a footer
$attachment->setFooterText('By Simon');
$attachment->setFooterIcon('https://www.simonbackx.com/favicon.png');
$attachment->setTimestamp(time());

// Add it to your message
$message->addAttachment($attachment);

// Send
$slack->send($message);
```

### Add buttons

```php
// Use the url you got earlier
$slack = new Slack('https://hooks.slack.com/services/XXXXXXXXX/XXXXXXXXX/XXXXXXXXXXXXXXXXXXXXXXXX');

// Create a new message
$message = new SlackMessage;
$message->content("<@W1A2BC3DD> approved your travel request. Book any airline you like by continuing below.");
$message->assignTo('Fly company');

// Create a new Attachment with fallback text, a plain-text summary of the attachment.
// This text will be used in clients that don't show formatted text (eg. IRC, mobile
// notifications) and should not contain any markup.
$attachment = new \SlackAttachment('Book your flights at https://flights.example.com/book/r123456');
$attachment->addButton('Book flights 🛫', 'https://flights.example.com/book/r123456');
$attachment->addButton('Unsubscribe', 'https://flights.example.com/unsubscribe', 'danger');

$message->addAttachment($attachment);

$slack->send($message);
```

### Add (multiple) attachments

```php
$message = new SlackMessage;

$message->addAttachment($attachment1);
$message->addAttachment($attachment2);

$slack->send($message);
```

### Short syntax

All methods support a short syntax. E.g.:

```php
$message = (new SlackMessage)
    ->addAttachment($attachment1)
    ->addAttachment($attachment2);

$slack->send($message);
```

# Warning

Each message initiates a new HTTPS request, which takes some time. Don't send too much messages at once if you are not running your script in a background task.
