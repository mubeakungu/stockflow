<?php

namespace App\Support;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class QrCode
{
    /**
     * Render $text as an inline SVG QR code, $size pixels square.
     */
    public static function svg(string $text, int $size = 160): string
    {
        $writer = new Writer(new ImageRenderer(new RendererStyle($size, 1), new SvgImageBackEnd()));

        // Drop the XML declaration so the SVG can be embedded in HTML.
        return preg_replace('/^<\?xml[^>]*\?>\s*/', '', $writer->writeString($text));
    }

    /**
     * Same QR code as a data: URI, for <img> tags (DomPDF needs this form).
     */
    public static function dataUri(string $text, int $size = 160): string
    {
        return 'data:image/svg+xml;base64,' . base64_encode(self::svg($text, $size));
    }
}
