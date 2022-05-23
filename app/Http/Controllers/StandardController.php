<?php

namespace App\Http\Controllers;

use App\Models\Standard;
use finfo;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

class StandardController extends Controller
{
    public $moduleName = 'Standard';
    public $route = 'standard';
    public $view = 'standard';

    public function index()
    {
        $moduleName = $this->moduleName;
        return view($this->view . '/index', compact('moduleName'));
    }

    public function getData()
    {
        $standard = Standard::select();
        $datatables = datatables()->eloquent($standard)
        ->addColumn('action', function($row) {
            $editUrl = route('standard.edit', encrypt($row->id));
            $deleteUrl = route('standard.delete', encrypt($row->id));
            // $changeStatus = route('standard.changeStatus', encrypt($row->id));
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
        ->addColumn('checkBox', function ($row) {
            $checkBox = "<input type='checkbox' class='form-check checkBox' value='" . encrypt($row->id) . "' />";
            return $checkBox;
        })
        ->rawColumns(['action','checkBox'])
        ->addIndexColumn()
        ->make(true);

        return $datatables;
    }

    public function create()
    {
        $moduleName = $this->moduleName;
        return view($this->view . '/form', compact('moduleName'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required'
        ]);

        if($validate) {
            Standard::create([
                'name'      => $request->name,
                'is_active' => $request->is_active
            ]);

        }

        return redirect($this->route)->with("details_success", "Standard Added Successfully.");
    }

    public function edit($id)
    {
        $moduleName = $this->moduleName;
        $standard = Standard::find(decrypt($id));
        return view($this->view . '/_form', compact('moduleName','standard'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required',
        ]);

        $standard = Standard::find(decrypt($id));
        $standard->update(['name' => $request->name]);

        return redirect($this->route)->with("details_success", "Standard Update Successfully.");
    }

    public function delete($id)
    {
        $id = decrypt($id);
        $standard = Standard::find($id);
        if($standard){
            $standard->delete();
        }

        return redirect($this->route)->with("details_success", "Standard Deleted Successfully.");
    }

    public function changeStatus($id)
    {
        $standard = Standard::find(decrypt($id));
        if($standard->is_active == 0){
            $standard->update(['is_active' => 1]);
            return redirect($this->route)->with("details_success", "Standard Activate Successfully.");
        } else {
            $standard->update(['is_active' => 0]);
            return redirect($this->route)->with("details_success", "Standard InActivate Successfully.");
        }
    }

    public function bulkDelete(Request $request)
    {
        foreach ($request->standard as $item) {
            $standard = Standard::find(decrypt($item));
            $standard->delete();
        }

        return response()->json([
            'status' => true
        ]);
    }
}
