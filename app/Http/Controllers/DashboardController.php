<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DashboardSetting;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:site-settings.dashboard-settings']);
    }

    public function dashbordsetting()
    {
        return view('admin.dashbord.setting');
    }

    public function dashbordsettingu(Request $request, $id)
    {
        $ds = DashboardSetting::first();

        $ds->lat_ord = $request->lat_ord ? 1 : 0;
        $ds->rct_pro = $request->rct_pro ? 1 : 0;
        $ds->rct_str = $request->rct_str ? 1 : 0;
        $ds->rct_cust = $request->rct_cust ? 1 : 0;

        $ds->max_item_ord = $request->max_item_ord;
        $ds->max_item_pro = $request->max_item_pro;
        $ds->max_item_str = $request->max_item_str;
        $ds->max_item_cust = $request->max_item_cust;

        $ds->save();
        return redirect()
            ->route('admin.dash')
            ->with('updated', __('Setting Updated !'));

    }

    public function fbSetting(Request $request, $id)
    {
        $fb = DashboardSetting::first();

        $fb->fb_page_id = $request->fb_page_id;
        $fb->fb_page_token = $request->fb_page_token;
        $fb->fb_wid = $request->fb_wid ? 1 : 0;

        $fb->save();
        return redirect()
            ->route('admin.dash')
            ->with('updated', __('Widget Setting Updated !'));
    }

    public function twSetting(Request $request, $id)
    {
        $tw = DashboardSetting::first();
        $tw->tw_username = $request->tw_username;
        $tw->tw_wid = $request->tw_wid ? 1 : 0;
        $tw->save();
        return redirect()
            ->route('admin.dash')
            ->with('updated', __('Widget Setting Updated !'));
    }

    public function insSetting(Request $request, $id)
    {
        $ins = DashboardSetting::first();
        $ins->inst_username = $request->inst_username;
        $ins->insta_wid = $request->insta_wid ? 1 : 0;
        $ins->save();
        return redirect()
            ->route('admin.dash')
            ->with('updated', __('Widget Setting Updated !'));
    }
}

