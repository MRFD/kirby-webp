<?php

return [
    'picture' => function (string $figureClass = null, string $alt = null, string $imageClass = null) {
        // Check if webp file exists. Otherwise genereate one.
        if (!webpExists($this->extension(), $this->root())) {
            MRFD\WebP\Convert::webp($this);
        }

        // Generate webp tag.
        $webp = Html::tag('source', null, [
            'srcset' => replaceExtension($this->extension(), $this->url()),
            'type' => 'image/webp'
        ]);

        // Create img tag.
        $jpg = Html::img($this->url(), [
            'alt' => $alt,
            'class' => $imageClass
        ]);

        return Html::tag('picture', [$webp, $jpg], ['class' => $figureClass]);
    },
    'webp' => function (string $imageClass = null, string $alt = null) {
        // Check if webp file exists. Otherwise genereate one.
        if (!webpExists($this->extension(), $this->root())) {
            MRFD\WebP\Convert::webp($this);
        }

        $url = $this->isSupported() ? replaceExtension($this->extension(), $this->url()) : $this->url();

        // Create img tag.
        return Html::img($url, [
            'alt' => $alt,
            'class' => $imageClass
        ]);
    },
    'isSupported' => function () {
        return strpos(Server::get('HTTP_ACCEPT'), 'image/webp') !== false;
    },
    'backgroundImage' => function () {
        // Check if webp file exists. Otherwise genereate one.
        if (!webpExists($this->extension(), $this->root())) {
            MRFD\WebP\Convert::webp($this);
        }

        if ($this->isSupported()) {
            return replaceExtension($this->extension(), $this->url());
        }

        return $this->url();
    },
];
