<?php

namespace MRFD\WebP;

use Exception;

use WebPConvert\WebPConvert;
use Kirby\Cms\Response;
use Kirby\Toolkit\F;

/**
 * Converter for WebP.
 */
class Convert
{
    /**
     * Convert image to WebP
     *
     * @param  object  $file    Uploaden file via CMS.
     * @param  array   $options Convert options.
     * 
     */
    public static function webp(object $file, array $options = [])
    {
        try {
            if ($file->type() == 'image') {
                $destination = replaceExtension($file->extension(), $file->root());

                // Convert image to WebP.
                WebPConvert::convert($file->root(), $destination, $options);

                // Create empty template file.
                if ($file->kirby()->multilang() === true) {
                    $languageCode = $file->kirby()->defaultLanguage()->code();
                    F::write($destination . '.' . $languageCode . '.txt', '');
                } else {
                    F::write($destination . '.txt', '');
                }
            }
        } catch (Exception $e) {
            return Response::error($e->getMessage());
        }
    }
}
