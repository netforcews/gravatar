<?php namespace NetForce\Gravatar;

use \Config;
use Illuminate\Support\Facades\HTML;

class Gravatar extends GravatarLib
{
    private   $default_size = null;
    protected $cache        = [];

    public function __construct()
    {
        // Enable secure images by default

        $this->setDefaultImage(Config::get('gravatar::default', 'identicon'));
        $this->default_size = Config::get('gravatar::size', 80);

        $this->setMaxRating(Config::get('gravatar::maxRating', 'g'));
        $this->enableSecureImages();
    }

    public function src($email, $size = null, $rating = null)
    {
        $id_cache = sprintf('%s.%s.%s', $email, $size, $rating);

        // Verificar se esta em cache
        if (array_key_exists($id_cache, $this->cache))
            return $this->cache[$id_cache];

        if (is_null($size)) {
            $size = $this->default_size;
        }

        $size = max(1, min(512, $size));

        $this->setAvatarSize($size);

        if (!is_null($rating)) $this->setMaxRating($rating);

        // Gerar URL
        $src = htmlentities($this->buildGravatarURL($email));

        // Salvar no cache
        $this->cache[$id_cache] = $src;

        // Retornar
        return $src;
    }

    public function image($email, $alt = null, $attributes = array(), $rating = null)
    {
        $dimensions = array();

        if (array_key_exists('width', $attributes)) $dimensions[] = $attributes['width'];
        if (array_key_exists('height', $attributes)) $dimensions[] = $attributes['height'];

        $max_dimension = (count($dimensions)) ? min(512, max($dimensions)) : $this->default_size;

        $src = $this->src($email, $max_dimension, $rating);

        if (!array_key_exists('width', $attributes) && !array_key_exists('height', $attributes)) {
            $attributes['width'] = $this->size;
            $attributes['height'] = $this->size;
        }

        return HTML::image($src, $alt, $attributes);
    }

    public function exists($email)
    {
        $this->setDefaultImage('404');

        $url = $this->buildGravatarURL($email);
        $headers = get_headers($url, 1);

        return strpos($headers[0], '200') ? true : false;
    }
}