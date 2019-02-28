<?php
namespace PackagedUi\Tests\FontAwesome;

use PackagedUi\FontAwesome\Enums\FaPull;
use PackagedUi\FontAwesome\FaIcon;
use PHPUnit\Framework\TestCase;

class IconsPullTest extends TestCase
{
  public function testPullLeft()
  {
    $icon = FaIcon::create();
    $icon->pullLeft();
    $this->assertTrue($icon->hasClass(FaPull::LEFT));
  }

  public function testPullRight()
  {
    $icon = FaIcon::create();
    $icon->pullRight();
    $this->assertTrue($icon->hasClass(FaPull::RIGHT));
  }
}
