<?php
namespace Fortifi\Tests\FontAwesome;

use Fortifi\FontAwesome\Enums\FaStyle;
use Fortifi\FontAwesome\FaIcon;
use PHPUnit\Framework\TestCase;

class ProIconsTest extends TestCase
{
  public function testMoneyOIcon()
  {
    $icon = FaIcon::create('fa-money-bill-alt-o');
    $this->assertTrue($icon->hasClass(FaStyle::LIGHT));

    // we check the -o has been removed from the icon name
    // as this just defines/sets the style to LIGHT
    $this->assertTrue($icon->hasClass(FaIcon::MONEY_BILL_ALT));
  }

  public function testProIconSetLightStyle()
  {
    $icon = FaIcon::create(FaIcon::ROCKET);
    $icon->styleLight();

    $this->assertTrue($icon->hasClass(FaStyle::LIGHT));
  }

  public function testProIconAutoLightStyle()
  {
    $icon = FaIcon::create('fa-rocket-o');

    $this->assertTrue($icon->hasClass(FaStyle::LIGHT));

    // ensure you can change light icon STYLE
    $icon->styleSolid();
    $this->assertTrue($icon->hasClass(FaStyle::SOLID));
  }

  public function testProIconRegularStyle()
  {
    $icon = FaIcon::create(FaIcon::ROCKET);
    $icon->styleRegular();

    $this->assertTrue($icon->hasClass(FaStyle::REGULAR));
  }

  /**
   * If the icon type is not BRAND, icon style should not be BRAND. SOLID is default, so set it to that.
   */
  public function testProIconBrandStyleChange()
  {
    // rocket is NOT a BRANDS icon
    $icon = FaIcon::create(FaIcon::ROCKET);

    // ensure icon does NOT have style of BRANDS as icon is not of type BRAND
    $this->assertFalse($icon->hasClass(FaStyle::BRANDS));

    // ensure icon DOES have style of SOLID. This is the default fallback to ensure icon displays
    $this->assertTrue($icon->hasClass(FaStyle::SOLID));
  }
}
