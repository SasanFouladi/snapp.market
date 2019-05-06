<?php

namespace App;

use Elasticquent\ElasticquentTrait;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use ElasticquentTrait;

    protected $guarded = ['id'];

    protected $mappingProperties = array(
        'category' => [
            'type' => 'text',
            "analyzer" => "standard",
            "fields"=>[
                "keyword"=>[
                    "type"=>"keyword",
                    "ignore_above"=>256,
                    "index"=>"not_analyzed"
                ]
            ]
            //"Fielddata "=> true,
        ],
        'name' => [
            'type' => 'text',
            "analyzer" => "standard",
        ],
        'price' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
        'description' => [
            'type' => 'text',
            "analyzer" => "standard",
        ],
        'count' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
        'image_url' => [
            'type' => 'text',
            "analyzer" => "standard",
        ],
    );

}
