<?php

namespace App\Imports;

use App\Models\Standard;
use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentImport implements ToModel
{
    public function model(array $row)
    {
        if($row[2]) {
            $standard = Standard::where('name','=',trim($row[2]))->first();
        }

        return new Student([
            'name'     => $row[1],
            'standard_id'    => $standard->id,
        ]);

    }
}
