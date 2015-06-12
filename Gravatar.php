<?php namespace NetForce\Gravatar;

class Gravatar
{
    protected $default_image = 'identicon';
    protected $default_size  = 80;
    protected $default_rate  = 'g';
    protected $securityUrl   = false;
    protected $cache         = [];

    protected $urls = [
        true  => 'https://secure.gravatar.com/avatar/',
        false => 'http://www.gravatar.com/avatar/',
    ];

    public function __construct()
    {
        // Carregar configuracoes
        $this->default_image = config('gravatar::defaultImage', $this->default_image);
        $this->default_size  = config('gravatar::size',         $this->default_size);
        $this->default_rate  = config('gravatar::rate',         $this->default_rate);
        $this->securityUrl   = config('gravatar::security',     $this->securityUrl);
    }

    /**
     * Monta URL do Gravatar
     * @param $email
     * @param null $size
     * @param null $rating
     * @return string
     */
    public function src($email, $size = null, $rating = null, $defaultImage = null)
    {
        // Verificar se esta em cache
        $id_cache = sprintf('%s.%s.%s', $email, $size, $rating);
        if (array_key_exists($id_cache, $this->cache))
        {
            return $this->cache[$id_cache];
        }

        // Padroes
        $size         = is_null($size) ? $this->default_size : $size;
        $rating       = is_null($rating) ? $this->default_rate : $rating;
        $defaultImage = is_null($defaultImage) ? $this->default_image : $defaultImage;

        // Tratar tamanho minimo e maximo
        $size = max(1, min(512, $size));

        // Montar URL
        $url  = $this->urls[$this->securityUrl];
        $url .= md5(strtolower(trim($email)));
        $url .= sprintf('?s=%s', $size);
        $url .= sprintf('?r=%s', $rating);
        $url .= sprintf('?d=%s', $defaultImage);
        $src  = htmlentities($url);

        // Salvar no cache
        $this->cache[$id_cache] = $src;

        // Retornar
        return $src;
    }
}