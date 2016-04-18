<?php


namespace App\Model;


class Product
{
    /**
     * Product Title
     *
     * @var string
     */
    private $title;

    /**
     * Price per unit
     *
     * @var float
     */
    private $unitPrice;

    /**
     * Single Product page size
     *
     * @var float
     */
    private $size;

    /**
     * Product Description
     *
     * @var string
     */
    private $description;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = trim($title);
    }

    /**
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @param float $unitPrice
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return float
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param float $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Return Array Representation of an object
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'title' => $this->title,
            'size' => $this->size . 'kb',
            'unit_price' => $this->unitPrice,
            'description' => $this->description
        ];
    }
}