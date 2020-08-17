<?php

namespace MRFD\WebP;

use Kirby\Toolkit\F;

return [
    'file.create:after' => function ($file): void {
        Convert::webp($file);
    },
    'file.delete:after' => function ($status, $file): void {
        if (isSupportedImage($file) && $status === true) {
            if ($webp = $file->toWebpFile()) {

                if ($webp->kirby()->multilang() === true) {
                    foreach ($webp->translations() as $translation) {
                        F::remove($webp->contentFile($translation->code()));
                    }
                } else {
                    F::remove($webp->contentFile());
                }

                F::remove($webp->root());
            }
        }
    },
    'file.changeName:after' => function ($newFile, $oldFile): void {
        if ($oldWebp = $oldFile->toWebpFile()) {

            $newWebp = $oldWebp->clone([
                'filename' => $newFile->name() . '.' . $oldWebp->extension(),
            ]);

            if ($lock = $oldWebp->lock()) {
                $lock->remove();
            }

            $oldWebp->unpublish();

            F::move($oldWebp->root(), $newWebp->root());

            if ($newWebp->kirby()->multilang() === true) {
                foreach ($newWebp->translations() as $translation) {
                    $translationCode = $translation->code();

                    F::move($oldWebp->contentFile($translationCode), $newWebp->contentFile($translationCode));
                }
            } else {
                F::move($oldWebp->contentFile(), $newWebp->contentFile());
            }
        }
    },
    'file.replace:after' => function ($newFile, $oldFile): void {
        if (isSupportedImage($newFile)) {

            // Convert new replacement image to WebP.
            if ($webp = $oldFile->toWebpFile()) {
                F::remove($webp->root());
            }

            Convert::webp($newFile);
        }
    }
];
