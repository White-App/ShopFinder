<?php

namespace WhiteApp\Shopfinder\Api\Data;

interface ShopInterface
{
    /**
     * @return int
     */
    public function getShopId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getIdentifier();

    /**
     * @return string
     */
    public function getCountry();

    /**
     * @return string
     */
    public function getImage();

    /**
     * @return string|null
     */
    public function getLongitude();

    /**
     * @return string|null
     */
    public function getLatitude();

    /**
     * @param int $shopId
     * @return $this
     */
    public function setShopId($shopId);

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * @param string $identifier
     * @return $this
     */
    public function setIdentifier($identifier);

    /**
     * @param string $country
     * @return $this
     */
    public function setCountry($country);

    /**
     * @param string $image
     * @return $this
     */
    public function setImage($image);

    /**
     * @param string|null $longitude
     * @return $this
     */
    public function setLongitude($longitude);

    /**
     * @param string|null $latitude
     * @return $this
     */
    public function setLatitude($latitude);
}
