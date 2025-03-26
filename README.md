# 🖼 Kirby 3 WebP

> [!IMPORTANT]
> This plugin is no longer actively maintained, as WebP can now be generated [natively](https://getkirby.com/docs/reference/system/options/thumbs#format) in Kirby 4.

This plugin for [Kirby 3](https://getkirby.com) provides automatic WebP conversion when uploading images (JPG and PNG) via the Panel. With provisions for the use of field methods, KirbyTags and multi-language sites.

**Note:** When using the field methods and KirbyTags the WebP image will be automatically generated when missing. In addition the WebP image will also be removed when the original image is removed via the Panel.

## Commerical Usage

This plugin is free but if you use it in a commercial project please consider to

- [Make a donation](https://paypal.me/mrfdnl/5) or
- [Buy me a coffee](https://buymeacoff.ee/mrfd)

## Requirements

- PHP 7.3+
- Kirby 3

## Installation

### Download

[Download](https://github.com/MRFD/kirby-webp/archive/master.zip) and copy the files to `/site/plugins/kirby-webp`.

### Git submodule

```bash
$ git submodule add https://github.com/MRFD/kirby-webp.git site/plugins/kirby-webp
```

### Composer

```bash
composer require MRFD/kirby-webp
```

## Usage

### Field methods

#### \$field->picture()

Converts the field to a picture tag with WebP and fallback for unsupported browsers.

```php
<?php
if ($image = $page->image('my-image.jpg')) {
    echo $image->picture('some-class', 'Image description');
}
?>
```

```html
<picture class="some-class">
  <source srcset="/your/path/my-image.webp" type="image/webp" />
  <img src="/your/path/my-image.jpg" alt="Image description" />
</picture>
```

#### \$field->webp()

Converts the field to a WebP image tag.

```php
<?php
if ($image = $page->image('my-image.jpg')) {
    echo $image->webp('some-class', 'Image description', [300, 800, 1024]);
}
?>
```

```html
<img
  src="/your/path/my-image.webp"
  srcset="
    /your/path/my-image-300.webp   300w,
    /your/path/my-image-800.webp   800w,
    /your/path/my-image-1024.webp 1024w
  "
  class="some-class"
  alt="Image description"
/>
<!-- Or when the browser does not support WebP: -->
<img
  src="/your/path/my-image.jpg"
  srcset="
    /your/path/my-image-300.jpg   300w,
    /your/path/my-image-800.jpg   800w,
    /your/path/my-image-1024.jpg 1024w
  "
  class="some-class"
  alt="Image description"
/>
```

_All arguments are optional._

It is also possible to use the [predefined srcset](https://getkirby.com/docs/reference/objects/cms/file/srcset#define-presets). For the default option use: `$image->webp('some-class', 'Image description', 'default')`.

#### \$field->isSupported()

Validates the WebP format is supported by the visitor's browser.

```php
<?php
$image = $page->image('my-image.jpg');

if ($image->isSupported()) {
    echo "Browser supports WebP! :)";
} else {
    echo "Browser doesn't support WebP.";
}
?>
```

#### \$field->backgroundImage()

Returns an image url that can be used with inline CSS, for example with background images. Based on the visitor's browser the url provides a regular or WebP format.

```php
<?php if ($image = $page->image('my-image.jpg')) : ?>
    <div style="background-image: url('<?= $image->backgroundImage() ?>')"></div>
<?php endif ?>
```

```html
<div style="background-image: url('/your/path/my-image.webp')"></div>
<!-- Or when the browser does not support WebP: -->
<div style="background-image: url('/your/path/my-image.jpg')"></div>
```

### KirbyTags

#### Picture tag

Creates an picture tag with fallback for unsupported browsers.

```markdown
(picture: myawesomepicture.jpg)
```

```markdown
(picture: myawesomepicture.jpg class: floated)
```

```markdown
(picture: myawesomepicture.jpg alt: This is an awesome picture)
```

```html
<picture class="some-class">
  <source srcset="/your/path/my-image.webp" type="image/webp" />
  <img src="/your/path/my-image.jpg" alt="Image description" />
</picture>
```

#### Image tag

Creates an image tag with WebP file. Can be a regular image, or a WebP format.

```markdown
(webp: myawesomepicture.jpg)
```

```markdown
(webp: myawesomepicture.jpg class: floated)
```

```markdown
(webp: myawesomepicture.jpg alt: This is an awesome picture)
```

```html
<img
  src="/your/path/my-image.webp"
  class="some-class"
  alt="Image description"
/>
<!-- Or when the browser does not support WebP: -->
<img src="/your/path/my-image.jpg" class="some-class" alt="Image description" />
```

## Options

### Convert on the fly

It is possible to convert images to WebP without uploading them through the panel. Add the following option to `/site/config/config.php`:

```php
# site/config/config.php

return [
  'mrfd.webp.autoconvert' => true
];
```

**Note:** Enabling this option may slow down the website. It is therefore advised to upload the images via the panel!

### Conversion options

For configuring advanced WebP conversion settings. For example:

```php
# site/config/config.php

return [
  'mrfd.webp.convert.options' => [
        'metadata' => 'all',
        'jpeg' => [
            'converters' => ['cwebp'],
        ],
        'png' => [
            'encoding' => 'auto',
            'near-lossless' => 60,
            'quality' => 85,
        ],
    ],
];
```

For all possible options, please read [this](https://github.com/rosell-dk/webp-convert/blob/master/docs/v2.0/converting/introduction-for-converting.md) and [this](https://github.com/rosell-dk/webp-convert/blob/master/docs/v2.0/converting/options.md).

## Disclaimer

This plugin is provided "as is" with no guarantee. Use it at your own risk and always test it yourself before using it in a production environment. If you find any issues, please [create a new issue](https://github.com/MRFD/kirby-webp/issues/new).

## License

Kirby WebP is open-sourced software licensed under the [MIT](https://opensource.org/licenses/MIT) license.

Copyright © 2020 [Marijn Roovers](https://www.mrfd.nl)

## Credits

- WebP Convert by [@rosell-dk](https://github.com/rosell-dk/webp-convert)
- Kirby 2 WebP [@S1SYPHOS](https://github.com/S1SYPHOS/kirby-webp)
