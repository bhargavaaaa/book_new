<?php

namespace App\Exports;

use App\Models\Book;
use App\Models\Medium;
use App\Models\Standard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Book::with(['standard','medium'])->get();
    }

    public function map($book) : array {

        $standard_ids = array();
        foreach($book->standard as $standard){
            array_push($standard_ids,$standard->id);
        }

        $standard = Standard::whereIn('id',$standard_ids)->pluck('name')->toArray();

        $medium_ids = array();
        foreach($book->medium as $medium){
            array_push($medium_ids,$medium->id);
        }

        $medium = Medium::whereIn('id',$medium_ids)->pluck('name')->toArray();

        return [
           $book->name,
           implode(',',$standard),
           implode(',',$medium),
           $book->price,
           $book->qty,
           $book->discount,
           ($book->discount_type == 0) ? "Fixed" : "Percentage",
           ($book->book_status == 0) ? "Not Available" : "Available"
        ] ;
    }

    public function headings(): array
    {
        return [
            'name',
            'standard',
            'medium',
            'price',
            'qty',
            'discount',
            'discount_type',
            'book_status',
        ];
    }
}
