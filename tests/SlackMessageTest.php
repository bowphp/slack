<?php

namespace Bow\Slack\Tests;

use Bow\Slack\Attachment\SlackAttachment;
use Bow\Slack\SlackMessage;
use PHPUnit\Framework\TestCase;

class SlackMessageTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_create_message_with_text()
    {
        $message = new SlackMessage('Hello World');
        $data = $message->toArray();

        $this->assertEquals('Hello World', $data['text']);
        $this->assertEquals('#general', $data['channel']);
    }

    /**
     * @test
     */
    public function it_can_set_content()
    {
        $message = new SlackMessage();
        $message->content('Hello World');

        $data = $message->toArray();

        $this->assertEquals('Hello World', $data['text']);
    }

    /**
     * @test
     */
    public function it_can_assign_to_username()
    {
        $message = new SlackMessage('Hello');
        $message->assignTo('john.doe');

        $data = $message->toArray();

        $this->assertEquals('john.doe', $data['username']);
    }

    /**
     * @test
     */
    public function it_can_set_channel()
    {
        $message = new SlackMessage('Hello');
        $message->on('#random');

        $data = $message->toArray();

        $this->assertEquals('#random', $data['channel']);
    }

    /**
     * @test
     */
    public function it_can_set_emoji()
    {
        $message = new SlackMessage('Hello');
        $message->withEmoji(':smile:');

        $data = $message->toArray();

        $this->assertEquals(':smile:', $data['icon_emoji']);
    }

    /**
     * @test
     */
    public function it_can_set_icon()
    {
        $message = new SlackMessage('Hello');
        $message->withIcon('https://example.com/icon.png');

        $data = $message->toArray();

        $this->assertEquals('https://example.com/icon.png', $data['icon_url']);
    }

    /**
     * @test
     */
    public function it_can_set_unfurl_links()
    {
        $message = new SlackMessage('Hello');
        $message->withUnfurlLinks(true);

        $data = $message->toArray();

        $this->assertTrue((bool) $data['unfurl_links']);
    }

    /**
     * @test
     */
    public function it_can_add_attachment()
    {
        $message = new SlackMessage('Hello');
        $attachment = new SlackAttachment('Fallback text');
        $attachment->setText('Attachment text');

        $message->addAttachment($attachment);
        $data = $message->toArray();

        $this->assertCount(1, $data['attachments']);
        $this->assertEquals('Fallback text', $data['attachments'][0]['fallback']);
        $this->assertEquals('Attachment text', $data['attachments'][0]['text']);
    }

    /**
     * @test
     */
    public function it_can_add_multiple_attachments()
    {
        $message = new SlackMessage('Hello');

        $attachment1 = new SlackAttachment('Fallback 1');
        $attachment1->setText('Text 1');

        $attachment2 = new SlackAttachment('Fallback 2');
        $attachment2->setText('Text 2');

        $message->addAttachment($attachment1)
            ->addAttachment($attachment2);

        $data = $message->toArray();

        $this->assertCount(2, $data['attachments']);
        $this->assertEquals('Fallback 1', $data['attachments'][0]['fallback']);
        $this->assertEquals('Text 1', $data['attachments'][0]['text']);
        $this->assertEquals('Fallback 2', $data['attachments'][1]['fallback']);
        $this->assertEquals('Text 2', $data['attachments'][1]['text']);
    }

    /**
     * @test
     */
    public function it_can_chain_methods()
    {
        $message = (new SlackMessage('Initial text'))
            ->content('Updated text')
            ->assignTo('john.doe')
            ->on('#random')
            ->withEmoji(':smile:')
            ->withIcon('https://example.com/icon.png')
            ->withUnfurlLinks(true);

        $data = $message->toArray();

        $this->assertEquals('Updated text', $data['text']);
        $this->assertEquals('john.doe', $data['username']);
        $this->assertEquals('#random', $data['channel']);
        $this->assertEquals(':smile:', $data['icon_emoji']);
        $this->assertEquals('https://example.com/icon.png', $data['icon_url']);
        $this->assertTrue($data['unfurl_links']);
    }
}
