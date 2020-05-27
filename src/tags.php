<?php

use Kirby\Cms\Html;
use Kirby\Cms\Url;

return [
    'picture' => [
        'attr' => [
            'class',
            'alt'
        ],
        'html' => function ($tag) {
            $class = $tag->class ?? null;
            $alt = $tag->alt ?? null;

            if ($file = $tag->file($tag->value)) {
                return $file->picture($class, $alt);
            }

            // Fallback for non-existent file.
            $url = Url::to($tag->value);

            $jpg = Html::img($url, [
                'alt' => $alt
            ]);

            return Html::tag('picture', [$jpg], ['class' => $class]);
        }
    ],
    'webp' => [
        'attr' => [
            'class',
            'alt'
        ],
        'html' => function ($tag) {
            $class = $tag->class ?? null;
            $alt = $tag->alt ?? null;

            if ($file = $tag->file($tag->value)) {
                return $file->webp($class, $alt);
            }

            // Fallback for non-existent file.
            $url = Url::to($tag->value);

            return Html::img($url, [
                'alt' => $alt,
                'class' => $class
            ]);
        }
    ],
];
