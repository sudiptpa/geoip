<?php

namespace Sujip\GeoIp;

/**
 * Class GeoIp.
 */
class GeoIp
{
    /**
     * @var mixed
     */
    protected $items;

    /**
     * @param $ip
     */
    public function __construct($ip = null)
    {
        $this->items = $this->call($ip);
    }

    /**
     * @return null
     */
    public function call($ip = null)
    {
        try {
            $response = (new Request($ip))->make();
        } catch (Forbidden $e) {
            return [];
        }

        return $response->getBody();
    }

    /**
     * @return mixed
     */
    public function ip()
    {
        return $this->resolve('ip');
    }

    /**
     * @return mixed
     */
    public function countryCode()
    {
        return $this->resolve('country_code');
    }

    /**
     * @return mixed
     */
    public function country()
    {
        return $this->resolve('country_name');
    }

    /**
     * @param $key
     * @param $default
     */
    public function resolve($key, $default = null)
    {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        }

        return $default;
    }

    /**
     * @return mixed
     */
    public function region()
    {
        return $this->resolve('region_name');
    }

    /**
     * @return mixed
     */
    public function city()
    {
        return $this->resolve('city');
    }

    public function formatted()
    {
        $address = array_filter([
            $this->city(),
            $this->region(),
            $this->country(),
        ]);

        return implode(', ', $address);
    }

    /**
     * @return mixed
     */
    public function timezone()
    {
        return $this->resolve('time_zone');
    }

    /**
     * @return mixed
     */
    public function zipcode()
    {
        return $this->resolve('zip_code');
    }

    /**
     * @return mixed
     */
    public function latitude()
    {
        return $this->resolve('latitude');
    }

    /**
     * @return mixed
     */
    public function longitude()
    {
        return $this->resolve('longitude');
    }
}
