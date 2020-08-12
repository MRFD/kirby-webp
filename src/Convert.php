<?php

namespace MRFD\WebP;

use Exception;
use WebPConvert\WebPConvert;
use Kirby\Exception\LogicException;
use Kirby\Toolkit\F;

/**
 * Converter for WebP.
 */
class Convert
{
    /**
     * Convert image to WebP
     *
     * @param  object  $file    Uploaded file via CMS.
     * @param  array   $options Convert options.
     * 
     */
    public static function webp(object $file, array $options = [])
    {
        try {
            if ($file->type() == 'image' && in_array($file->extension(), ['jpg', 'jpeg', 'png'])) {
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
            throw new LogicException('Image cannot be converted to WebP.');
        }
    }
}
