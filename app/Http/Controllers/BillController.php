<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Invoice;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public $moduleName = "All Bills";

    public function index()
    {
        $moduleName = $this->moduleName;
        return view('bill.index', compact('moduleName'));
    }

    public function getData()
    {
        $book = Invoice::select();
        $datatables = datatables()->eloquent($book)
        ->addColumn('action', function($row) {
            $deleteUrl = route('bills.delete', encrypt($row->id));
            $action = '';

            if($row->payment_status == 1) {
                $action .= "<a href='javascript:;' class='btn btn-warning btn-xs markpaid' data-id='".$row->id."'><i class='fa fa-credit-card'></i> Mark as Paid</a>";
            }
            $action .= " <a id='delete' href='". $deleteUrl ."' class='btn btn-danger btn-xs delete'><i class='fa fa-trash'></i> Delete</a>";

            return $action;
        })
        ->editColumn('payment_status', function($row) {
            if($row->payment_status == 1) {
                return '<span class="badge badge-warning">Pending</span>';
            } else {
                return '<span class="badge badge-success">Paid</span>';
            }
        })
        ->addColumn('total_quantity', function($row) {
            $data = json_decode($row->order_items, true);
            $tq = 0;
            foreach ($data as $dt) {
                $tq = $tq + $dt["quantity"];
            }
            return $tq;
        })
        ->editColumn('created_at', function($row) {
            return date('d-M-Y h:i:s A', strtotime($row->created_at));
        })
        ->addColumn('checkBox', function ($row) {
            $checkBox = "<input type='checkbox' class='form-check checkBox' value='" . encrypt($row->id) . "' />";
            return $checkBox;
        })
        ->rawColumns(['action', 'payment_status', 'total_quantity', 'created_at','checkBox'])
        ->addIndexColumn()
        ->make(true);

        return $datatables;
    }

    public function mark_paid(Request $request)
    {
        $id = $request->id;
        $invoice = Invoice::find($id);
        $invoice->payment_status = 0;
        $invoice->save();

        return response()->json(["status" => true], 200);
    }

    public function delete($id)
    {
        $id = decrypt($id);
        Invoice::where('id', $id)->delete();

        return redirect()->back()->with("details_success", "Bill Deleted Successfully.");
    }
}
