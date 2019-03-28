<?php
namespace PackagedUi\FontAwesome;

use Exception;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Tags\Span;
use Packaged\Glimpse\Tags\Text\ItalicText;
use Packaged\Helpers\ValueAs;
use Packaged\SafeHtml\ISafeHtmlProducer;
use Packaged\SafeHtml\SafeHtml;
use PackagedUi\FontAwesome\Enums\FaAnimate;
use PackagedUi\FontAwesome\Enums\FaPull;
use PackagedUi\FontAwesome\Enums\FaRotate;
use PackagedUi\FontAwesome\Enums\FaSizes;
use PackagedUi\FontAwesome\Enums\FaStyle;
use PackagedUi\FontAwesome\Enums\FaTransforms;
use PackagedUi\FontAwesome\Generated\FaBrandIcons;
use PackagedUi\FontAwesome\Generated\FaIcons;

class FaIcon implements FaIcons, ISafeHtmlProducer
{
  /** @var string */
  protected $_iconKey = '';
  /** @var HtmlTag */
  protected $_icon = null;
  /** @var string */
  protected $_style = FaStyle::SOLID;
  /** @var array */
  protected $_transforms = [];
  /** @var array */
  protected $_layers = [];

  /**
   * AbstractFaIcon constructor.
   *
   * @param string $icon
   */
  public function __construct($icon = null)
  {
    if(is_string($icon))
    {
      $this->_iconKey = $icon;
    }
    $this->_createIcon();
  }

  /**
   * @param string $icon
   *
   * @return static
   */
  static public function create($icon = null)
  {
    $self = new static($icon);
    return $self;
  }

  protected function _createIcon()
  {
    if(in_array($this->_iconKey, FaBrandIcons::__BRAND_ICONS))
    {
      $this->_setStyle(FaStyle::BRANDS, true);
    }
    else
    {
      switch(substr($this->_iconKey, -2))
      {
        case '-o':
          $this->_setStyle(FaStyle::LIGHT, true);
          $this->_iconKey = substr($this->_iconKey, 0, -2);
          break;
        case '-r':
          $this->_setStyle(FaStyle::REGULAR, true);
          $this->_iconKey = substr($this->_iconKey, 0, -2);
          break;
      }
    }

    $this->_icon = ItalicText::create();
    $this->_icon->addClass($this->_iconKey, $this->_getStyle());
  }

  /**
   * @param FaIcon[] ...$icons
   *
   * @return Span
   */
  static public function layers(...$icons)
  {
    $items = [];
    foreach($icons as $icon)
    {
      if($icon instanceof FaIcon)
      {
        $items[] = $icon;
      }
    }
    return Span::create($items)->addClass('fa-layers', 'fa-fw');
  }

  static public function stack(...$icons)
  {
    $items = [];

    foreach($icons as $i => $icon)
    {
      if($icon instanceof FaIcon)
      {
        $icon->addClass('fa-stack-' . ($i == 0 ? 2 : 1) . 'x');
        $items[] = $icon;
      }
    }
    return Span::create($items)->addClass('fa-stack', 'fa-fw');
  }

  /**
   * By default, FontAwesome uses '<i>' tags for brevity.
   * '<span>' is more semantic, and is opt in
   *
   * @return $this
   */
  public function span()
  {
    $icon = Span::create($this->_icon->getContent());
    $icon->setAttributes($this->_icon->getAttributes());
    $icon->addClass($this->_icon->getClasses());
    $this->_icon = $icon;
    return $this;
  }

  public function fixedWidth()
  {
    $this->_icon->addClass('fa-fw');
    return $this;
  }

  public function border()
  {
    $this->_icon->addClass('fa-border');
    return $this;
  }

  /**
   * Unset classes before adding new
   *
   * @param array $classes
   */
  protected function _removeClasses(array $classes)
  {
    foreach($this->_icon->getClasses() as $class)
    {
      if(in_array($class, $classes))
      {
        $this->_icon->removeClass($class);
      }
    }
  }

  /**
   * @return string
   */
  protected function _getStyle()
  {
    return $this->_style;
  }

  // Define styles

  /**
   * @param string $style
   *
   * @param bool   $simple Apply to property only
   *
   * @return $this
   */
  protected function _setStyle($style, $simple = false)
  {
    if(in_array($this->_iconKey, FaBrandIcons::__BRAND_ICONS))
    {
      $style = FaStyle::BRANDS;
    }
    $this->_style = $style;

    if(!$simple)
    {
      // unset previously applied before applying new
      $this->_removeClasses(FaStyle::getValues());
      $this->_icon->addClass($this->_style);
    }
    return $this;
  }

  /**
   * 'fas' (solid) is the FontAwesome default style
   *
   * @return $this
   */
  public function styleSolid()
  {
    $this->_setStyle(FaStyle::SOLID);
    return $this;
  }

  // Define sizes

  /**
   * @param string $size
   *
   * @return $this
   */
  public function setSize($size = FaSizes::SM)
  {
    if(FaSizes::isValid($size))
    {
      // unset previously applied before applying new
      $this->_removeClasses(FaSizes::getValues());
      $this->_icon->addClass($size);
    }
    return $this;
  }

  /**
   * 0.75em
   *
   * @return $this
   */
  public function sizeXSmall()
  {
    $this->setSize(FaSizes::XS);
    return $this;
  }

  /**
   * 0.875em
   *
   * @return $this
   */
  public function sizeSmall()
  {
    $this->setSize(FaSizes::SM);
    return $this;
  }

  /**
   * 1.33em
   * Also applies vertical-align: -25%
   *
   * @return $this
   */
  public function sizeLarge()
  {
    $this->setSize(FaSizes::LG);
    return $this;
  }

  public function sizeX1()
  {
    $this->setSize(FaSizes::X1);
    return $this;
  }

  public function sizeX2()
  {
    $this->setSize(FaSizes::X2);
    return $this;
  }

  public function sizeX3()
  {
    $this->setSize(FaSizes::X3);
    return $this;
  }

  public function sizeX4()
  {
    $this->setSize(FaSizes::X4);
    return $this;
  }

  public function sizeX5()
  {
    $this->setSize(FaSizes::X5);
    return $this;
  }

  public function sizeX6()
  {
    $this->setSize(FaSizes::X6);
    return $this;
  }

  public function sizeX7()
  {
    $this->setSize(FaSizes::X7);
    return $this;
  }

  public function sizeX8()
  {
    $this->setSize(FaSizes::X8);
    return $this;
  }

  public function sizeX9()
  {
    $this->setSize(FaSizes::X9);
    return $this;
  }

  public function sizeX10()
  {
    $this->setSize(FaSizes::X10);
    return $this;
  }

  // Define animation

  /**
   * @param string $animation
   *
   * @return $this
   */
  protected function _animate($animation = FaAnimate::SPIN)
  {
    if(FaAnimate::isValid($animation))
    {
      // unset previously applied before applying new
      $this->_removeClasses(FaAnimate::getValues());
      $this->_icon->addClass($animation);
    }
    return $this;
  }

  public function spin()
  {
    $this->_animate(FaAnimate::SPIN);
    return $this;
  }

  public function pulse()
  {
    $this->_animate(FaAnimate::PULSE);
    return $this;
  }

  // Define pull

  /**
   * @param string $direction
   *
   * @return $this
   */
  protected function _pull($direction = FaPull::LEFT)
  {
    if(FaPull::isValid($direction))
    {
      // unset previously applied before applying new
      $this->_removeClasses(FaPull::getValues());
      $this->_icon->addClass($direction);
    }
    return $this;
  }

  public function pullLeft()
  {
    $this->_pull(FaPull::LEFT);
    return $this;
  }

  public function pullRight()
  {
    $this->_pull(FaPull::RIGHT);
    return $this;
  }

  // Define transforms

  /**
   * @param string $newTransform
   *
   * @return $this
   */
  protected function _addTransform($newTransform)
  {
    $attrName = 'data-fa-transform';

    // get existing transforms
    $attr = $this->_icon->getAttribute($attrName);
    $transforms = $attr ? array_filter($attr) : $attr;
    $transforms = $transforms ? array_unique($transforms) : $transforms;

    // add new transform
    $transforms[] = $newTransform;

    // set transforms attribute
    $this->_icon->setAttribute($attrName, $transforms);

    return $this;
  }

  /**
   * @param int $value
   *
   * @return $this
   */
  public function grow($value = 1)
  {
    if(is_numeric($value))
    {
      $this->_addTransform(FaTransforms::GROW . "-{$value}");
    }
    return $this;
  }

  /**
   * @param int $value
   *
   * @return $this
   */
  public function shrink($value = 1)
  {
    if(is_numeric($value))
    {
      $this->_addTransform(FaTransforms::SHRINK . "-{$value}");
    }
    return $this;
  }

  /**
   * @param int $value
   *
   * @return $this
   */
  public function rotate($value = 90)
  {
    if(is_numeric($value))
    {
      $this->_addTransform(FaTransforms::ROTATE . "-{$value}");
    }
    return $this;
  }

  /**
   * Multiple flips are allowed. Comma separate them. FaFlip::*
   *
   * @param string $flip
   *
   * @return $this
   */
  public function flip($flip)
  {
    if(func_num_args() === 1)
    {
      $directions = ValueAs::arr($flip);
    }
    else
    {
      $directions = func_get_args();
    }

    $flips = [];
    foreach($directions as $direction)
    {
      if(FaRotate::isValid($direction) && !in_array($direction, $flips))
      {
        $flips[] = $direction;
        $this->_addTransform($direction);
      }
    }

    return $this;
  }

  /**
   * Inner icon (cut out); Set using typical class attribute. Transform using
   * data-fa-transform. Outer icon; Set using data-fa-mask.
   *
   * @param string $icon
   * @param string $style
   *
   * @return $this
   */
  public function mask($icon = null, $style = FaStyle::SOLID)
  {
    $this->_icon->setAttribute('data-fa-mask', "{$style} {$icon}");
    return $this;
  }

  /**
   * @param string $colour
   *
   * @return $this
   */
  public function setColour($colour)
  {
    if(is_string($colour))
    {
      $this->_icon->setAttribute('style', "color: {$colour}");
    }
    return $this;
  }

  // set position

  /**
   * @param string $direction
   * @param int    $value
   *
   * @return $this
   */
  protected function _move($direction, $value)
  {
    if(FaTransforms::isValid($direction) && is_numeric($value))
    {
      $this->_addTransform("{$direction}-{$value}");
    }
    return $this;
  }

  /**
   * @param int $value
   *
   * @return $this
   */
  public function moveUp($value = 0)
  {
    $this->_move(FaTransforms::UP, $value);
    return $this;
  }

  /**
   * @param int $value
   *
   * @return $this
   */
  public function moveDown($value = 0)
  {
    $this->_move(FaTransforms::DOWN, $value);
    return $this;
  }

  /**
   * @param int $value
   *
   * @return $this
   */
  public function moveLeft($value = 0)
  {
    $this->_move(FaTransforms::LEFT, $value);
    return $this;
  }

  /**
   * @param int $value
   *
   * @return $this
   */
  public function moveRight($value = 0)
  {
    $this->_move(FaTransforms::RIGHT, $value);
    return $this;
  }

  /**
   * @return HtmlTag
   */
  public function glimpse()
  {
    return $this->_icon;
  }

  /**
   * @return string
   */
  public function getIcon()
  {
    return $this->_iconKey;
  }

  /**
   * @param array ...$class
   *
   * @return $this
   */
  public function addClass(...$class)
  {
    $this->_icon->addClass(...$class);
    return $this;
  }

  /**
   * @param array ...$class
   *
   * @return $this
   */
  public function removeClass(...$class)
  {
    $this->_icon->removeClass(...$class);
    return $this;
  }

  /**
   * @param string $class
   *
   * @return bool
   */
  public function hasClass($class)
  {
    return $this->_icon->hasClass($class);
  }

  /**
   * @return SafeHtml
   */
  public function produceSafeHTML(): SafeHtml
  {
    try
    {
      return $this->_icon->produceSafeHTML();
    }
    catch(Exception $e)
    {
      return new SafeHtml('');
    }
  }

  /**
   * @return string
   */
  public function asHtml()
  {
    return (string)$this->produceSafeHTML();
  }

  /**
   * @return string
   */
  public function __toString()
  {
    return $this->asHtml();
  }

  /**
   * @return $this
   */
  public function styleRegular()
  {
    $this->_setStyle(FaStyle::REGULAR);
    return $this;
  }

  /**
   * @return $this
   */
  public function styleLight()
  {
    $this->_setStyle(FaStyle::LIGHT);
    return $this;
  }
}
