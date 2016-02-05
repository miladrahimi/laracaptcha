<?php namespace MiladRahimi\LaraCaptcha;

use MiladRahimi\LaraCaptcha\Exceptions\InvalidArgumentException;
use Session;

/**
 * Class Captcha
 * Captcha class draws the captcha images
 *
 * @package MiladRahimi\LaraCaptcha
 * @author  Milad Rahimi "info@miladrahimi.com"
 */
class Captcha
{

    /**
     * URL for captcha image source
     *
     * @var string
     */
    private $route = '/laracaptcha.png';

    /**
     * Draw the captcha image
     */
    public function draw()
    {
        // Set header to PNG image
        header("Content-Type: image/png");
        // Start image canvas
        $image = imagecreatefrompng(__DIR__ . "/../../../res/bg.png");
        // Allocate colors
        $text_color = imagecolorallocate($image, 0, 0, 0);
        // Generate code and put it into the image
        $random_string = rand();
        $random_string = base64_encode(md5($random_string));
        $random_string = substr($random_string, 0, 6);
        $random_string = str_replace(['0', 'o', 'O'], 'x', $random_string);
        // function image-string($image, $font_size, $x_pos, $y_pos, $random_string, $color);
        imagestring($image, 8, 43, 11, $random_string, $text_color);
        // Output image and free up memory
        imagepng($image);
        imagedestroy($image);
        // Save random string in session
        Session::put('laraCaptcha', strtoupper($random_string));
    }

    /**
     * Get captcha image URL
     *
     * @return string
     */
    public function getUrl()
    {
        return url($this->route);
    }

    /**
     * Get captcha image "RANDOM" URL
     *
     * @return string
     */
    public function getRandomUrl()
    {
        return url($this->route . '?r=' . str_random(32));
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $route
     */
    public function setRoute($route)
    {
        if (!isset($route) && !is_string($route)) {
            throw new InvalidArgumentException('Route must be an string value');
        }
        $this->route = $route;
    }
}