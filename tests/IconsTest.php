<?php
namespace Fortifi\Tests\FontAwesome;

use Fortifi\FontAwesome\FaIcon;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\SafeHtml\SafeHtml;
use PHPUnit\Framework\TestCase;

class IconsTest extends TestCase
{
  public function testIconForSyntaxError()
  {
    $this->assertTrue(
      is_object(FaIcon::create())
    );
  }

  public function testIconObjectType()
  {
    $this->assertTrue(
      (FaIcon::create()->glimpse() instanceof HtmlTag)
    );
  }

  public function testInstanceOf()
  {
    $icon = FaIcon::create();
    $this->assertTrue(
      $icon instanceof FaIcon
    );
  }

  public function testAliasIcons()
  {
    $icon = FaIcon::create('fa-y-combinator-square');
    $this->assertTrue($icon->hasClass(FaIcon::HACKER_NEWS));
  }

  public function testIsSpan()
  {
    $icon = FaIcon::create();
    $icon->span();
    $this->assertTrue($icon->glimpse()->getTag() == 'span');
  }

  public function testIsFixedWidth()
  {
    $icon = FaIcon::create();
    $icon->fixedWidth();
    $this->assertTrue($icon->hasClass('fa-fw'));
  }

  public function testIsBorder()
  {
    $icon = FaIcon::create();
    $icon->border();
    $this->assertTrue($icon->hasClass('fa-border'));
  }

  public function testColour()
  {
    $icon = FaIcon::create();
    $icon->setColour('red');

    $this->assertTrue($icon->glimpse()->hasAttribute('style'));

    $this->assertTrue(strpos($icon->glimpse()->getAttribute('style'), 'color: red') !== false);
  }

  public function testLayers()
  {
    $icon = FaIcon::create();
    $layers = FaIcon::layers($icon, $icon, $icon, $icon, 'test', new \stdClass());

    $this->assertEquals(4, count($layers->getContent(true)));
    $this->assertTrue($layers->hasClass('fa-layers'));
  }

  public function testSafeHtml()
  {
    $icon = FaIcon::create();
    $this->assertTrue($icon->produceSafeHTML() instanceof SafeHtml);
  }

  public function testAsHtml()
  {
    $icon = FaIcon::create();
    $this->assertTrue(is_string($icon->asHtml()));
  }

  public function testToString()
  {
    $icon = FaIcon::create();
    $this->assertTrue(is_string($icon->__toString()));
  }

  public function testGetIcon()
  {
    $icon = FaIcon::create(FaIcon::BAN);
    $this->assertEquals(FaIcon::BAN, $icon->getIcon());
  }

  public function testAddRemoveClass()
  {
    $icon = FaIcon::create(FaIcon::BAN);
    $icon->addClass('test', 'test1', 'test2');

    $this->assertTrue($icon->hasClass('test'));
    $this->assertTrue($icon->hasClass('test1'));
    $this->assertTrue($icon->hasClass('test2'));

    // remove classes
    $icon->removeClass('test', 'test1', 'test2');
    $this->assertFalse($icon->hasClass('test'));
    $this->assertFalse($icon->hasClass('test1'));
    $this->assertFalse($icon->hasClass('test2'));
  }
}
