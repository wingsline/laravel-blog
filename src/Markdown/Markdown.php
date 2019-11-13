<?php

namespace Wingsline\Blog\Markdown;

use Intervention\Image\ImageManager;
use Michelf\MarkdownExtra;

class Markdown extends MarkdownExtra
{
    /**
     * High Pixel density descriptor.
     */
    const HIGH_PIXEL_DENSITY = '2x';

    /**
     * Above this size we consider the image high ppi.
     */
    const MAX_POINT_PER_INCH = 96;

    /**
     * Add srcset for the locally stored image.
     *
     * @param string $url
     */
    public function addSrcSet($url): string
    {
        $result = ' srcset="' . $url;

        // for local images we expand to the full path

        if (is_file(public_path($url))) {
            $image_url = public_path($url);
        } else {
            $image_url = url($url);
        }

        $result .= $this->getImagePixelDensity($image_url);
        $result .= '"';

        return $result;
    }

    /**
     * Converts markdown to html.
     */
    public function convertToHtml(string $markdown): string
    {
        return static::defaultTransform($markdown);
    }

    /**
     * Static method to convert markdown to html.
     *
     * @return string
     */
    public static function convertWithParser(string $markdown)
    {
        $method = config('blog.markdown_parser.method');

        return app(config('blog.markdown_parser.class'))
            ->{$method}($markdown);
    }

    /**
     * Returns 2x if the image is high pixel density.
     *
     * @param string $image_url
     *
     * @return string
     */
    public function getImagePixelDensity($image_url)
    {
        // Currently we support only imagick
        if (!\extension_loaded('imagick')) {
            return '';
        }

        try {
            $manager = new ImageManager(['driver' => 'imagick']);
            $img = $manager->make($image_url)->getCore();
        } catch (\Exception $e) {
            return '';
        }

        $unit = $img->getImageUnits();
        $resolution = array_sum($img->getImageResolution());

        // Based on the units we determine if the image is high dpi. If no
        // resolution is set, we default to high dpi, since imagick cannot
        // reliably detect for example phone screenshot resolutions.
        $pixel_density = ' ';

        switch ($unit) {
            case \imagick::RESOLUTION_PIXELSPERINCH:
                $max_resolution = (static::MAX_POINT_PER_INCH * 2);
                $pixel_density .= $resolution > $max_resolution ? static::HIGH_PIXEL_DENSITY : '';

                break;
            case \imagick::RESOLUTION_PIXELSPERCENTIMETER:
                $max_resolution = (static::MAX_POINT_PER_INCH * 2) / 2.54;
                $pixel_density .= $resolution > $max_resolution ? static::HIGH_PIXEL_DENSITY : '';

                break;
            default:
                $pixel_density .= static::HIGH_PIXEL_DENSITY;

                break;
        }

        return rtrim($pixel_density);
    }

    /**
     * Callback for inline images.
     *
     * @param array $matches
     *
     * @return string
     */
    protected function _doImages_inline_callback($matches)
    {
        $whole_match = $matches[1];
        $alt_text = $matches[2];
        $url = '' == $matches[3] ? $matches[4] : $matches[3];
        $title = &$matches[7];
        $attr = $this->doExtraAttributes('img', $dummy = &$matches[8]);

        $alt_text = $this->encodeAttribute($alt_text);
        $url = $this->encodeURLAttribute($url);
        $result = "<img src=\"${url}\" alt=\"${alt_text}\"";
        if (isset($title)) {
            $title = $this->encodeAttribute($title);
            $result .= " title=\"${title}\""; // $title already quoted
        }
        $result .= $attr;
        // srcset
        $result .= $this->addSrcSet($url);
        $result .= $this->empty_element_suffix;

        return $this->hashPart($result);
    }

    /**
     * Callback for referenced images.
     *
     * @param array $matches
     *
     * @return string
     */
    protected function _doImages_reference_callback($matches)
    {
        $whole_match = $matches[1];
        $alt_text = $matches[2];
        $link_id = strtolower($matches[3]);

        if ('' == $link_id) {
            $link_id = strtolower($alt_text); // for shortcut links like ![this][].
        }

        $alt_text = $this->encodeAttribute($alt_text);
        if (isset($this->urls[$link_id])) {
            $url = $this->encodeURLAttribute($this->urls[$link_id]);
            $result = "<img src=\"${url}\" alt=\"${alt_text}\"";
            if (isset($this->titles[$link_id])) {
                $title = $this->titles[$link_id];
                $title = $this->encodeAttribute($title);
                $result .= " title=\"${title}\"";
            }
            if (isset($this->ref_attr[$link_id])) {
                $result .= $this->ref_attr[$link_id];
            }
            // srcset
            $result .= $this->addSrcSet($url);
            $result .= $this->empty_element_suffix;
            $result = $this->hashPart($result);
        } else {
            // If there's no such link ID, leave intact:
            $result = $whole_match;
        }

        return $result;
    }
}
