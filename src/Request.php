<?php

namespace Sujip\GeoIp;

use Exception;
use Sujip\GeoIp\Exception\Forbidden;

/**
 * @author Sujip Thapa <support@sujipthapa.co>
 */
class Request
{
    /**
     * @var string
     */
    protected $ip;

    /**
     * @var string
     */
    protected $key;

    /**
     * @param $ip
     */
    public function __construct($ip = null, $key)
    {
        $this->ip = $ip;
        $this->key = env('KEY'); //Please, configure your on .env file
    }

    /**
     * @return null
     */
    public function make()
    {
        if (empty($this->ip)) {
            $this->throwException('No IP or hostname is provided', 403);
        }

        try {
            $response = file_get_contents(
                sprintf('http://api.ipstack.com/%s?access_key=%s', $this->ip, $this->key)
            );
        } catch (Exception $e) {
            $this->throwException('Forbidden', 403);
        }

        return new Response($response);
    }

    /**
     * @param $message
     * @param $code
     */
    public function throwException($message, $code = 400)
    {
        throw new Forbidden($message, $code);
    }
}
