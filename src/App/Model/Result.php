<?php


namespace App\Model;


class Result
{
    /**
     * @var Product[]
     */
    private $items;

    /**
     * @return Product[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Product[] $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * Return Array Representation of an object
     *
     * @return array
     */
    public function toArray()
    {
        $resultArray = [];
        $total = 0;
        foreach ($this->items as $item) {
            $resultArray[] = $item->toArray();
            $total += $item->getUnitPrice();
        }
        return [
            'results' => $resultArray,
            'total' => number_format((float) $total, 2)
        ];
    }
}