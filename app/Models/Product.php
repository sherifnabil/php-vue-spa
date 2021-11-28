<?php

namespace App\Models;

class Product
{
    protected $id;
    protected $name;
    protected $sku;
    protected $price;
    protected $type;
    protected $attributes;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function create(array $data)
    {
    }

    public function delete(int $id)
    {
    }
}
