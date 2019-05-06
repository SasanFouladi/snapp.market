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
//        Product::putMapping($ignoreConflicts = true);
        $products = Product::complexSearch(
                [
                    "body"=>[
                        "aggs"=>[
                            'categories'=>[
                                "terms"=>[
                                    'field'=>'category.keyword',
                                    'size'=>50,
                                ]
                            ]
                        ]
                    ]
                ]
        )->toArray();
        $products = Product::searchByQuery(
                '',
                [
                    'categories'=>[
                        "terms"=>[
                            'field'=>'category.keyword',
                            'size'=>50,
                        ]
                    ]
                ]
        );
        $categories = $products->getAggregations()['categories']['buckets'];
        return $this->success('',$categories);
    }

    public function getCategoryItems(Request $request)
    {
        $products = Product::searchByQuery(['match' => ['category' => $request->get('category')]])->toArray();
        return $this->success('',$products);
    }

    public function search(Request $request)
    {
        $searchKey = "*".$request->get('q')."*";

        //dd($searchKey);
        $products = Product::searchByQuery(
            [
                "bool"=>[
                    "should"=>[
                        [   "query_string"=>[
                                "default_field"=>"name",
                                "query"=>$searchKey
                            ]
                        ],
                        ['match' => [
                                'category' => [
                                    "query"=> $request->get('q'),
                                    "boost"=>2
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        )->toArray();
        return $this->success('',$products);
    }

}