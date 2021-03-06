<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Invoice;
use App\Models\Medium;
use App\Models\Standard;
use App\Models\Student;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public $moduleName = "Bill & Invoice";

    public function index()
    {
        $moduleName = $this->moduleName;
        $standards = Standard::get();
        $students = Student::get();
        $medium = Medium::get();
        return view('bill.bill_make', compact('moduleName', 'standards', 'students', 'medium'));
    }

    public function getBooksList(Request $request)
    {
        $request->validate([
            "id" => "required",
            "medium" => "required"
        ]);
        $standard_id = (int) $request->id;
        $medium = (int) $request->medium;

        $student_list = Student::where('standard_id', $standard_id)->get();
        $books = Book::whereHas('standard', function($q) use($standard_id) {
            $q->where('standard_id', $standard_id);
        })->whereHas('medium', function($q) use($medium) {
            $q->where('medium_id', $medium);
        })->where('book_status', 1)->get();

        return view('bill.bill_make_part', compact('student_list', 'books'));
    }

    public function mainBookSubmit(Request $request)
    {
        $request->validate([
            "standard" => "required",
            "medium" => "required",
        ]);
        if(!isset($request->book_ids) || empty($request->book_ids)) {
            return redirect()->back()->with("error", "Please select any item to make bill.");
        }

        session()->put('book_ids', ($request->book_ids ?? array()));
        session()->put('qunatities', ($request->qunatities ?? array()));
        session()->put('student', ($request->student ?? 0));
        session()->put('standard', ($request->standard ?? 0));
        session()->put('medium', ($request->medium ?? 0));
        session()->put('payment_status', ($request->payment_status ?? 0));

        return redirect()->route('invoice.make_bill');
    }

    public function make_bill()
    {
        if(!session()->has('book_ids')) {
            return redirect()->route('invoice.index');
        }
        $book_ids = session()->get('book_ids');
        $qunatities = session()->get('qunatities');
        $student = session()->get('student');
        $standard = session()->get('standard');
        $medium = session()->get('medium');
        $payment_status = session()->get('payment_status');

        $last_invoice = Invoice::orderBy("id", "desc")->first();
        if(empty($last_invoice)) {
            $print_id = 1;
        } else {
            $print_id = $last_invoice->id + 1;
        }
        $invoice_no = '#BSB'.sprintf('%05d', $print_id);

        $books = Book::whereIn('id', $book_ids)->get();
        $student = Student::where('id', $student)->first();

        return view('bill.invoice_page', compact('books', 'student', 'qunatities', 'payment_status', 'invoice_no', 'medium'));
    }

    public function store_invoice(Request $request)
    {
        $billing_name = $request->name;
        $invoice_no = $request->invoice_id;
        $book_ids = session()->get('book_ids');
        $qunatities = session()->get('qunatities');
        $student = session()->get('student');
        $medium = session()->get('medium');
        $standard = session()->get('standard');
        $payment_status = session()->get('payment_status');

        $store_Arr = [];
        $final_total = 0;
        foreach ($book_ids as $key => $value) {
            $book = Book::find($value);

            if($book->discount_type == 1) {
                $book_dicount = (($book->price * $book->discount) / 100);
            } else {
                $book_dicount = $book->discount * $qunatities[$key];
            }

            $store_Arr[] = [
                "book_id" => $value,
                "quantity" => $qunatities[$key],
                "book_price" => $book->price,
                "book_discount" => $book_dicount
            ];

            $final_total = $final_total + ($book->price * $qunatities[$key] - $book_dicount);
        }

        Invoice::updateOrCreate([
            "invoice_no" => $invoice_no
        ], [
            "invoice_no" => $invoice_no,
            "standard_id" => $standard,
            "student_id" => $student,
            "medium_id"  => $medium,
            "order_items" => json_encode($store_Arr),
            "billing_name" => $billing_name,
            "amount_total" => $final_total,
            "payment_status" => $payment_status
        ]);

        return true;
    }

    public function bulkDelete(Request $request)
    {
        foreach ($request->invoice as $item) {
            $invoice = Invoice::find(decrypt($item));
            $invoice->delete();
        }

        return response()->json([
            'status' => true
        ]);
    }
}
