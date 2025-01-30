<?php

namespace Bow\Slack\Tests;

use PHPUnit\Framework\TestCase;
use Bow\Slack\Attachment\SlackAttachment;
use Bow\Slack\Attachment\SlackAttachmentField;

class SlackAttachmentTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_create_attachment_with_fallback()
    {
        $attachment = new SlackAttachment('Fallback message');
        $data = $attachment->toArray();

        $this->assertEquals('Fallback message', $data['fallback']);
    }

    /**
     * @test
     */
    public function it_can_set_color()
    {
        $attachment = new SlackAttachment('Fallback message');
        $attachment->setColor('good');

        $data = $attachment->toArray();

        $this->assertEquals('good', $data['color']);
    }

    /**
     * @test
     */
    public function it_can_set_text()
    {
        $attachment = new SlackAttachment('Fallback message');
        $attachment->setText('Message text');

        $data = $attachment->toArray();

        $this->assertEquals('Message text', $data['text']);
    }

    /**
     * @test
     */
    public function it_can_set_pretext()
    {
        $attachment = new SlackAttachment('Fallback message');
        $attachment->setPretext('Pre-text message');

        $data = $attachment->toArray();

        $this->assertEquals('Pre-text message', $data['pretext']);
    }

    /**
     * @test
     */
    public function it_can_set_author_information()
    {
        $attachment = new SlackAttachment('Fallback message');
        $attachment->setAuthor(
            'Author Name',
            'https://example.com/author',
            'https://example.com/author-icon.png'
        );

        $data = $attachment->toArray();

        $this->assertEquals('Author Name', $data['author_name']);
        $this->assertEquals('https://example.com/author', $data['author_link']);
        $this->assertEquals('https://example.com/author-icon.png', $data['author_icon']);
    }

    /**
     * @test
     */
    public function it_can_set_title()
    {
        $attachment = new SlackAttachment('Fallback message');
        $attachment->setTitle('Title', 'https://example.com/title-link');

        $data = $attachment->toArray();

        $this->assertEquals('Title', $data['title']);
        $this->assertEquals('https://example.com/title-link', $data['title_link']);
    }

    /**
     * @test
     */
    public function it_can_set_image()
    {
        $attachment = new SlackAttachment('Fallback message');
        $attachment->setImage('https://example.com/image.png');

        $data = $attachment->toArray();

        $this->assertEquals('https://example.com/image.png', $data['image_url']);
    }

    /**
     * @test
     */
    public function it_can_set_thumbnail()
    {
        $attachment = new SlackAttachment('Fallback message');
        $attachment->setThumbnail('https://example.com/thumb.png');

        $data = $attachment->toArray();

        $this->assertEquals('https://example.com/thumb.png', $data['thumb_url']);
    }

    /**
     * @test
     */
    public function it_can_set_footer()
    {
        $attachment = new SlackAttachment('Fallback message');
        $attachment->setFooterText('Footer text')
                  ->setFooterIcon('https://example.com/footer-icon.png')
                  ->setTimestamp(1234567890);

        $data = $attachment->toArray();

        $this->assertEquals('Footer text', $data['footer']);
        $this->assertEquals('https://example.com/footer-icon.png', $data['footer_icon']);
        $this->assertEquals(1234567890, $data['ts']);
    }

    /**
     * @test
     */
    public function it_can_add_field()
    {
        $attachment = new SlackAttachment('Fallback message');
        $attachment->addField('Title', 'Value', true);

        $data = $attachment->toArray();

        $this->assertCount(1, $data['fields']);
        $this->assertEquals('Title', $data['fields'][0]['title']);
        $this->assertEquals('Value', $data['fields'][0]['value']);
        $this->assertTrue($data['fields'][0]['short']);
    }

    /**
     * @test
     */
    public function it_can_add_field_instance()
    {
        $attachment = new SlackAttachment('Fallback message');
        $field = new SlackAttachmentField('Title', 'Value', 'true');
        $attachment->addFieldInstance($field);

        $data = $attachment->toArray();

        $this->assertCount(1, $data['fields']);
        $this->assertEquals('Title', $data['fields'][0]['title']);
        $this->assertEquals('Value', $data['fields'][0]['value']);
        $this->assertTrue($data['fields'][0]['short']);
    }

    /**
     * @test
     */
    public function it_can_add_button()
    {
        $attachment = new SlackAttachment('Fallback message');
        $attachment->addButton('Click me', 'https://example.com', 'primary');

        $data = $attachment->toArray();

        $this->assertCount(1, $data['actions']);
        $this->assertEquals('button', $data['actions'][0]['type']);
        $this->assertEquals('Click me', $data['actions'][0]['text']);
        $this->assertEquals('https://example.com', $data['actions'][0]['url']);
        $this->assertEquals('primary', $data['actions'][0]['style']);
    }

    /**
     * @test
     */
    public function it_can_enable_markdown()
    {
        $attachment = new SlackAttachment('Fallback message');
        $attachment->enableMarkdownFor('text')
                  ->enableMarkdownFor('pretext');

        $data = $attachment->toArray();

        $this->assertContains('text', $data['markdown_in']);
        $this->assertContains('pretext', $data['markdown_in']);
    }

    /**
     * @test
     */
    public function it_can_chain_methods()
    {
        $attachment = (new SlackAttachment('Fallback message'))
            ->setColor('good')
            ->setText('Message text')
            ->setPretext('Pre-text message')
            ->setAuthor('Author Name')
            ->setTitle('Title')
            ->addField('Field Title', 'Field Value');

        $data = $attachment->toArray();

        $this->assertEquals('Fallback message', $data['fallback']);
        $this->assertEquals('good', $data['color']);
        $this->assertEquals('Message text', $data['text']);
        $this->assertEquals('Pre-text message', $data['pretext']);
        $this->assertEquals('Author Name', $data['author_name']);
        $this->assertEquals('Title', $data['title']);
        $this->assertCount(1, $data['fields']);
    }
}
