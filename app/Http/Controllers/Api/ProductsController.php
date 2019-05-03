<?php

namespace App\Http\Controllers\Api;

use App\Imports\ProductsImport;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Matrix\Exception;

class ProductsController extends Controller
{

    public function create(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'excel_file' => 'required|file',//mimes:xlsx,xls
        ]);

        if($validation->fails()){
            return $this->error($validation->errors()->first());
        }
        try{
           Excel::import(new ProductsImport, $request->file('excel_file'));

        }catch (Exception $exception){
            return $this->error($exception->getMessage());
        }
        if (!$request->get('add_to_elastic_search')){
            return $this->success('added excel data to mysql Database');
        }

        $products = Product::all();
        $products->addToIndex();

        return $this->success('added excel data to mysql Database and elastic search');

    }

    public function getCategories()
    {
        //echo 'here'; die;
        //Product::putMapping($ignoreConflicts = true);
        $articles = Product::searchByQuery(
            ''
            ,
            [
                'categories'=>[
                    "terms"=>[
                        'field'=>'category',
                        "size"=> 12
                    ]
                ]
            ],
            ['category'],100
        );
        return $this->success('',$articles);
    }

    public function getCategoryItems(Request $request)
    {
        $products = Product::searchByQuery(['match' => ['category' => $request->get('category')]])->toArray();
        return $this->success('',$products);
    }

    public function search(Request $request)
    {
        $searchKey = $request->get('q');
        $products = Product::searchByQuery(
            [
                'multi_match' => [
                    "query"=>$searchKey,
                    "fields"=>[
                        'name',
                        'category^2'
                    ],
                    "operator"=> "or"
                ]
            ]
        )->toArray();
        return $this->success('',$products);
    }

}

/**
 *              ,
[
"bool"=>[
"must"=> [
"match"=> [
"name"=> [
"query"=>    $searchKey,
//"operator"=> "and"
]
]
],
"should"=> [
[
"match"=> [
"name"=> [
"query"=> $searchKey,
"boost"=> 3
]
]
],
[
"match"=> [
"category"=> [
"query"=> $searchKey,
"boost"=> 2
]
]
]
]

]
]
 */