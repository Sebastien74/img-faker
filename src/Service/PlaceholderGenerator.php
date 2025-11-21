<?php

namespace FakeImgBundle\Service;

use Symfony\Component\HttpFoundation\Response;

/**
 * Generate WebP placeholder images from a tag like "fakeimg-360x500"
 */
class PlaceholderGenerator
{
    private string $backgroundColorHex;
    private string $textColorHex;
    private int $maxWidth;
    private int $maxHeight;

    /**
     * Constructor
     *
     * @param string $backgroundColorHex Background color in hex format without "#"
     * @param string $textColorHex Text color in hex format without "#"
     * @param int $maxWidth Maximum allowed width
     * @param int $maxHeight Maximum allowed height
     */
    public function __construct(
        string $backgroundColorHex,
        string $textColorHex,
        int $maxWidth,
        int $maxHeight
    ) {
        $this->backgroundColorHex = $backgroundColorHex;
        $this->textColorHex      = $textColorHex;
        $this->maxWidth          = $maxWidth;
        $this->maxHeight         = $maxHeight;
    }

    /**
     * Generate a placeholder image from a tag like "fakeimg-360x500"
     *
     * @param string $tag
     *
     * @return Response
     */
    public function generateFromTag(string $tag): Response
    {
        if (!preg_match('/^fakeimg-(\d+)x(\d+)$/', $tag, $matches)) {
            return new Response('Invalid image tag format. Expected fakeimg-{width}x{height}.', 400);
        }

        $width  = (int) $matches[1];
        $height = (int) $matches[2];

        if (
            $width <= 0
            || $height <= 0
            || $width > $this->maxWidth
            || $height > $this->maxHeight
        ) {
            return new Response('Invalid image dimensions.', 400);
        }

        if (!function_exists('imagewebp')) {
            return new Response('WebP is not supported by the GD extension.', 500);
        }

        $image = imagecreatetruecolor($width, $height);

        if (!$image) {
            return new Response('Unable to create image.', 500);
        }

        [$bgR, $bgG, $bgB]   = $this->hexToRgb($this->backgroundColorHex);
        [$txtR, $txtG, $txtB] = $this->hexToRgb($this->textColorHex);

        $bgColor   = imagecolorallocate($image, $bgR, $bgG, $bgB);
        $textColor = imagecolorallocate($image, $txtR, $txtG, $txtB);

        imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);

        $text = sprintf('%dx%d', $width, $height);

        $font       = 5;
        $textWidth  = imagefontwidth($font) * strlen($text);
        $textHeight = imagefontheight($font);

        $x = (int) (($width  - $textWidth) / 2);
        $y = (int) (($height - $textHeight) / 2);

        imagestring($image, $font, $x, $y, $text, $textColor);

        ob_start();
        imagewebp($image, null, 80);
        imagedestroy($image);
        $content = ob_get_clean();

        $response = new Response($content, 200, [
            'Content-Type'  => 'image/webp',
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);

        return $response;
    }

    /**
     * Convert hex color to RGB components
     *
     * @param string $hex
     *
     * @return array{0:int,1:int,2:int}
     */
    private function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');

        if (strlen($hex) === 3) {
            $hex = sprintf('%s%s%s%s%s%s',
                $hex[0],
                $hex[0],
                $hex[1],
                $hex[1],
                $hex[2],
                $hex[2]
            );
        }

        $int = hexdec($hex);

        return [
            ($int >> 16) & 255,
            ($int >> 8) & 255,
            $int & 255,
        ];
    }
}
