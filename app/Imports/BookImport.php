<?php

namespace App\Imports;

use App\Models\Book;
use App\Models\Medium;
use App\Models\Standard;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BookImport implements ToModel, WithStartRow
{
    public function model(array $row)
    {
        $standard = explode(",", trim($row[1]));
        if(!empty($standard)) {
            $standard_id = Standard::whereIn('name',$standard)->pluck('id')->toArray();
        }

        $medium = explode(",",trim($row[2]));
        if(!empty($medium)){
            $medium_id = Medium::whereIn('name',$medium)->pluck('id')->toArray();
        }

        $book = Book::create([
            'name' => trim($row[0]),
            'price' => trim($row[3]),
            'qty' => trim($row[4]),
            'discount' => trim($row[5]),
            'discount_type' => (trim($row[6]) == "fixed" ||  trim($row[6]) == "Fixed") ? 0 : 1,
            'book_status' => (trim($row[7]) == "available" ||  trim($row[7]) == "Available") ? 1 : 0,
        ]);

        $book->standard()->sync($standard_id);
        $book->medium()->sync($medium_id);
        // return new Book([
        //     //
        // ]);
    }

    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
            '1' => 'required',
            '2' => 'required',
            '3' => 'required',
            '4' => 'required',
            '5' => 'required',
            '6' => 'required',
            '7' => 'required',
            '8' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '1.required' => 'Student Name Is Required.',
            '2.required' => 'Standard Is Required.',
        ];
    }
}
