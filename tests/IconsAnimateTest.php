<?php
namespace Fortifi\Tests\FontAwesome;

use Fortifi\FontAwesome\Enums\FaAnimate;
use Fortifi\FontAwesome\FaIcon;
use PHPUnit\Framework\TestCase;

class IconsAnimateTest extends TestCase
{
  public function testAnimateSpin()
  {
    $icon = FaIcon::create();
    $icon->spin();
    $this->assertTrue($icon->hasClass(FaAnimate::SPIN));
  }

  public function testAnimatePulse()
  {
    $icon = FaIcon::create();
    $icon->pulse();
    $this->assertTrue($icon->hasClass(FaAnimate::PULSE));
  }
}
