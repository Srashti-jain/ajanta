<?php
namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!auth()->user()->can('invoicesetting.view'),403,__('User does not have the right permissions.'));
        
        $Invoice = Invoice::first();

        return view("admin.Invoice.edit", compact("Invoice"));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('invoicesetting.update'),403,__('User does not have the right permissions.'));

        $invoice = Invoice::first();

       
        if (empty($invoice))
        {

            $data = $this->validate($request, ["prefix" => "required", "postfix" => "required",

            ], [

            "prefix.required" => __("Prefix Field is Required"), "postfix.required" => __("Postfix Field is Required"),

            ]);

            $obj = new Invoice;

            $obj->order_prefix = $request->prefix;
            $obj->prefix = $request->prefix;
            $obj->postfix = $request->postfix;
            $obj->inv_start = $request->inv_start;
            $obj->cod_prefix = $request->cod_prefix;
            $obj->cod_postfix = $request->cod_postfix;
            $obj->terms = clean($request->terms);
            $obj->user_id = Auth::user()->id;

            if ($file = $request->file('seal'))
            {

                $name = time() . $file->getClientOriginalName();

                $file->move('public/images/seal', $name);

                $obj->seal = $name;

            }

            if ($file = $request->file('sign'))
            {

                $name = time() . $file->getClientOriginalName();

                $file->move('public/images/sign', $name);

                $obj->sign = $name;

            }

            $value = $obj->save();
            if ($value)
            {
                session()->flash("updated", __("Invoice has been created !"));
                return back();
            }
        }

        else
        {

            $update = new Invoice;
            $obj = $update->first();
            $obj->order_prefix = $request->order_prefix;
            $obj->prefix = $request->prefix;
            $obj->postfix = $request->postfix;
            $obj->inv_start = $request->inv_start;
            $obj->cod_prefix = $request->cod_prefix;
            $obj->cod_postfix = $request->cod_postfix;
            $obj->terms = clean($request->terms);

            if ($file = $request->file('seal'))
            {

                $seal  = @file_get_contents(public_path().'/images/seal/' . $obj->seal);
                if ($seal)
                {
                    unlink(public_path().'/images/seal/' . $obj->seal);
                }

                $name = time() . $file->getClientOriginalName();

                $file->move(public_path().'/images/seal', $name);

                $obj->seal = $name;

            }

            if ($file = $request->file('sign'))
            {
                $sign = @file_get_contents(public_path().'/images/sign/' . $obj->sign);

                if ($sign)
                {
                    unlink(public_path().'/images/sign/' . $obj->sign);
                }

                $name = time() . $file->getClientOriginalName();

                $file->move(public_path().'/images/sign', $name);

                $obj->sign = $name;

            }

            $value = $obj->save();
            if ($value)
            {
                session()->flash("updated", __("Invoice setting has been updated !"));
                return back();
            }
        }
    }

    public function show(){
        $design = @file_get_contents(storage_path().'/app/emart/invoice_design.json');
        $design = json_decode($design);
        return view('admin.Invoice.design',compact('design'));
    }

    public function updateInvoiceDesign(Request $request){
        
        $invoice_design = array(
            'show_logo' => $request->show_logo ? 1 : 0,
            'show_qr'   => $request->show_qr   ? 1 : 0,
            'show_vat'  => $request->show_vat  ? 1 : 0,
            'print_mode' => $request->print_mode ? 'landscape' : 'portrait',
            'border_radius' => $request->border_radius,
            'border_color' => $request->border_color,
            'border_style' => $request->border_style,
            'date_format'  => $request->date_format
        );

        $file = json_encode($invoice_design);

        $filename = 'invoice_design.json';

        Storage::disk('local')->put('/emart/' . $filename, $file);
        
        return back()->with('success',__("Invoice design has been updated !"));

    }
}

