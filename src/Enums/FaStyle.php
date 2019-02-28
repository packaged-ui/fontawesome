<?php
namespace PackagedUi\FontAwesome\Enums;

class FaStyle extends FaEnum
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
