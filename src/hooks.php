<?php

return [
    'file.create:after' => function ($file) {
        MRFD\WebP\Convert::webp($file);

        return true;
    },
    'file.delete:after' => function ($status, $file) {
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

                return true;
            }

            return false;
        }
    }
];
