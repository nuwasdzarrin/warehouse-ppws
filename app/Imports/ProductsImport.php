<?php

namespace App\Imports;

use App\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductsImport implements ToCollection
{
    public $institution_id;

    public function __construct($institution_id)
    {
        $this->institution_id = $institution_id;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $rules = [
            'id' => 'exists:products,id|nullable',
            'institution_id' => 'exists:institutions,id|nullable',
            'product_category_id' => 'exists:product_categories,id|nullable',
            'name' => 'required|string',
            'stock' => 'numeric|nullable',
            'noted' => 'string|nullable'
        ];

        $collection->splice(0, 2);

        $data = $collection->map(function ($row) use($rules) {
            $i = 0;
            $datum = [];
            if ($value = $row[$i++]) $datum['id'] = $value;
            $datum['institution_id'] = $this->institution_id;
            $datum['product_category_id'] = null;
            $datum['name'] = $row[$i++];
            $datum['stock'] = $row[$i++];
            $datum['noted'] = $row[$i++];
            return $datum;
        });

        $data->each(function ($datum) use($rules) {
            Validator::make($datum, $rules)->validate();

            $product = isset($datum['id']) ? Product::query()->find($datum['id']) : (new Product);
            foreach ($rules as $key => $value) {
                if (isset($datum[$key]))
                    $product->{$key} = $datum[$key];
            }
            $product->save();
        });

//        $collection->shift();
//        $collection->each(function ($item) {
//            $category_id = ProductCategory::query()->where('name', $item[2])->first()->id;
//            $institution_id = Institution::query()->where('name', $item[1])->first()->id;
//            dd(isset($item[0]));

//            $product = isset($item[0]) ? Product::query()->find($item[0]) : (new Product);
//            $product->institution_id = $institution_id;
//            $product->product_category_id = $category_id;
//            $product->name = $item[3];
//            $product->stock = $item[4];
//            $product->noted = $item[5];
//            $product->save();
//        });

//        $sproduct->save();
    }
}
