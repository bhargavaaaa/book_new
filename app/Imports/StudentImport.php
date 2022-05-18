<?php

namespace App\Imports;

use App\Models\Standard;
use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentImport implements ToModel , WithStartRow, WithValidation
{
    public function model(array $row)
    {
        if($row[2]) {
            $standard = Standard::where('name','=',trim($row[2]))->first();
        }

        if($standard != null) {
            Student::updateOrCreate(['name' => trim($row[1]), 'standard_id' => $standard->id],['name' => trim($row[1]), 'standard_id' => $standard->id]);
        } else {
            Student::updateOrCreate(['name' => trim($row[1]), 'standard_id' => null],['name' => trim($row[1]), 'standard_id' => null]);
        }
        // return new Student([
        //     'name'     => $row[1],
        //     'standard_id'    => $standard->id,
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
            '2' => 'required'
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
