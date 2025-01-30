<?php

namespace Bow\Slack\Tests;

use PHPUnit\Framework\TestCase;
use Bow\Slack\Attachment\SlackAttachmentField;

class SlackAttachmentFieldTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_create_attachment_field_with_required_parameters()
    {
        $field = new SlackAttachmentField('Title', 'Value');

        $data = $field->toArray();

        $this->assertEquals('Title', $data['title']);
        $this->assertEquals('Value', $data['value']);
        $this->assertArrayNotHasKey('short', $data);
    }

    /**
     * @test
     */
    public function it_can_create_attachment_field_with_short_parameter()
    {
        $field = new SlackAttachmentField('Title', 'Value', 'true');

        $data = $field->toArray();

        $this->assertEquals('Title', $data['title']);
        $this->assertEquals('Value', $data['value']);
        $this->assertTrue($data['short']);
    }

    /**
     * @test
     */
    public function it_can_set_short_parameter_after_creation()
    {
        $field = new SlackAttachmentField('Title', 'Value');
        $field->setShort(true);

        $data = $field->toArray();

        $this->assertEquals('Title', $data['title']);
        $this->assertEquals('Value', $data['value']);
        $this->assertTrue($data['short']);
    }

    /**
     * @test
     */
    public function it_can_chain_methods()
    {
        $field = (new SlackAttachmentField('Title', 'Value'))
            ->setShort(true);

        $data = $field->toArray();

        $this->assertEquals('Title', $data['title']);
        $this->assertEquals('Value', $data['value']);
        $this->assertTrue($data['short']);
    }
}
