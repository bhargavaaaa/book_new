<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public $moduleName = 'Category';
    public $route = 'category';
    public $view = 'category';

    public function index()
    {
        $moduleName = $this->moduleName;
        return view($this->view . '/index', compact('moduleName'));
    }

    public function getData()
    {
        $category = Category::select();
        $datatables = datatables()->eloquent($category)
        ->addColumn('action', function($row) {
            $deleteUrl = route('category.delete', encrypt($row->id));
            $changeStatus = route('category.changeStatus', encrypt($row->id));
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
            Category::create([
                'name'      => $request->name,
                'is_active' => $request->is_active
            ]);

        }

        return redirect($this->route)->with("details_success", "Category Added Successfully.");
    }

    public function delete($id)
    {
        $id = decrypt($id);
        $category = Category::find($id);
        if($category){
            $category->delete();
        }

        return redirect($this->route)->with("details_success", "Category Deleted Successfully.");
    }

    public function changeStatus($id)
    {
        $category = Category::find(decrypt($id));
        if($category->is_active == 0){
            $category->update(['is_active' => 1]);
            return redirect($this->route)->with("details_success", "Category Activate Successfully.");
        } else {
            $category->update(['is_active' => 0]);
            return redirect($this->route)->with("details_success", "Category InActivate Successfully.");
        }
    }
}
