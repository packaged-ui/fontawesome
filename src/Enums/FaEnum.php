<?php
namespace Fortifi\FontAwesome\Enums;

use Exception;
use Fortifi\FontAwesome\Interfaces\IEnum;

abstract class FaEnum implements IEnum
{
  protected static $_valueCache = [];

  /**
   * @return array
   */
  public static function getValues()
  {
    $class = get_called_class();
    if(!isset(static::$_valueCache[$class]))
    {
      try
      {
        $oClass = new \ReflectionClass($class);
        static::$_valueCache[$class] = array_values($oClass->getConstants());
      }
      catch(Exception $e)
      {
        static::$_valueCache[$class] = [];
      }
    }

    return static::$_valueCache[$class];
  }

  /**
   * @param      $value
   *
   * @param bool $strict
   *
   * @return bool
   */
  public static function isValid($value, $strict = false)
  {
    return in_array($value, static::getValues(), $strict);
  }
}
