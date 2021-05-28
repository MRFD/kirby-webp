<?php

namespace MRFD\WebP;

use Exception;
use Kirby\Exception\LogicException;
use Kirby\Toolkit\F;
use WebPConvert\WebPConvert;

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
    public static function webp(object $file, array $options = []): void
    {
        try {
            if (isSupportedImage($file)) {
                $destination = replaceExtension($file->extension(), $file->root());

                // Use the conversion options, if these are specified in the plugin options.
                if (empty($options) && !empty(option('mrfd.webp.convert.options'))) {
                    $options = option('mrfd.webp.convert.options');
                }

                WebPConvert::convert($file->root(), $destination, $options);

                // Create empty template file.
                if ($file->kirby()->multilang() === true) {
                    $languageCode = $file->kirby()->defaultLanguage()->code();
                    F::write($destination . '.' . $languageCode . '.txt', '');
                } else {
                    F::write($destination . '.txt', '');
                }
            }
        } catch (Exception $exception) {
            throw new LogicException('Image cannot be converted to WebP.');
        }
    }
}
