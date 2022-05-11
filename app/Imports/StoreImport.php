<?php

namespace App\Imports;

use App\Models\{
    Product,
    Category,
    Order,
};


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas; // if you have formulas in your excel file
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;

//  , WithChunkReading  , ShouldQueue , WithBatchInserts

class StoreImport  implements ToModel , WithHeadingRow , WithCalculatedFormulas , WithValidation , WithChunkReading  , ShouldQueue , WithBatchInserts
{
    private $products;
    

    public function __construct (){
        
        $this->products = Product::all();
        
    }
    
    public function model(array $row)
    {
        
       
        $product = $this->products->where('name', $row['product'])->first();
        

            
        return new Order([
            "region" => $row['region'],
            "city" => $row['city'],
            "product_id" => $product->id,
            "quantity" => $row['quantity'],
            "price" => $row['unitprice'],
            "total" => $row['totalprice'],
            "order_date" =>  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['orderdate']), // the date was coming in as an integer eg 20191231 so we need to convert it to a date object

        ]);
       
  
    }
    public function rules(): array
    {
        return [
            'region' => ['required'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'region.required' => 'Custom message :attribute.',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
    public function batchSize(): int
    {
        return 1000;
    }
}
