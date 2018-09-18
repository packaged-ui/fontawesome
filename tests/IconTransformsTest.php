<?php namespace Fortifi\Tests\FontAwesome;

use Fortifi\FontAwesome\Enums\FaRotate;
use Fortifi\FontAwesome\Enums\FaTransforms;
use Fortifi\FontAwesome\FaIcon;
use PHPUnit\Framework\TestCase;

class IconTransformsTest extends TestCase
{
  /**
   * @param FaIcon $icon
   *
   * @return array
   */
  protected function _getTransforms(FaIcon $icon)
  {
    $attrName = 'data-fa-transform';
    $this->assertTrue($icon->glimpse()->hasAttribute($attrName));
    return $icon->glimpse()->getAttribute($attrName);
  }

  public function testGrow()
  {
    $value = 7;
    $icon = FaIcon::create();
    $icon->grow($value);
    $transforms = $this->_getTransforms($icon);
    $this->assertTrue(in_array(FaTransforms::GROW . "-{$value}", $transforms));
  }

  public function testShrink()
  {
    $value = 9;
    $icon = FaIcon::create();
    $icon->shrink($value);
    $this->assertTrue(in_array(FaTransforms::SHRINK . "-{$value}", $this->_getTransforms($icon)));
  }

  public function testMove()
  {
    $value = 9;
    $icon = FaIcon::create();
    $icon->moveUp($value);
    $icon->moveDown($value);
    $icon->moveLeft($value);
    $icon->moveRight($value);
    $this->assertTrue(in_array(FaTransforms::UP . "-{$value}", $this->_getTransforms($icon)));
    $this->assertTrue(in_array(FaTransforms::DOWN . "-{$value}", $this->_getTransforms($icon)));
    $this->assertTrue(in_array(FaTransforms::LEFT . "-{$value}", $this->_getTransforms($icon)));
    $this->assertTrue(in_array(FaTransforms::RIGHT . "-{$value}", $this->_getTransforms($icon)));
  }

  public function testMultipleTransforms()
  {
    $value = 9;
    $icon = FaIcon::create();
    $icon->shrink($value);
    $icon->grow($value);
    $transforms = $this->_getTransforms($icon);
    $this->assertTrue(in_array(FaTransforms::SHRINK . "-{$value}", $transforms));
    $this->assertTrue(in_array(FaTransforms::GROW . "-{$value}", $transforms));
  }

  public function testFlip()
  {
    $icon = FaIcon::create();
    $icon->flip(FaRotate::VERTICAL);
    $icon->flip(FaRotate::HORIZONTAL, FaRotate::VERTICAL);
    $this->assertTrue(in_array(FaRotate::HORIZONTAL, $this->_getTransforms($icon)));
    $this->assertTrue(in_array(FaRotate::VERTICAL, $this->_getTransforms($icon)));
  }

  public function testRotate()
  {
    $icon = FaIcon::create();
    $icon->rotate();
    $this->assertTrue(in_array(FaTransforms::ROTATE . '-90', $this->_getTransforms($icon)));
  }
}
