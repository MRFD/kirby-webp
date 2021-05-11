<?php

namespace MRFD\WebP;

use Kirby\Cms\Html;
use Kirby\Http\Server;

return [
    'toWebpFile' => function () {
        if (!webpExists($this->extension(), $this->root()) && option('mrfd.webp.autoconvert')) {
            Convert::webp($this);

            // Return original file, while converting to webp.
            return $this;
        }

        if (!webpExists($this->extension(), $this->root())) {
            return $this;
        }

        $id = replaceExtension($this->extension(), $this->id());
        return site()->image($id);
    },
    'webpObject' => function (): object {
        if (!$this->isSupported()) {
            return $this;
        }

        return $this->toWebpFile();
    },
    'picture' => function (?string $figureClass = null, ?string $alt = null, ?string $imageClass = null): string {
        // Generate webp tag.
        $webp = Html::tag('source', null, [
            'srcset' => $this->webpObject()->url(),
            'type' => 'image/webp'
        ]);

        // Create img tag.
        $jpg = Html::img($this->url(), [
            'alt' => $alt,
            'class' => $imageClass
        ]);

        return Html::tag('picture', [$webp, $jpg], ['class' => $figureClass]);
    },
    'webp' => function (?string $imageClass = null, ?string $alt = null, $srcset = null): string {
        $image = $this->webpObject();

        $attr = [
            'alt' => $alt,
            'class' => $imageClass,
        ];

        if ($srcset !== null) {
            $attr['srcset'] = $image->srcset($srcset);
        }

        // Create img tag.
        return Html::img($image->url(), $attr);
    },
    'isSupported' => function (): bool {
        return strpos(Server::get('HTTP_ACCEPT'), 'image/webp') !== false;
    },
    'backgroundImage' => function (): string {
        return $this->webpObject()->url();
    },
    'srcsetWebp' => function ($sizes = null): ?string {
        return $this->webpObject()->srcset($sizes);
    }
];
