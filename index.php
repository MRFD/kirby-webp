<?php

/**
 * Kirby 3 WebP
 *
 * @version   0.1.2
 * @author    Marijn Roovers <marijn@mrfd.nl>
 * @copyright Marijn Roovers <marijn@mrfd.nl>
 * @link      https://github.com/mrfd/kirby-webp
 * @license   MIT
 */

@include_once __DIR__ . '/vendor/autoload.php';

/**
 * Replace file extension with WebP.
 *
 * @param   string  $extension  File extension parent file
 * @param   string  $path       Name or path of file
 *
 * @return  string              Returns filename or path with WebP extension
 */
function replaceExtension(string $extension, string $path): string
{
    return str_replace($extension, 'webp', $path);
}

/**
 * Checks if WebP variant of parent file exists.
 *
 * @param   string  $extension  File extension parent file
 * @param   string  $path       File path
 *
 * @return  bool              Returns true if the file exists; false otherwise.
 */
function webpExists(string $extension, string $path): bool
{
    return file_exists(replaceExtension($extension, $path));
}

Kirby::plugin('mrfd/webp', [
    'hooks' => require_once __DIR__ . '/src/hooks.php',
    'fileMethods' => require_once __DIR__ . '/src/filemethods.php',
    'tags' => require_once __DIR__ . '/src/tags.php',
    'options' => [
        'autoconvert' => false
    ]
]);
