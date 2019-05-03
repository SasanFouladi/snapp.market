<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'category'       => $row[1],
            'name'           => $row[2],
            'price'          => $row[3],
            'description'    => $row[4],
            'count'          => $row[5],
            'image_url'      => $row[6],
        ]);
    }
}
