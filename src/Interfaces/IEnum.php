<?php
namespace Fortifi\FontAwesome\Interfaces;

interface IEnum
{
  /**
   * @return array
   */
  public static function getValues();

  /**
   * @param      $value
   * @param bool $strict
   *
   * @return bool
   */
  public static function isValid($value, $strict = false);
}
