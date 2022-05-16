<?php

namespace App\Http\Controllers;

use App\Models\Standard;
use finfo;
use Illuminate\Http\Request;

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
            $deleteUrl = route('standard.delete', encrypt($row->id));
            $changeStatus = route('standard.changeStatus', encrypt($row->id));
            $action = '';

            $action .= " <a id='delete' href='". $deleteUrl ."' class='btn btn-danger btn-xs delete'><i class='fa fa-trash'></i> Delete</a>";
            if ($row->is_active == '0') {
                $action .= " <a id='activate' href='". $changeStatus ."' class='btn btn-success btn-xs activeUser'><i class='fa fa-check'></i> Activate</a>";
            } else {
                $action .= " <a id='deactivate' href='". $changeStatus ."' class='btn btn-danger btn-xs inactiveUser'><i class='fa fa-times'></i> Deactivate</a>";
            }
            return $action;

        })
        ->rawColumns(['action'])
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
}
