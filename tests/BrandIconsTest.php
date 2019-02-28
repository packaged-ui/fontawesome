<?php
namespace PackagedUi\Tests\FontAwesome;

use PackagedUi\FontAwesome\Enums\FaStyle;
use PackagedUi\FontAwesome\FaIcon;
use PHPUnit\Framework\TestCase;

class BrandIconsTest extends TestCase
{
  public function testIconAutoDefineBrandsStyle()
  {
    $icon = FaIcon::create(FaIcon::GOOGLE);

    // default style for icon is SOLID, ensure when setting a brand icon style is updated to use BRAND
    $this->assertTrue(
      $icon->hasClass(FaStyle::BRANDS)
    );
  }

  // this is required to ensure trying to override BRAND style wont work for BRAND icons
  public function testIconChangeBrandsStyle()
  {
    $icon = FaIcon::create(FaIcon::GOOGLE);
    $icon->styleSolid();
    // setStyle() should revert to BRANDS
    $this->assertTrue($icon->hasClass(FaStyle::BRANDS));
  }
}
