<?php
namespace PackagedUi\Tests\FontAwesome;

use PackagedUi\FontAwesome\Enums\FaSizes;
use PackagedUi\FontAwesome\FaIcon;
use PHPUnit\Framework\TestCase;

class IconsSizeTest extends TestCase
{
  public function testIconSetSize()
  {
    $icon = FaIcon::create();
    $icon->sizeLarge();
    $icon->setSize(FaSizes::X1);
    $this->assertTrue($icon->hasClass(FaSizes::X1));
    $this->assertFalse($icon->hasClass(FaSizes::LG));
  }

  public function testIconSizeXs()
  {
    $icon = FaIcon::create();
    $icon->sizeXSmall();
    $this->assertTrue($icon->hasClass(FaSizes::XS));
  }

  public function testIconSizeSm()
  {
    $icon = FaIcon::create();
    $icon->sizeSmall();
    $this->assertTrue($icon->hasClass(FaSizes::SM));
  }

  public function testIconSizeLarge()
  {
    $icon = FaIcon::create();
    $icon->sizeLarge();
    $this->assertTrue($icon->hasClass(FaSizes::LG));
  }

  public function testIconSizeX1()
  {
    $icon = FaIcon::create();
    $icon->sizeX1();
    $this->assertTrue($icon->hasClass(FaSizes::X1));
  }

  public function testIconSizeX2()
  {
    $icon = FaIcon::create();
    $icon->sizeX2();
    $this->assertTrue($icon->hasClass(FaSizes::X2));
  }

  public function testIconSizeX3()
  {
    $icon = FaIcon::create();
    $icon->sizeX3();
    $this->assertTrue($icon->hasClass(FaSizes::X3));
  }

  public function testIconSizeX4()
  {
    $icon = FaIcon::create();
    $icon->sizeX4();
    $this->assertTrue($icon->hasClass(FaSizes::X4));
  }

  public function testIconSizeX5()
  {
    $icon = FaIcon::create();
    $icon->sizeX5();
    $this->assertTrue($icon->hasClass(FaSizes::X5));
  }

  public function testIconSizeX6()
  {
    $icon = FaIcon::create();
    $icon->sizeX6();
    $this->assertTrue($icon->hasClass(FaSizes::X6));
  }

  public function testIconSizeX7()
  {
    $icon = FaIcon::create();
    $icon->sizeX7();
    $this->assertTrue($icon->hasClass(FaSizes::X7));
  }

  public function testIconSizeX8()
  {
    $icon = FaIcon::create();
    $icon->sizeX8();
    $this->assertTrue($icon->hasClass(FaSizes::X8));
  }

  public function testIconSizeX9()
  {
    $icon = FaIcon::create();
    $icon->sizeX9();
    $this->assertTrue($icon->hasClass(FaSizes::X9));
  }

  public function testIconSizeX10()
  {
    $icon = FaIcon::create();
    $icon->sizeX10();
    $this->assertTrue($icon->hasClass(FaSizes::X10));
  }
}
