<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @page {
            margin: 0mm;
            margin-header: 0mm;
            margin-footer: 0mm;
        }

        .page {
            display: block;
            width: 725px;
            height: 1125px;
            background-repeat: no-repeat;
            background-size: 2250px 3180px;
            /* border: 1px solid black; */
            padding: 35px;
            padding-top: 50px;
        }

        .bg {
            background-image: url('{{ public_path() . "/image/print-bg.jpg" }}');
        }
    </style>
</head>

<body>
    <div class="page bg">
        <table style="padding-top: 3px; font-size: 16px; width: 100%; padding-bottom: 6px;" id="client info">
            <tr>
                <td colspan="2" style="width: 50%; padding-right: -10px; text-align: right; font-size: 14px; color: #0066cc;">{{ date('jS M, Y',strtotime($invoice->date)) }}&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" style="width: 50%; padding-left: 165px; padding-top: 50px; color: #0066cc;">{{ $invoice->name }}&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 50%; padding-left: 165px; padding-top: 12px; color: #0066cc;">{{ $invoice->phone }}&nbsp;</td>
                <td style="width: 50%; padding-left: 40px; padding-top: 12px; color: #0066cc;">{{ $invoice->email }}&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" style="width: 50%; padding-left: 165px; padding-top: 12px; color: #0066cc;">{{ $invoice->from_address }}&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" style="width: 50%; padding-left: 165px; padding-top: 8px; color: #0066cc;">{{ $invoice->to_address }}&nbsp;</td>
            </tr>
        </table>
        <table style="font-size: 16px;  width: 100%; margin-top: 13px; padding-bottom: 9px;" id="cost info">
            <tr>
                <td style="width: 50%; padding-left: 120px; padding-top:50px; color: #0066cc;">{{ $invoice->start_time }}&nbsp;</td>
                <td style="width: 50%; padding-left: 140px; padding-top:50px; color: #0066cc;">{{ $invoice->end_time }}&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 50%; padding-left: 120px; padding-top:12px; color: #0066cc;">{{ explode(' ',$invoice->work_hours)[0] }}&nbsp;</td>
                <td style="width: 50%; padding-left: -120px; padding-top:12px; color: #0066cc;">&#36; {{ $invoice->rate }}&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 50%; padding-left: 120px; padding-top:7px; color: #0066cc;">&#36; {{ $invoice->labor }}&nbsp;</td>
                <td style="width: 50%; padding-left: 140px; padding-top:7px; color: #0066cc;">&#36; {{ $invoice->subtotal }}&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 50%; padding-left: 120px; padding-top:10px; color: #0066cc;">&#36; {{ $invoice->stairs }}&nbsp;</td>
                <td style="width: 50%; padding-left: 140px; padding-top:10px; color: #0066cc;">{{ $invoice->tax }} &#37;</td>
            </tr>
            <tr>
                <td style="width: 50%; padding-left: 120px; padding-top:5px; color: #0066cc;">&#36; {{ $invoice->supplies }}&nbsp;</td>
                <td style="width: 50%; padding-left: 140px; padding-top:5px; color: #0066cc;">&#36; {{ $invoice->total }}&nbsp;</td>
            </tr>
        </table>
        <table style="font-size: 16px;  width: 100%; margin-top: 13px; padding-bottom: 9px;" id="crew details">
            <tr>
                <td style="width: 50%; padding-left: 120px; padding-top: 40px; color: #0066cc;">{{ $invoice->driver }}&nbsp;</td>
                <td style="width: 50%; padding-left: 140px; padding-top: 40px; color: #0066cc;">{{ $invoice->vehicle }}&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" style="width: 50%; padding-left: 120px; padding-top: 7px; color: #0066cc;">{{ $invoice->helper }}&nbsp;</td>
            </tr>
        </table>
        <table style="font-size: 16px; width: 100%; margin-top: 12px; padding-bottom: 10px;" id="inspected n initial">
            <tr>
                <td style="width: 50%; padding-left: 135px; padding-top: 38px; color: #0066cc;">{{ $invoice->inspected_by }}&nbsp;</td>
                <td style="width: 50%; padding-left: 155px; padding-top: 38px; color: #0066cc;">{{ $invoice->crew_initial }}&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 50%; padding-left: 8px; padding-top: 15px; color: #0066cc;"><a href="https://kamaainamovers.com/disclaimer.php">Read and Agreed disclaimer on Back</a></td>
                <td style="width: 50%; padding-left: 155px; padding-top: 12px; color: #0066cc;">{{ $invoice->customer_initial }}&nbsp;</td>
            </tr>
        </table>
        <table style="font-size: 16px; width: 100%; margin-top: 16px;" id="operation description">
            <tr>
                <td colspan="2" style="width: 100%; padding-left:7px; padding-top:20px;  color: #0066cc; height:69px;">{{ $invoice->operation_details }}&nbsp;</td>
            </tr>
        </table>
        <table style="font-size: 16px; width: 100%; margin-top: 16px;" id="special instruction">
            <tr>
                <td colspan="2" style="width: 100%; padding-left:7px; padding-top:15px;  color: #0066cc; height:125px;">{{ $invoice->comment_instruction }}&nbsp;</td>
            </tr>
        </table>
        <table style="font-size: 16px; width: 100%; margin-top: 9px;" id="final signature">
            <tr>
                <td colspan="2" style="width: 50%; padding-left: 150px; padding-top: 8px; color: #0066cc;">{{ $invoice->number }}&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" style="width: 50%; padding-left: 480px; padding-top: 55px; color: #0066cc;">{{ $invoice->sign }}&nbsp;</td>
            </tr>
        </table>
    </div>
</body>

</html>