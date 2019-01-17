<?php
namespace Fortifi\FontAwesome;

use Exception;
use Fortifi\FontAwesome\Enums\FaAnimate;
use Fortifi\FontAwesome\Enums\FaEnum;
use Fortifi\FontAwesome\Enums\FaPull;
use Fortifi\FontAwesome\Enums\FaRotate;
use Fortifi\FontAwesome\Enums\FaSizes;
use Fortifi\FontAwesome\Enums\FaStyle;
use Fortifi\FontAwesome\Enums\FaTransforms;
use Fortifi\FontAwesome\Interfaces\Icons\FaBrandIcons;
use Fortifi\FontAwesome\Interfaces\Icons\FaIcons;
use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Core\ISafeHtmlProducer;
use Packaged\Glimpse\Core\SafeHtml;
use Packaged\Glimpse\Tags\Span;
use Packaged\Glimpse\Tags\Text\ItalicText;
use Packaged\Helpers\ValueAs;

class FaIcon extends FaEnum implements FaIcons, ISafeHtmlProducer
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
    $alias = $this->_getIconFromAlias();
    $this->_iconKey = isset($alias[$this->_iconKey]) ? $alias[$this->_iconKey] : $this->_iconKey;

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
    $this->_icon->setTag('span');
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
   * Icon alias list upgrading from Font Awesome 4
   *
   * @return array
   */
  protected function _getIconFromAlias()
  {
    return [
      "fa-area-chart"           => "fa-chart-area",
      "fa-arrow-circle-o-down"  => "fa-arrow-alt-circle-down-o",
      "fa-arrow-circle-o-left"  => "fa-arrow-alt-circle-left-o",
      "fa-arrow-circle-o-right" => "fa-arrow-alt-circle-right-o",
      "fa-arrow-circle-o-up"    => "fa-arrow-alt-circle-up-o",
      "fa-arrows-alt"           => "fa-expand-arrows-alt",
      "fa-arrows-h"             => "fa-arrows-alt-h",
      "fa-arrows-v"             => "fa-arrows-alt-v",
      "fa-arrows"               => "fa-arrows-alt",
      "fa-asl-interpreting"     => "fa-american-sign-language-interpreting",
      "fa-automobile"           => "fa-car",
      "fa-bank"                 => "fa-university",
      "fa-bar-chart-o"          => "fa-chart-bar-o",
      "fa-bar-chart"            => "fa-chart-bar",
      "fa-bathtub"              => "fa-bath",
      "fa-battery-0"            => "fa-battery-empty",
      "fa-battery-1"            => "fa-battery-quarter",
      "fa-battery-2"            => "fa-battery-half",
      "fa-battery-3"            => "fa-battery-three-quarters",
      "fa-battery-4"            => "fa-battery-full",
      "fa-battery"              => "fa-battery-full",
      "fa-bell-slash-o"         => "fa-bell-slash-o",
      "fa-bitbucket-square"     => "fa-bitbucket",
      "fa-bitcoin"              => "fa-btc",
      "fa-cab"                  => "fa-taxi",
      "fa-calendar"             => "fa-calendar-alt",
      "fa-caret-square-o-down"  => "fa-caret-square-down-o",
      "fa-caret-square-o-left"  => "fa-caret-square-left-o",
      "fa-caret-square-o-right" => "fa-caret-square-right-o",
      "fa-caret-square-o-up"    => "fa-caret-square-up-o",
      "fa-cc"                   => "fa-closed-captioning",
      "fa-chain-broken"         => "fa-unlink",
      "fa-chain"                => "fa-link",
      "fa-circle-o-notch"       => "fa-circle-notch-o",
      "fa-circle-thin"          => "fa-circle",
      "fa-close"                => "fa-times",
      "fa-cloud-download"       => "fa-cloud-download-alt",
      "fa-cloud-upload"         => "fa-cloud-upload-alt",
      "fa-cny"                  => "fa-yen-sign",
      "fa-code-fork"            => "fa-code-branch",
      "fa-commenting-o"         => "fa-comment-alt-o",
      "fa-commenting"           => "fa-comment-alt",
      "fa-credit-card-alt"      => "fa-credit-card",
      "fa-cutlery"              => "fa-utensils",
      "fa-dashboard"            => "fa-tachometer-alt",
      "fa-deafness"             => "fa-deaf",
      "fa-dedent"               => "fa-outdent",
      "fa-diamond"              => "fa-gem",
      "fa-dollar"               => "fa-dollar-sign",
      "fa-drivers-license-o"    => "fa-id-card-o",
      "fa-drivers-license"      => "fa-id-card",
      "fa-eercast"              => "fa-sellcast",
      "fa-eur"                  => "fa-euro-sign",
      "fa-euro"                 => "fa-euro-sign",
      "fa-exchange"             => "fa-exchange-alt",
      "fa-external-link-square" => "fa-external-link-square-alt",
      "fa-external-link"        => "fa-external-link-alt",
      "fa-eyedropper"           => "fa-eye-dropper",
      "fa-fa"                   => "fa-font-awesome",
      "fa-facebook-f"           => "fa-facebook-f",
      "fa-facebook-official"    => "fa-facebook",
      "fa-facebook"             => "fa-facebook-f",
      "fa-feed"                 => "fa-rss",
      "fa-file-movie-o"         => "fa-file-video-o",
      "fa-file-pdf-o"           => "fa-file-pdf-o",
      "fa-file-photo-o"         => "fa-file-image-o",
      "fa-file-picture-o"       => "fa-file-image-o",
      "fa-file-sound-o"         => "fa-file-audio-o",
      "fa-file-text-o"          => "fa-file-alt-o",
      "fa-file-text"            => "fa-file-alt",
      "fa-file-video-o"         => "fa-file-video-o",
      "fa-file-word-o"          => "fa-file-word-o",
      "fa-file-zip-o"           => "fa-file-archive-o",
      "fa-files-o"              => "fa-copy-o",
      "fa-flash"                => "fa-bolt",
      "fa-floppy-o"             => "fa-save-o",
      "fa-gbp"                  => "fa-pound-sign",
      "fa-ge"                   => "fa-empire",
      "fa-gear"                 => "fa-cog",
      "fa-gears"                => "fa-cogs",
      "fa-gittip"               => "fa-gratipay",
      "fa-glass"                => "fa-glass-martini",
      "fa-google-plus-circle"   => "fa-google-plus",
      "fa-google-plus-official" => "fa-google-plus",
      "fa-google-plus"          => "fa-google-plus-g",
      "fa-group"                => "fa-users",
      "fa-hand-grab-o"          => "fa-hand-rock-o",
      "fa-hand-lizard-o"        => "fa-hand-lizard-o",
      "fa-hand-o-down"          => "fa-hand-point-down-o",
      "fa-hand-o-left"          => "fa-hand-point-left-o",
      "fa-hand-o-right"         => "fa-hand-point-right-o",
      "fa-hand-o-up"            => "fa-hand-point-up-o",
      "fa-hand-stop-o"          => "fa-hand-paper-o",
      "fa-hard-of-hearing"      => "fa-deaf",
      "fa-header"               => "fa-heading",
      "fa-hotel"                => "fa-bed",
      "fa-hourglass-1"          => "fa-hourglass-start",
      "fa-hourglass-2"          => "fa-hourglass-half",
      "fa-hourglass-3"          => "fa-hourglass-end",
      "fa-ils"                  => "fa-shekel-sign",
      "fa-inr"                  => "fa-rupee-sign",
      "fa-institution"          => "fa-university",
      "fa-intersex"             => "fa-transgender",
      "fa-jpy"                  => "fa-yen-sign",
      "fa-krw"                  => "fa-won-sign",
      "fa-legal"                => "fa-gavel",
      "fa-level-down"           => "fa-level-down-alt",
      "fa-level-up"             => "fa-level-up-alt",
      "fa-life-bouy"            => "fa-life-ring",
      "fa-life-buoy"            => "fa-life-ring",
      "fa-life-saver"           => "fa-life-ring",
      "fa-lightbulb-o"          => "fa-lightbulb-o",
      "fa-line-chart"           => "fa-chart-line",
      "fa-linkedin-square"      => "fa-linkedin",
      "fa-linkedin"             => "fa-linkedin-in",
      "fa-long-arrow-down"      => "fa-long-arrow-alt-down",
      "fa-long-arrow-left"      => "fa-long-arrow-alt-left",
      "fa-long-arrow-right"     => "fa-long-arrow-alt-right",
      "fa-long-arrow-up"        => "fa-long-arrow-alt-up",
      "fa-mail-forward"         => "fa-share",
      "fa-mail-reply-all"       => "fa-reply-all",
      "fa-mail-reply"           => "fa-reply",
      "fa-map-marker"           => "fa-map-marker-alt",
      "fa-meanpath"             => "fa-font-awesome",
      "fa-mobile-phone"         => "fa-mobile-alt",
      "fa-mobile"               => "fa-mobile-alt",
      "fa-money"                => "fa-money-bill-alt",
      "fa-mortar-board"         => "fa-graduation-cap",
      "fa-navicon"              => "fa-bars",
      "fa-paste"                => "fa-clipboard",
      "fa-pencil-square-o"      => "fa-edit-o",
      "fa-pencil-square"        => "fa-pen-square",
      "fa-pencil"               => "fa-pencil-alt",
      "fa-photo"                => "fa-image",
      "fa-picture-o"            => "fa-image-o",
      "fa-pie-chart"            => "fa-chart-pie",
      "fa-ra"                   => "fa-rebel",
      "fa-refresh"              => "fa-sync",
      "fa-remove"               => "fa-times",
      "fa-reorder"              => "fa-bars",
      "fa-repeat"               => "fa-redo",
      "fa-resistance"           => "fa-rebel",
      "fa-rmb"                  => "fa-yen-sign",
      "fa-rotate-left"          => "fa-undo",
      "fa-rotate-right"         => "fa-redo",
      "fa-rouble"               => "fa-ruble-sign",
      "fa-rub"                  => "fa-ruble-sign",
      "fa-ruble"                => "fa-ruble-sign",
      "fa-rupee"                => "fa-rupee-sign",
      "fa-s15"                  => "fa-bath",
      "fa-scissors"             => "fa-cut",
      "fa-send-o"               => "fa-paper-plane-o",
      "fa-send"                 => "fa-paper-plane",
      "fa-shekel"               => "fa-shekel-sign",
      "fa-sheqel"               => "fa-shekel-sign",
      "fa-shield"               => "fa-shield-alt",
      "fa-sign-in"              => "fa-sign-in-alt",
      "fa-sign-out"             => "fa-sign-out-alt",
      "fa-signing"              => "fa-sign-language",
      "fa-sliders"              => "fa-sliders-h",
      "fa-snowflake-o"          => "fa-snowflake-o",
      "fa-soccer-ball-o"        => "fa-futbol-o",
      "fa-sort-alpha-asc"       => "fa-sort-alpha-down",
      "fa-sort-alpha-desc"      => "fa-sort-alpha-up",
      "fa-sort-amount-asc"      => "fa-sort-amount-down",
      "fa-sort-amount-desc"     => "fa-sort-amount-up",
      "fa-sort-asc"             => "fa-sort-up",
      "fa-sort-desc"            => "fa-sort-down",
      "fa-sort-numeric-asc"     => "fa-sort-numeric-down",
      "fa-sort-numeric-desc"    => "fa-sort-numeric-up",
      "fa-spoon"                => "fa-utensil-spoon",
      "fa-star-half-empty"      => "fa-star-half",
      "fa-star-half-full"       => "fa-star-half",
      "fa-support"              => "fa-life-ring",
      "fa-tablet"               => "fa-tablet-alt",
      "fa-tachometer"           => "fa-tachometer-alt",
      "fa-television"           => "fa-tv",
      "fa-thermometer-0"        => "fa-thermometer-empty",
      "fa-thermometer-1"        => "fa-thermometer-quarter",
      "fa-thermometer-2"        => "fa-thermometer-half",
      "fa-thermometer-3"        => "fa-thermometer-three-quarters",
      "fa-thermometer-4"        => "fa-thermometer-full",
      "fa-thermometer"          => "fa-thermometer-full",
      "fa-thumb-tack"           => "fa-thumbtack",
      "fa-thumbs-o-down"        => "fa-thumbs-down-o",
      "fa-thumbs-o-up"          => "fa-thumbs-up-o",
      "fa-ticket"               => "fa-ticket-alt",
      "fa-times-rectangle-o"    => "fa-window-close-o",
      "fa-times-rectangle"      => "fa-window-close",
      "fa-toggle-down"          => "fa-caret-square-down",
      "fa-toggle-left"          => "fa-caret-square-left",
      "fa-toggle-right"         => "fa-caret-square-right",
      "fa-toggle-up"            => "fa-caret-square-up",
      "fa-trash-o"              => "fa-trash-alt-o",
      "fa-trash"                => "fa-trash-alt",
      "fa-try"                  => "fa-lira-sign",
      "fa-turkish-lira"         => "fa-lira-sign",
      "fa-unsorted"             => "fa-sort",
      "fa-usd"                  => "fa-dollar-sign",
      "fa-vcard-o"              => "fa-address-card-o",
      "fa-vcard"                => "fa-address-card",
      "fa-video-camera"         => "fa-video",
      "fa-vimeo"                => "fa-vimeo-v",
      "fa-volume-control-phone" => "fa-phone-volume",
      "fa-warning"              => "fa-exclamation-triangle",
      "fa-wechat"               => "fa-weixin",
      "fa-wheelchair-alt"       => "fa-accessible-icon",
      "fa-won"                  => "fa-won-sign",
      "fa-y-combinator-square"  => "fa-hacker-news",
      "fa-yc-square"            => "fa-hacker-news",
      "fa-yc"                   => "fa-y-combinator",
      "fa-yen"                  => "fa-yen-sign",
      "fa-youtube-play"         => "fa-youtube",
      "fa-youtube-square"       => "fa-youtube",
    ];
  }

  /**
   * @return SafeHtml|SafeHtml[]
   */
  public function produceSafeHTML()
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
