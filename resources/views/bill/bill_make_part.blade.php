<hr/>
<div class="row g-3">
    <div class="col-md-6 mb-3 col-sm-12">
        <label class="form-label">Student (optional select student if it in list)</label>
        <select class="form-control studentselect2" name="student" id="student_select">    
            <option value="">-- Select student --</option>
            @foreach ($student_list as $student)
                <option value="{{ $student->id }}">{{ $student->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3 col-sm-12">
        <label class="form-label">Payment Status</label>
        <div class="radio">
            <label for="amount" class="mr-2"><input type="radio" name="payment_status" id="amount"
                    value="0" checked> Cash</label>
            <label for="percentage"><input type="radio" name="payment_status" id="percentage"
                    value="1"> Pending</label>
        </div>
    </div>  
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Book Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Rate</th>
            <th scope="col">Price</th>
            <th scope="col">Disc. %</th>
            <th scope="col">Disc. Rate</th>
            <th scope="col">Amount</th>
        </tr>
    </thead>
    <tbody>
        @php
            $final_total = 0;
            $final_disc_rate = 0;
            $final_rate = 0;
        @endphp
        @foreach ($books as $book)
        <tr class="current_row">
            <th scope="row"><input type="checkbox" name="book_ids[]" value="{{ $book->id }}" class="book_ids_cheker" checked></th>
            <td>{{ $book->name }}</td>
            <td><input type="number" name="qunatities[]" class="form-control qunatities" value="1" min="1"></td>
            <td class="book_price" data-value="{{ $book->price }}">{{ number_format($book->price, 2) }}</td>
            <td class="qunat_price_mult">{{ number_format($book->price, 2) }}</td>
            <td class="discount_percent" data-yes="@if($book->discount_type == 1) yes @else no @endif" data-value="{{ $book->discount }}">@if($book->discount_type == 1) {{ $book->discount.'%' }} @else 0.00% @endif</td>
            <td class="discount_amount" data-yes="@if($book->discount_type == 0) yes @else no @endif" data-value="{{ $book->discount }}">@if($book->discount_type == 0) {{ $book->discount }} @else 0.00 @endif</td>
            @php
                if($book->discount_type == 1) {
                    $total_price = $book->price - (($book->price * $book->discount) / 100);
                } else {
                    $total_price = $book->price - $book->discount;
                    $final_disc_rate = $final_disc_rate + $book->discount;
                }
                $final_total = $final_total + $total_price;
                $final_rate = $final_rate + $book->price;
            @endphp
            <td class="total_final_amount">{{ number_format($total_price, 2) }}</td>
        </tr>
        @endforeach
        <tr>
            <th scope="col"></th>
            <th scope="col">Total</th>
            <th scope="col"></th>
            <th scope="col" class="set_final_rate">{{ number_format($final_rate, 2) }}</th>
            <th scope="col" class="set_final_multiplied">{{ number_format($final_rate, 2) }}</th>
            <th scope="col"></th>
            <th scope="col" class="set_final_disc_rate">{{ number_format($final_disc_rate, 2) }}</th>
            <th scope="col" class="set_final_total">{{ number_format($final_total, 2) }}</th>
        </tr>
    </tbody>
</table>
