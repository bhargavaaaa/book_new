<?php

namespace App\Http\Controllers;

use App\Exports\StudentExport;
use App\Imports\StudentImport;
use App\Models\Standard;
use App\Models\Student;
use Excel;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public $moduleName = 'Student';
    public $route = 'student';
    public $view = 'student';

    public function index()
    {
        $moduleName = $this->moduleName;
        return view($this->view . '/index', compact('moduleName'));
    }

    public function getData()
    {
        $student = Student::with('standard')->select();
        $datatables = datatables()->eloquent($student)
        ->addColumn('action', function($row) {
            $editUrl = route('student.edit', encrypt($row->id));
            $deleteUrl = route('student.delete', encrypt($row->id));
            // $changeStatus = route('student.changeStatus', encrypt($row->id));
            $action = '';

            $action .= "<a href='" . $editUrl . "' class='btn btn-warning btn-xs'><i class='fas fa-pencil-alt'></i> Edit</a>";
            $action .= " <a id='delete' href='". $deleteUrl ."' class='btn btn-danger btn-xs delete'><i class='fa fa-trash'></i> Delete</a>";
            // if ($row->is_active == '0') {
            //     $action .= " <a id='activate' href='". $changeStatus ."' class='btn btn-success btn-xs activeUser'><i class='fa fa-check'></i> Activate</a>";
            // } else {
            //     $action .= " <a id='deactivate' href='". $changeStatus ."' class='btn btn-danger btn-xs inactiveUser'><i class='fa fa-times'></i> Deactivate</a>";
            // }
            return $action;

        })
        ->editColumn('standard', function($row) {
            return $row->standard->name ?? null;
        })
        ->rawColumns(['action','standard'])
        ->addIndexColumn()
        ->make(true);

        return $datatables;
    }

    public function create()
    {
        $moduleName = $this->moduleName;
        $standard = Standard::active()->get();
        return view($this->view . '/form', compact('moduleName','standard'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'standard' => 'required'
        ]);

        if($validate) {
            Student::create(['name' => $request->name, 'standard_id' => $request->standard]);
        }

        return redirect($this->route)->with("details_success", "Student Added Successfully.");

    }

    public function edit($id)
    {
        $moduleName = $this->moduleName;
        $standard = Standard::active()->get();
        $student = Student::with('standard')->find(decrypt($id));
        return view($this->view . '/_form', compact('moduleName','standard','student'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required',
            'standard' => 'required'
        ]);

        $student = Student::find(decrypt($id));
        $student->update(['name' => $request->name, 'standard_id' => $request->standard]);

        return redirect($this->route)->with("details_success", "Student Update Successfully.");
    }

    public function delete($id)
    {
        $id = decrypt($id);
        $student = Student::find($id);
        if($student){
            $student->delete();
        }

        return redirect($this->route)->with("details_success", "Student Deleted Successfully.");
    }

    public function import(Request $request)
    {
        $validate = $request->validate(['file' => 'required']);
        if($validate) {

            Excel::import(new StudentImport,request()->file('file'));
        }

        return redirect($this->route)->with("details_success", "Student Data Imported Successfully.");

    }

    public function export()
    {
        return Excel::download(new StudentExport, 'users.xlsx');
    }

    public function changeStatus($id)
    {
        $student = Student::find(decrypt($id));
        if($student->is_active == 0){
            $student->update(['is_active' => 1]);
            return redirect($this->route)->with("details_success", "Student Activate Successfully.");
        } else {
            $student->update(['is_active' => 0]);
            return redirect($this->route)->with("details_success", "Student InActivate Successfully.");
        }
    }
}
