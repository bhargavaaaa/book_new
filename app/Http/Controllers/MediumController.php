<?php

namespace App\Http\Controllers;

use App\Models\Medium;
use Illuminate\Http\Request;

class MediumController extends Controller
{
    public $moduleName = 'Medium';
    public $route = 'medium';
    public $view = 'medium';

    public function index()
    {
        $moduleName = $this->moduleName;
        return view($this->view . '/index', compact('moduleName'));
    }

    public function getData()
    {
        $medium = Medium::select();
        $datatables = datatables()->eloquent($medium)
        ->addColumn('action', function($row) {
            $editUrl = route('medium.edit', encrypt($row->id));
            $deleteUrl = route('medium.delete', encrypt($row->id));

            $action = '';

            $action .= "<a href='" . $editUrl . "' class='btn btn-warning btn-xs'><i class='fas fa-pencil-alt'></i> Edit</a>";
            $action .= " <a id='delete' href='". $deleteUrl ."' class='btn btn-danger btn-xs delete'><i class='fa fa-trash'></i> Delete</a>";
            
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
            Medium::create([
                'name'      => $request->name,
            ]);

        }

        return redirect($this->route)->with("details_success", "Medium Added Successfully.");
    }

    public function edit($id)
    {
        $moduleName = $this->moduleName;
        $medium = Medium::find(decrypt($id));
        return view($this->view . '/_form', compact('moduleName','medium'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required',
        ]);

        $medium = Medium::find(decrypt($id));
        $medium->update(['name' => $request->name]);

        return redirect($this->route)->with("details_success", "Medium Update Successfully.");
    }

    public function delete($id)
    {
        $id = decrypt($id);
        $medium = Medium::find($id);
        if($medium){
            $medium->delete();
        }

        return redirect($this->route)->with("details_success", "Medium Deleted Successfully.");
    }

}
