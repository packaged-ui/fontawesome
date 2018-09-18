Font Awesome 5 Icon Wrapper
=========================

A PHP wrapper for easy Font Awesome 5 icon creation

Example
--------

#### Create Icon:
By default, `FaIcon` class gives access to all FontAwesome Pro icons.
```php
$icon = FaIcon::create(FaIcon::COMMENT_SMILE);
```

#### For Free icons:
There is a helper class for accessing only free icons, using:

```php
$icon = FaIcon::create(FaFreeIcons::ROCKET);
```

#### Create Brand Icon:
Whilst `FaIcon::create();` will work for creating Brand icons, the below class static is for improved code readability of developer intent.
```php
$brandIcon = FaBrandIcon::create(FaBrandIcon::GOOGLE);
```

#### Size options: 
```php
$icon->sizeLarge();
$icon->sizeSmall();
$icon->sizeXSmall();

$icon->sizeX1();
$icon->sizeX2();
$icon->sizeX3();
$icon->sizeX4();
$icon->sizeX5();
$icon->sizeX6();
$icon->sizeX7();
$icon->sizeX8();
$icon->sizeX9();
$icon->sizeX10();
```

#### Style options (pro only):
```php
$icon->styleRegular();
$icon->styleLight();
$icon->styleSolid();
```

#### Transformation options:

##### Flip:
```php
$icon->flip(FaFlip::VERTICAL);
$icon->flip(FaFlip::HORIZONTAL);
```

Multiple flips:
```php
$icon->flip(FaFlip::VERTICAL, FaFlip::HORIZONTAL);
```

##### Shrink / Grow:
```php
$icon->shrink(10);
$icon->grow(10);
```

#### Move:
```php
$icon->moveUp(10);
$icon->moveDown(10);
$icon->moveLeft(10);
$icon->moveRight(10);
```

#### Mask:
```php
$icon->mask(FaIcon::PENCIL_ALT, FaStyle::SOLID);
```

#### Animation options:
```php
$icon->spin();
$icon->pulse();
```

#### Set tag as span (more semantic than default `<i>` tag):
```php
$icon->span();
```

#### Other options:
```php
$icon->fixedWidth();
```
```php
$icon->border();
```
```php
$icon->pullLeft();
$icon->pullRight();
```


### Additional:
Icon object is created using [Glimpse](https://github.com/packaged/glimpse).

Add/remove classes:
```php
$icon->addClass('someClass', 'anotherClass');
$icon->removeClass('remveThis', 'andThis');
```

Get Icon Glimpse object and apply custom attributes:

```php
$icon->glimpse()->setId('uniqueId');
$icon->glimpse()->setAttribute('data-whatever', 'someValue');
```
