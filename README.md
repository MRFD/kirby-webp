# 🖼 Kirby 3 WebP

This plugin for [Kirby 3](https://getkirby.com) provides automatic WebP conversion when uploading images via the Panel. With provisions for the use of field methods, KirbyTags and multi-language sites.

**Note:** When using the field methods and KirbyTags the WebP image will be automatically generated when missing. In addition the WebP image will also be removed when the original image is removed via the Panel.

## Requirements

- PHP 5.6+
- Kirby 3

## Installation

### Download

[Download](https://github.com/MRFD/kirby-webp/archive/master.zip) and copy the files to `/site/plugins/kirby-webp`.

### Git submodule

```bash
$ git submodule add https://github.com/MRFD/kirby-webp.git site/plugins/kirby-webp
```

### Composer

```
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
    echo $image->webp('some-class', 'Image description');
}
?>
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

## License

Kirby WebP is open-sourced software licensed under the MIT license.

Copyright © 2020 [Marijn Roovers](https://www.mrfd.nl)

## Credits

- WebP Convert by [@rosell-dk](https://github.com/rosell-dk/webp-convert)
- Kirby 2 WebP [@S1SYPHOS](https://github.com/S1SYPHOS/kirby-webp)
