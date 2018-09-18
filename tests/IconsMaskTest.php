<?php
namespace Fortifi\Tests\FontAwesome;

use Fortifi\FontAwesome\Enums\FaStyle;
use Fortifi\FontAwesome\FaIcon;
use PHPUnit\Framework\TestCase;

class IconsMaskTest extends TestCase
{
  public function testMask()
  {
    $icon = FaIcon::create();
    $icon->mask($icon::ROCKET);
    $this->assertTrue($icon->glimpse()->hasAttribute('data-fa-mask'));
    $maskAttr = $icon->glimpse()->getAttribute('data-fa-mask');
    $this->assertTrue(strpos($maskAttr, FaStyle::SOLID) !== false);
    $this->assertTrue(strpos($maskAttr, $icon::ROCKET) !== false);
  }
}
