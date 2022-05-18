<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Vadodara:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
    <style>
        body {
            font-family: 'Hind Vadodara', sans-serif !important;
            padding: 15px;
        }
        .main_table_border td {
            border: 1px solid black;
        }
        @page { 
            size: A5 
        }
    </style>
</head>

<body class="A5">
    <div style="color: #333; height: 100%; width: 100%;" height="100%" width="100%">
        <table cellspacing="0" style="border-collapse: collapse; width: 100%;" width="100%">
            <tbody>
                <tr>
                    <td style="clear: both; display: block; margin: 0 auto;">
                        <table width="100%" cellspacing="0" style="border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td style="padding: 0;">
                                        <a href="#" style="color: #348eda;" target="_blank">
                                            <img src="{{ asset('public/images/logo.jpg') }}" alt="Bootdey.com"
                                                style="height: 100px; max-width: 100%; width: 157px;" height="50"
                                                width="157" />
                                        </a>
                                    </td>
                                    <td style="font-size: 12px; padding: 0; text-align: right;" align="right">
                                        <b>Avinash Chauhan 90332 00805</b><br /><br />
                                        Nr. Holy Redeemer School, Nr. Shiv<br />
                                        Medical Store, Yagraj Nagar, Rajkot.<br /><br />
                                        <b>www.buyschoolbook.co.in</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="clear: both; display: block; padding: 0;">
                        <table width="100%"
                            style="border-collapse: collapse; color: #999;" class="main_table_border">
                            <tbody>
                                <tr>
                                    <td width="50%" id="invoice_no_td" style="padding: 5px;" data-invc_id="{{ $invoice_no }}"><strong style="color: #333;">No.</strong>
                                        {{ $invoice_no }}</td>
                                    <td align="right" width="50%" style="padding: 3px;"><strong
                                            style="color: #333;">Dt.</strong> {{ date('d-M-Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="clear: both; display: block; padding: 0;">
                        <table width="100%"
                            style="border-collapse: collapse; color: #999;" class="main_table_border">
                            <tbody>
                                <tr>
                                    <td width="100%" style="padding: 5px;">
                                        M/s 
                                        <input type="text" style="outline: 0; border-width: 0 0 2px; border-color: #000; width: 80%; font-size: 20px" value="{{ $student->name ?? "" }}" id="student_name">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="border-top: 0; clear: both; display: block; padding: 0;">
                        <table cellspacing="0" class="main_table_border" style="border-collapse: collapse; width: 100%">
                            <tbody>
                                <tr>
                                    <td valign="top" style="padding: 5px;" width="15%">
                                        Sr. No.
                                    </td>
                                    <td valign="top" style="padding: 5px;" width="50%">
                                        Particulars
                                    </td>
                                    <td valign="top" style="padding: 5px;" width="10%">
                                        Qty.
                                    </td>
                                    <td valign="top" style="padding: 5px;" width="10%">
                                        Rate
                                    </td>
                                    <td valign="top" style="padding: 5px;" width="10%">
                                        Amount
                                    </td>
                                </tr>
                                @php
                                    $final_total = 0;
                                @endphp
                                @foreach($books as $key => $book)
                                    <tr>
                                        <td valign="top" style="padding: 5px;">
                                            {{ $key + 1 }}
                                        </td>
                                        <td valign="top" style="padding: 5px;">
                                            {{ substr($book->name, 0, 100) }}
                                        </td>
                                        <td valign="top" style="padding: 5px;">
                                            {{ $qunatities[$key] }}
                                        </td>
                                        <td valign="top" style="padding: 5px;">
                                            {{ number_format($book->price, 2) }}
                                        </td>
                                        @php
                                            if($book->discount_type == 1) {
                                                $total_price = ($book->price * $qunatities[$key]) - (($book->price * $book->discount) / 100);
                                            } else {
                                                $total_price = ($book->price * $qunatities[$key]) - ($book->discount * $qunatities[$key]);
                                            }
                                            $final_total = $final_total + $total_price;
                                        @endphp
                                        <td valign="top" style="padding: 5px;">
                                            {{ number_format($total_price, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="border-top: 0; clear: both; display: block; padding: 0;">
                        <table cellspacing="0" class="main_table_border" style="border-collapse: collapse; width: 100%">
                            <tbody>
                                <tr>
                                    <td valign="top" style="padding: 5px;" width="60%">
                                        Rupees
                                    </td>
                                    <td valign="top" style="padding: 5px;" width="15%">
                                        Total
                                    </td>
                                    <td valign="top" style="padding: 5px;" width="25%">
                                        {{ number_format($final_total, 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                @if ($payment_status == 1)
                <tr>
                    <td>
                        ***Payment Pending***
                    </td>
                </tr>
                @endif
                <tr style="color: #666; font-size: 12px;">
                    <td style="clear: both; display: block; margin: 0 auto; padding: 10px 0;">
                        <table width="100%" cellspacing="0" style="border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td width="40%" valign="top" style="padding: 10px 0;">
                                        <h4 style="margin: 0; color: #000;">Terms & Condition</h4>
                                        <p
                                            style="color: #666; font-size: 12px; font-weight: normal; margin: 0;">
                                            Books once sold will not be taken back.
                                        </p>
                                    </td>
                                    <td width="10%" style="padding: 10px 0;">&nbsp;</td>
                                    <td width="40%" valign="top" style="padding: 10px 0;">
                                        <h4 style="margin: 0; font-size: 15px;">For, <span style="color: #000;">Buy School-Book Stationery</span></h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
<script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>
<script>
    window.addEventListener('beforeprint', (event) => {
        event.preventDefault();
        $.ajax({
            url: "{{ route('invoice.store_invoice') }}",
            type: "GET",
            data: {
                name: $('#student_name').val(),
                invoice_id: $('#invoice_no_td').data('invc_id'),
            },
            success: function(response) {
                //
            },
        });
    });
</script>
</html>
