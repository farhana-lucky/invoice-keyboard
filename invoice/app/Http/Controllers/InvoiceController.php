<?php

namespace App\Http\Controllers;

use Exception;
use App\Invoice;
use App\Mail\InvoiceMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mpdf\Mpdf;

class InvoiceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function mail(Invoice $invoice)
    {
        $params = [
            'name'          => $invoice->name,
            'link'          => route('customer', [$invoice->number]),
        ];
        if ($invoice->email == null) {
            return back()->with('failed', 'Email not added yet. add email.');
        }
        try {
            Mail::to($invoice->email)->send(new InvoiceMail($params));
            $invoice->mail = true;
            $invoice->save();
            return back()->with('success', "Mail has Sent To " . $invoice->name);
        } catch (Exception $ex) {
            return back()->with('failed', $ex->getMessage());
        }
    }

    public function dataTable(Request $request)
    {
        $columns = array(
            0 => 'number',
            1 => 'name',
            2 => 'date',
            3 => 'created_at',
            4 => 'action',
        );

        $results = Invoice::count();

        $resultFiltered = $results;

        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $columns[$request->input('order.0.column')];
        $dir    = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $invoices   = Invoice::offset($start)->limit($limit)->orderBy($order, $dir)->get();
        } else {
            $search     = $request->input('search.value');
            $invoices   =  Invoice::orWhere('number', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('date', 'LIKE', "%{$search}%")
                ->orWhere('created_at', 'LIKE', "%{$search}%")
                ->offset($start)->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $resultFiltered = Invoice::where('id', 'LIKE', "%{$search}%")
                ->orWhere('number', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($invoices)) {
            foreach ($invoices as $invoice) {
                $rowPer['number']   = '<div class="px-4 text-center">' . $invoice->number . '</div>';
                $rowPer['name']     = '<div class="px-4 text-center"><div class="text-sm leading-5 font-medium text-gray-900">' . $invoice->name . '</div></div>';
                $rowPer['schedule'] = '<div class="px-4 text-center"><div class="text-sm leading-5 font-medium text-gray-900 w-24">' . date('M jS, y', strtotime($invoice->date)) . '</div></div>';
                $rowPer['created_at'] = '<div class="px-4 text-center"><div class="text-sm leading-5 font-medium text-gray-900 w-24">' . date('M jS, y', strtotime($invoice->created_at)) . '</div></div>';
                $rowPer['action']   = '<div class="px-4 text-center text-sm leading-5 font-medium">' . $this->actions($invoice) . '</div>';
                $data[] = $rowPer;
            }
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($results),
            "recordsFiltered" => intval($resultFiltered),
            "data"            => $data
        );
        return json_encode($json_data);
    }

    public function actions($invoice)
    {
        $string =
            '<div class="flex justify-center">
                <a href="' . route('invoice.mail', [$invoice->number]) . '" class="text-indigo-500" title="' . ($invoice->mail ? 'mail sent' : 'mail hasn\'t sent') . '">
                <div class="h-5 w-4">
                    <img class="w-full" src="' . ($invoice->mail ? asset('svg/inbox-check.svg') : asset('svg/inbox.svg')) . '" alt="">
                </div>
                </a>
                <a href="' . route('invoice.print', [$invoice->number]) . '" class="text-indigo-500" title="Print" target="_blank">
                <div class="h-5 w-4 mx-10">
                    <img class="w-full" src="' . asset('svg/printer.svg') . '" alt="">
                    </div>
                    </a>
                    <a href="' . route('invoice.edit', [$invoice->number]) . '" class="text-indigo-500" title="Modify" target="_blank">
                    <div class="h-5 w-4">
                        <img class="w-full" src="' . asset('svg/edit-pencil.svg') . '" alt="">
                    </div>
                </a>
                <a href="' . route('customer', [$invoice->number]) . '" class="text-indigo-500" title="customer view" target="_blank">
                    <div class="h-5 w-4 mx-10">
                        <img class="w-full" src="' . asset('svg/view-show.svg') . '" alt="">
                    </div>
                </a>
                <a class="text-red-500 cursor-pointer" title="Delete">
                    <div class="h-5 w-4">
                        <img class="w-full" src="' . asset('svg/trash.svg') . '" alt="" onclick="deleted(' . $invoice->number . ')">
                    </div>
                </a>
            </div>';
        return $string;
    }

    public function create()
    {
        return view('invoice.create');
    }

    public function store(Request $request)
    {
        $invoice = new Invoice;

        if (isset($request->date)) {
            $date_array = explode('/', $request->date);
            $invoice->date = $date_array[2] . "-" . $date_array[1] . "-" . $date_array[0] . " " . date('h:i:s');
        } else {
            $invoice->date = date('Y-m-d h:i:s');
        }
        $invoice->number        = date('ymdhis');
        $invoice->name          = $request->name;
        $invoice->email         = $request->email;
        $invoice->phone         = $request->phone;

        $invoice->from_address  = $request->from_address;
        $invoice->to_address    = $request->to_address;

        $invoice->tax           = $request->tax;
        $invoice->rate          = $request->rate;
        $invoice->total         = $request->total;
        $invoice->labor         = $request->labor;
        $invoice->stairs        = $request->stairs;
        $invoice->supplies      = $request->supplies;
        $invoice->subtotal      = $request->subtotal;
        $invoice->end_time      = $request->end_time;
        $invoice->work_hours    = $request->work_hours;
        $invoice->start_time    = $request->start_time;

        $invoice->driver      = $request->driver;
        $invoice->helper      = $request->helper;
        $invoice->vehicle     = $request->vehicle;

        $invoice->crew_initial   = $request->crew_initial;
        $invoice->inspected_by  = $request->inspected_by;
        $invoice->customer_initial       = $request->customer_initial;

        $invoice->operation_details     = $request->operation_details;
        $invoice->comment_instruction   = $request->comment_instruction;

        $invoice->sign     = $request->sign;
        if (!$invoice->save()) {
            return back()->withInput()->with('failed', __('Invoice creation request failed!'));
        }
        return back()->with('success', __('Invoice added successfully'));
    }

    public function edit(Invoice $invoice)
    {
        return view('invoice.edit', ['invoice' => $invoice]);
    }

    public function update(Invoice $invoice, Request $request)
    {
        if (isset($request->date)) {
            $date_array = explode('/', $request->date);
            $invoice->date = $date_array[2] . "-" . $date_array[1] . "-" . $date_array[0];
        } else {
            $invoice->date = date('Y-m-d');
        }
        $invoice->name          = $request->name;
        $invoice->email         = $request->email;
        $invoice->phone         = $request->phone;

        $invoice->from_address  = $request->from_address;
        $invoice->to_address    = $request->to_address;

        $invoice->tax           = $request->tax;
        $invoice->rate          = $request->rate;
        $invoice->total         = $request->total;
        $invoice->labor         = $request->labor;
        $invoice->stairs        = $request->stairs;
        $invoice->supplies      = $request->supplies;
        $invoice->subtotal      = $request->subtotal;
        $invoice->end_time      = $request->end_time;
        $invoice->work_hours    = $request->work_hours;
        $invoice->start_time    = $request->start_time;

        $invoice->driver      = $request->driver;
        $invoice->helper      = $request->helper;
        $invoice->vehicle     = $request->vehicle;

        $invoice->crew_initial   = $request->crew_initial;
        $invoice->inspected_by  = $request->inspected_by;
        $invoice->customer_initial       = $request->customer_initial;
        $invoice->operation_details     = $request->operation_details;
        $invoice->comment_instruction   = $request->comment_instruction;

        $invoice->sign     = $request->sign;
        if (!$invoice->save()) {
            return back()->withInput()->with('failed', __('Invoice modification request failed!'));
        }
        if ($request->type == 'email') {
            if ($invoice->email == null) {
                return back()->with('failed', 'Email not added yet. add email.');
            }
            return redirect()->route('invoice.mail', [$invoice->number]);
        } else if ($request->type == 'print') {
            return redirect()->route('invoice.print', [$invoice->number]);
        } else {
            return back()->with('success', 'Invoice Updated.');
        }
    }

    public function list()
    {
        return view('invoice.list');
    }

    public function print(Invoice $invoice)
    {
        try {
            $params = [
                'invoice'     => $invoice,
            ];
            // dd($params);
            $pdf_html = view('invoice.print', $params)->render();
            // return $pdf_html;

            $pdf_filename = Str::slug('invoice-' . $invoice->name . '-') . ".pdf";

            $pdf = new Mpdf([
                'mode'          => 'utf-8',
                'format'        => 'A4',
                'tempDir'       => Storage::path('temp'),
                'defaultCssFile' => public_path() . "/css/app.css",
                'debug'         => true,
            ]);

            $pdf->showImageErrors = true;
            // $pdf->WriteHTML('<h1>Hello world!</h1>');
            $pdf->WriteHTML($pdf_html);

            return $pdf->Output($pdf_filename, "I");
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function delete(Invoice $invoice)
    {
        if (!$invoice->delete()) {
            redirect()->route('invoice.list')->with('failed', 'Invoice Deletion Failed.');
        }
        redirect()->route('invoice.list')->with('success', 'Invoice Deleted Successfully.');
    }

    public function wild()
    {
        return redirect()->route('invoice.list');
    }
}
