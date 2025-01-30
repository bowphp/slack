<?php

namespace Bow\Slack\Tests;

use Bow\Slack\Attachment\SlackAttachment;
use Bow\Slack\Slack;
use Bow\Slack\SlackMessage;
use PHPUnit\Framework\TestCase;

class SlackTest extends TestCase
{
    private string $webhook_url;

    protected function setUp(): void
    {
        $this->webhook_url = getenv('SLACK_WEBHOOK_URL');
    }

    /**
     * @test
     */
    public function it_can_create_slack_instance()
    {
        $slack = new Slack($this->webhook_url);
        $this->assertInstanceOf(Slack::class, $slack);
    }

    /**
     * @test
     */
    public function it_can_set_webhook_url()
    {
        $slack = new Slack($this->webhook_url);
        $slack->setUrl('https://hooks.slack.com/services/NEW/URL/HERE');

        $this->assertInstanceOf(Slack::class, $slack);
    }

    /**
     * @test
     */
    public function it_can_send_simple_message()
    {
        $slack = new Slack($this->webhook_url);
        $message = new SlackMessage('Test message');

        $result = $slack->send($message);
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function it_can_send_message_with_attachments()
    {
        $slack = new Slack($this->webhook_url);
        $message = new SlackMessage('Test message with attachment');

        $attachment = new SlackAttachment('Fallback text');
        $attachment->setText('Attachment content')
            ->setColor('good')
            ->setTitle('Test Title')
            ->addField('Field 1', 'Value 1')
            ->addField('Field 2', 'Value 2');

        $message->addAttachment($attachment);

        $result = $slack->send($message);
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function it_can_send_formatted_message()
    {
        $slack = new Slack($this->webhook_url);
        $message = (new SlackMessage('Test formatted message'))
            ->assignTo('test-bot')
            ->on('#testing')
            ->withEmoji(':robot_face:')
            ->withUnfurlLinks(true);

        $result = $slack->send($message);
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function it_handles_invalid_webhook_url()
    {
        $slack = new Slack('https://hooks.slack.com/services/NEW/URL/HERE');
        $message = new SlackMessage('Test message');

        $result = $slack->send($message);
        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function it_can_send_message_with_custom_channel()
    {
        $slack = new Slack($this->webhook_url);
        $message = new SlackMessage('Test message');
        $message->on('#random');

        $result = $slack->send($message);
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function it_can_send_message_with_custom_username()
    {
        $slack = new Slack($this->webhook_url);
        $message = new SlackMessage('Test message');
        $message->assignTo('custom-bot');

        $result = $slack->send($message);
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function it_can_send_message_with_emoji()
    {
        $slack = new Slack($this->webhook_url);
        $message = new SlackMessage('Test message');
        $message->withEmoji(':tada:');

        $result = $slack->send($message);
        $this->assertTrue($result);
    }
}
