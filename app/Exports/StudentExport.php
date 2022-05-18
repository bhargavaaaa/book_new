<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentExport implements FromCollection , WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Student::with('standard')->get();
    }

    public function map($student) : array {
        return [
           $student->id,
           $student->name,
           isset($student->standard->name) ? $student->standard->name : '',
        ] ;
    }

    public function headings(): array
    {
        return [
            '#',
            'name',
            'standard',
        ];
    }
}
