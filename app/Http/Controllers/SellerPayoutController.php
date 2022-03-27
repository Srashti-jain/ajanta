<?php

namespace App\Http\Controllers;

use App\Charts\PayoutChart;
use App\Invoice;
use App\multiCurrency;
use App\SellerPayout;
use DataTables;
use Illuminate\Http\Request;
use PayPal\Api\Payout;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class SellerPayoutController extends Controller
{

    public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this
            ->_api_context
            ->setConfig($paypal_conf['settings']);
    }

    public function index(Request $request)
    {

        $sellerpayouts = SellerPayout::get();

        /*Creating SellerPayout Chart*/

        $payouts = array(

            SellerPayout::whereMonth('created_at', '01')
                ->whereYear('created_at', date('Y'))
                ->count(), //January

            SellerPayout::whereMonth('created_at', '02')
                ->whereYear('created_at', date('Y'))
                ->count(), //Feb

            SellerPayout::whereMonth('created_at', '03')
                ->whereYear('created_at', date('Y'))
                ->count(), //March

            SellerPayout::whereMonth('created_at', '04')
                ->whereYear('created_at', date('Y'))
                ->count(), //April

            SellerPayout::whereMonth('created_at', '05')
                ->whereYear('created_at', date('Y'))
                ->count(), //May

            SellerPayout::whereMonth('created_at', '06')
                ->whereYear('created_at', date('Y'))
                ->count(), //June

            SellerPayout::whereMonth('created_at', '07')
                ->whereYear('created_at', date('Y'))
                ->count(), //July

            SellerPayout::whereMonth('created_at', '08')
                ->whereYear('created_at', date('Y'))
                ->count(), //August

            SellerPayout::whereMonth('created_at', '09')
                ->whereYear('created_at', date('Y'))
                ->count(), //September

            SellerPayout::whereMonth('created_at', '10')
                ->whereYear('created_at', date('Y'))
                ->count(), //October

            SellerPayout::whereMonth('created_at', '11')
                ->whereYear('created_at', date('Y'))
                ->count(), //November

            SellerPayout::whereMonth('created_at', '12')
                ->whereYear('created_at', date('Y'))
                ->count(), //December

        );

        $fillColors = [
            "rgba(255, 99, 132, 0.2)",
            "rgba(22,160,133, 0.2)",
            "rgba(255, 205, 86, 0.2)",
            "rgba(51,105,232, 0.2)",
            "rgba(244,67,54, 0.2)",
            "rgba(34,198,246, 0.2)",
            "rgba(153, 102, 255, 0.2)",
            "rgba(255, 159, 64, 0.2)",
            "rgba(233,30,99, 0.2)",
            "rgba(205,220,57, 0.2)",
        ];

        $sellerpayouts = new PayoutChart;

        $sellerpayouts->labels(['January', 'Febuary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);

        $sellerpayouts->title(__('Monthly Payouts in :year',['year' => date('Y')]))->dataset(__('No of Payouts'), 'bar', $payouts)->options([
            'fill' => 'true',
            'shadow' => 'true',
            'borderWidth' => '1',
        ])->backgroundColor($fillColors)->color($fillColors);

        /*END*/

        $data = SellerPayout::join('invoice_downloads', 'sellerpayouts.orderid', '=', 'invoice_downloads.id')->join('orders', 'orders.id', '=', 'invoice_downloads.order_id')->join('users', 'users.id', '=', 'invoice_downloads.vender_id')->join('stores', 'stores.user_id', '=', 'users.id')->select('users.name as sellername', 'stores.name as storename', 'sellerpayouts.*', 'orders.order_id as orderid', 'invoice_downloads.inv_no as invid');

        if ($request->ajax()) {

            return Datatables::of($data)->addIndexColumn()
                ->addColumn('type', function ($row) {

                    if ($row->paidvia == 'Bank') {
                        return '<label class="badge badge-success">'.__("Bank Transfer").'</label>';
                    } elseif ($row->paidvia == 'Paypal') {
                        return '<label class="badge badge-pill badge-primary">'.__('PayPal').'</label>';
                    } elseif ($row->txn_type == 'manual') {
                        return '<label class="badge badge-pill badge-primary">' . ucfirst($row->paidvia) . '</label>';
                    }

                })
                ->addColumn('orderid', 'admin.seller.orderid')
                ->addColumn('amount', function ($row) {
                    $defCurrency = multiCurrency::where('default_currency', '=', 1)->first();
                    $amount = "<i class='cursym $defCurrency->currency_symbol'></i> $row->orderamount";
                    return $amount;
                })
                ->addColumn('detail', function ($row) {
                    $data = "<p><b>Seller:</b> $row->sellername<p>";
                    $data .= "<p><b>Store:</b> $row->storename</p>";
                    return $data;
                })
                ->addColumn('paidon', function ($row) {
                    $html = '<p><b>Created On:</b> ' . date("d-M-Y | h:i A", strtotime($row->created_at)) . '</p>';
                    $html .= '<p><b>Updated On:</b> ' . date('d-m-Y | h:i A', strtotime($row->updated_at)) . '</p>';
                    return $html;
                })
                ->addColumn('action', function ($row) {
                    $html = '<a href=' . route("vender.payout.show.complete", $row->id) . ' title="'.__('View payout detail').'" class="btn btn-primary-rgba"> <i class="feather icon-eye"></i></i> </a>';
                    return $html;
                })
                ->rawColumns(['type', 'orderid', 'amount', 'detail', 'paidon', 'action'])->make(true);

        }

        return view('seller.payout.index', compact('sellerpayouts'));
    }

    public function showCompletePayout($id)
    {
        $payout = SellerPayout::findorfail($id);
        $inv_cus = Invoice::first();
        if ($payout->paidvia == 'Bank' || $payout->txn_type == 'manual') {
            $status = $payout->status;
            $txnid = $payout->txn_id;
        } else {
            $response = Payout::get($payout->txn_id, $this->_api_context);
            $status = $response->batch_header->batch_status;
            $txnid = $response->items[0]->transaction_id;
        }
        return view('seller.payout.detail', compact('payout', 'inv_cus', 'txnid', 'status'));
    }

    public function printSlip($id)
    {
        $payout = SellerPayout::findorfail($id);
        if ($payout->paidvia == 'Bank' || $payout->txn_type == 'manual') {
            $status = $payout->status;
            $txnid = $payout->txn_id;
        } else {
            $response = Payout::get($payout->txn_id, $this->_api_context);
            $status = $response->batch_header->batch_status;
            $txnid = $response->items[0]->transaction_id;
        }
        $inv_cus = Invoice::first();
        return view('seller.payout.print', compact('payout', 'inv_cus', 'txnid', 'status'));
    }

}
