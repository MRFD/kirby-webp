<?php

namespace MRFD\WebP;

use Kirby\Toolkit\F;

return [
    'file.create:after' => function ($file): void {
        Convert::webp($file);

        return;
    },
    'file.delete:after' => function ($status, $file): void {
        if ($file->type() == 'image' && $status === true) {
            if ($webp = page()->file(replaceExtension($file->extension(), $file->filename()))) {

                if ($webp->kirby()->multilang() === true) {
                    foreach ($webp->translations() as $translation) {
                        F::remove($webp->contentFile($translation->code()));
                    }
                } else {
                    F::remove($webp->contentFile());
                }

                F::remove($webp->root());

                return;
            }

            return;
        }

        return;
    }
];
