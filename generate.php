<?php
require_once 'vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

$url = 'vendor/fortawesome/font-awesome/advanced-options/metadata/categories.yml';
$yaml = Yaml::parse(file_get_contents($url));

$url = 'vendor/fortawesome/font-awesome/advanced-options/metadata/icons.yml';
$iconsYaml = Yaml::parse(file_get_contents($url));

$brandIcons = [];
foreach($iconsYaml as $icon => $data)
{
  if($data['styles'] && in_array('brands', $data['styles']))
  {
    $brandIcons[] = $icon;
  }
}

$reservedWords = [
  'abstract',
  'and',
  'array',
  'as',
  'break',
  'callable',
  'case',
  'catch',
  'class',
  'clone',
  'const',
  'continue',
  'declare',
  'default',
  'die',
  'do',
  'echo',
  'else',
  'elseif',
  'empty',
  'enddeclare',
  'endfor',
  'endforeach',
  'endif',
  'endswitch',
  'endwhile',
  'eval',
  'exit',
  'extends',
  'final',
  'for',
  'foreach',
  'function',
  'global',
  'goto',
  'if',
  'implements',
  'include',
  'include_once',
  'instanceof',
  'insteadof',
  'interface',
  'isset',
  'list',
  'namespace',
  'new',
  'or',
  'print',
  'private',
  'protected',
  'public',
  'require',
  'require_once',
  'return',
  'static',
  'switch',
  'throw',
  'trait',
  'try',
  'unset',
  'use',
  'var',
  'while',
  'xor',
];

$usedIcons = [];
$interfaces = [];

function iconsLoop($class, $icons, &$usedIcons, &$reservedWords)
{

  $return = '';
  $icons = array_unique($icons);
  foreach($icons as $icon)
  {
    $constName = str_replace('-', '_', strtoupper($icon));
    if(is_numeric($constName[0]) || in_array(strtolower($constName), $reservedWords))
    {
      $constName = '_' . $constName;
    }
    if(isset($usedIcons[$constName]))
    {
      $acro = preg_replace('/[a-z]/', '', $class);
      if(strlen($acro) < 3)
      {
        $acro = strtoupper(substr($class, 0, 3));
      }
      $constName .= '_' . $acro;
    }
    $usedIcons[$constName] = $icon;
    $return .= "  const " . $constName . ' = \'fa-' . $icon . '\';' . PHP_EOL;
  }

  return $return;
}

foreach($yaml as $category => $catData)
{
  $catName = $catData['label'];
  $icons = $catData['icons'];

  $className = str_replace(' ', '', ucwords(str_replace('-', ' ', $category)) . 'Icons');
  $interfaces[] = $className;

  $fileContent = '<?php' . PHP_EOL;
  $fileContent .= 'namespace Fortifi\FontAwesome\Interfaces\Icons;' . PHP_EOL . PHP_EOL;
  $fileContent .= 'interface ' . $className . PHP_EOL;
  $fileContent .= '{' . PHP_EOL;
  $fileContent .= iconsLoop($className, $icons, $usedIcons, $reservedWords);
  $fileContent .= '}' . PHP_EOL;

  $filename = 'src/Interfaces/Icons/' . $className . '.php';

  file_put_contents($filename, $fileContent);
}

$fileContent = '<?php' . PHP_EOL;
$fileContent .= 'namespace Fortifi\FontAwesome\Interfaces\Icons;' . PHP_EOL . PHP_EOL;
$fileContent .= 'interface FaBrandIcons' . PHP_EOL;
$fileContent .= '{' . PHP_EOL;
$fileContent .= iconsLoop('FaBrandIcons', $brandIcons, $usedIcons, $reservedWords);
$fileContent .= PHP_EOL;
$fileContent .= '  const __BRAND_ICONS = [\'fa-' . implode('\',\'fa-', $brandIcons) . '\'];' . PHP_EOL;
$fileContent .= '}' . PHP_EOL;

$filename = 'src/Interfaces/Icons/FaBrandIcons.php';
file_put_contents($filename, $fileContent);
$interfaces[] = 'FaBrandIcons';

$fileContent = '<?php' . PHP_EOL;
$fileContent .= 'namespace Fortifi\FontAwesome\Interfaces\Icons;' . PHP_EOL . PHP_EOL;
$fileContent .= 'interface FaIcons extends ' . implode(', ', $interfaces) . PHP_EOL;
$fileContent .= '{' . PHP_EOL;
$fileContent .= '}' . PHP_EOL;

$filename = 'src/Interfaces/Icons/FaIcons.php';
file_put_contents($filename, $fileContent);
