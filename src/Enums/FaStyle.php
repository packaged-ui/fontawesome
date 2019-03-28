<?php
namespace PackagedUi\FontAwesome\Enums;

use Packaged\Enum\AbstractEnum;

class FaStyle extends AbstractEnum
{
  const REGULAR = 'far';
  const LIGHT = 'fal';
  const SOLID = 'fas';
  const BRANDS = 'fab';

  public static function getValues()
  {
    return [FaStyle::BRANDS, FaStyle::REGULAR, FaStyle::LIGHT, FaStyle::SOLID,];
  }
}
