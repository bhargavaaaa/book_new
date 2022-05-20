<?php

namespace App\Http\Controllers;

use App\Exports\BookExport;
use App\Imports\BookImport;
use App\Models\Book;
use App\Models\Medium;
use App\Models\Standard;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Arr;

class BookControoler extends Controller
{
    public $moduleName = 'Book';
    public $route = 'book';
    public $view = 'book';

    public function index()
    {
        $moduleName = $this->moduleName;
        return view($this->view . '/index', compact('moduleName'));
    }

    public function getData()
    {
        $book = Book::select();
        $datatables = datatables()->eloquent($book)
        ->addColumn('action', function($row) {
            $editUrl = route('book.edit', encrypt($row->id));
            $deleteUrl = route('book.delete', encrypt($row->id));
            $action = '';

            $action .= "<a href='" . $editUrl . "' class='btn btn-warning btn-xs'><i class='fas fa-pencil-alt'></i> Edit</a>";
            $action .= " <a id='delete' href='". $deleteUrl ."' class='btn btn-danger btn-xs delete'><i class='fa fa-trash'></i> Delete</a>";

            return $action;

        })
        ->addColumn('book_status', function($row) {
            if($row->book_status == 1) {
                return "In store";
            } else {
                return "Yet to come";
            }
        })
        ->rawColumns(['action', 'book_status'])
        ->addIndexColumn()
        ->make(true);

        return $datatables;
    }

    public function create()
    {
        $moduleName = $this->moduleName;
        $standard = Standard::get();
        $medium = Medium::get();
        return view($this->view . '/form', compact('moduleName','standard','medium'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'standard' => 'required',
            'medium' => 'required',
            'price' => 'required',
            'qty' => 'required',
            'discount' => 'required',
            'discount_type' => 'required',
            'book_status' => 'required'
        ]);

        if($validate) {
            $book = Book::create([
                'name' => $request->name,
                'price' => $request->price,
                'qty' => $request->qty,
                'discount' => $request->discount,
                'discount_type' => $request->discount_type,
                'book_status' => $request->book_status
            ]);
        }

        $book->standard()->sync($request->standard);
        $book->medium()->sync($request->medium);

        return redirect($this->route)->with("details_success", "Book Added Successfully.");

    }

    public function edit($id)
    {
        $moduleName = $this->moduleName;
        $standards = Standard::get();
        $mediums = Medium::get();
        $book = Book::with('standard')->find(decrypt($id));

        $standard_id = array();
        foreach($book->standard as $standard) {
            array_push($standard_id,$standard->id);
        }

        $medium_id = array();
        foreach($book->medium as $medium) {
            array_push($medium_id,$medium->id);
        }

        return view($this->view . '/_form', compact('moduleName','standards','book','standard_id','mediums','medium_id'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required',
            'standard' => 'required',
            'medium' => 'required',
            'price' => 'required',
            'qty' => 'required',
            'discount' => 'required',
            'discount_type' => 'required',
            'book_status' => 'required'
        ]);

        $book = Book::find(decrypt($id));
        $book->update([
            'name' => $request->name,
            'price' => $request->price,
            'qty' => $request->qty,
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'book_status' => $request->book_status
        ]);


        $book->standard()->sync($request->standard);
        $book->medium()->sync($request->medium);

        return redirect($this->route)->with("details_success", "Book Update Successfully.");
    }

    public function delete($id)
    {
        $id = decrypt($id);
        $book = Book::find($id);
        $book->standard()->sync([]);
        if($book){
            $book->delete();
        }
        return redirect($this->route)->with("details_success", "Book Deleted Successfully.");
    }

    public function import(Request $request)
    {
        $validate = $request->validate(['file' => 'required']);
        if($validate) {

            Excel::import(new BookImport,request()->file('file'));
        }

        return redirect($this->route)->with("details_success", "Student Data Imported Successfully.");

    }

    public function export()
    {
        return Excel::download(new BookExport, 'books.xlsx');
    }
}
