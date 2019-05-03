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

    /*protected $indexSettings = [
        'analysis' => [
            'char_filter' => [
                'replace' => [
                    'type' => 'mapping',
                    'mappings' => [
                        '&=> and '
                    ],
                ],
            ],
            'filter' => [
                'word_delimiter' => [
                    'type' => 'word_delimiter',
                    'split_on_numerics' => false,
                    'split_on_case_change' => true,
                    'generate_word_parts' => true,
                    'generate_number_parts' => true,
                    'catenate_all' => true,
                    'preserve_original' => true,
                    'catenate_numbers' => true,
                ]
            ],
            'analyzer' => [
                'default' => [
                    'type' => 'custom',
                    'char_filter' => [
                        'html_strip',
                        'replace',
                    ],
                    'tokenizer' => 'whitespace',
                    'filter' => [
                        'lowercase',
                        'word_delimiter',
                    ],
                ],
            ],
        ],
    ];*/
}
