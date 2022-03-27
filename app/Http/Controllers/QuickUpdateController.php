<?php

namespace App\Http\Controllers;

use App\admin_return_product;
use App\Adv;
use App\Blog;
use App\Brand;
use App\Category;
use App\Commission;
use App\coupan;
use App\DetailAds;
use App\Faq;
use App\Grandcategory;
use App\Hotdeal;
use App\Menu;
use App\Page;
use App\Product;
use App\Slider;
use App\Social;
use App\SpecialOffer;
use App\Store;
use App\Subcategory;
use App\Tax;
use App\TaxClass;
use App\Testimonial;
use App\unit;
use App\User;
use App\UserReview;
use App\Widgetsetting;

class QuickUpdateController extends Controller
{
    public function userUpdate($id)
    {
        $user = User::findorfail($id);
        if ($user->status == 1) {
            User::where('id', '=', $id)->update(['status' => 0]);
            return back()->with('added', __('User Status changed to deactive !'));
        } else {
            User::where('id', '=', $id)->update(['status' => 1]);
            return back()->with('added', __('User Status changed to Active !'));
        }

    }

    public function storeUpdate($id)
    {
        $store = Store::findorfail($id);

        if ($store->status == 1) {
            Store::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            Store::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function unitUpdate($id)
    {
        $unit = unit::findorfail($id);

        if ($unit->status == 1) {
            unit::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            unit::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function menuUpdate($id)
    {
        $menu = Menu::findorfail($id);

        if ($menu->status == 1) {
            Menu::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            Menu::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function productUpdate($id)
    {
        $product = Product::findorfail($id);

        if ($product->status == 1) {
            Product::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            Product::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function catUpdate($id)
    {
        $cat = Category::findorfail($id);

        if ($cat->status == 1) {
            Category::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            Category::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function subUpdate($id)
    {
        $sub = Subcategory::findorfail($id);

        if ($sub->status == 1) {
            Subcategory::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            Subcategory::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function childUpdate($id)
    {
        $child = Grandcategory::findorfail($id);

        if ($child->status == 1) {
            Grandcategory::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            Grandcategory::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function brandUpdate($id)
    {
        $brand = Brand::findorfail($id);

        if ($brand->status == 1) {
            Brand::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            Brand::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function reviewUpdate($id)
    {

        $review = UserReview::findorfail($id);

        if ($review->status == 1) {
            UserReview::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            UserReview::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function couponUpdate($id)
    {

        $coupon = coupan::findorfail($id);

        if ($coupon->status == 1) {
            coupan::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            coupan::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function taxUpdate($id)
    {

        $tax = Tax::findorfail($id);

        if ($tax->status == 1) {
            Tax::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            Tax::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function taxclassUpdate($id)
    {

        $taxclass = TaxClass::findorfail($id);

        if ($taxclass->status == 1) {
            TaxClass::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            TaxClass::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function commissionUpdate($id)
    {

        $c = Commission::findorfail($id);

        if ($c->status == 1) {
            Commission::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            Commission::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function banksUpdate($id)
    {

        $banks = admin_return_product::findorfail($id);

        if ($banks->status == 1) {
            admin_return_product::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            admin_return_product::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function sliderUpdate($id)
    {

        $s = Slider::findorfail($id);

        if ($s->status == 1) {
            Slider::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            Slider::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function faqUpdate($id)
    {

        $f = Faq::findorfail($id);

        if ($f->status == 1) {
            Faq::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            Faq::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function blogUpdate($id)
    {

        $blog = Blog::findorfail($id);

        if ($blog->status == 1) {
            Blog::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            Blog::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function pageUpdate($id)
    {

        $page = Page::findorfail($id);

        if ($page->status == 1) {
            Page::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            Page::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function socialUpdate($id)
    {

        $social = Social::findorfail($id);

        if ($social->status == 1) {
            Social::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            Social::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function hotdealUpdate($id)
    {

        $hd = Hotdeal::findorfail($id);

        if ($hd->status == 1) {
            Hotdeal::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            Hotdeal::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function advUpdate($id)
    {

        $adv = Adv::findorfail($id);

        if ($adv->status == 1) {
            Adv::where('id', '=', $id)->update(['status' => 0]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            Adv::where('id', '=', $id)->update(['status' => 1]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function clintUpdate($id)
    {

        $testi = Testimonial::findorfail($id);

        if ($testi->status == 1) {
            Testimonial::where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            Testimonial::where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function widgethomeUpdate($id)
    {

        $wh = Widgetsetting::findorfail($id);

        if ($wh->home == 1) {
            Widgetsetting::where('id', '=', $id)->update(['home' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            Widgetsetting::where('id', '=', $id)->update(['home' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function widgetshopUpdate($id)
    {

        $ws = Widgetsetting::findorfail($id);

        if ($ws->shop == 1) {
            Widgetsetting::where('id', '=', $id)->update(['shop' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            Widgetsetting::where('id', '=', $id)->update(['shop' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function widgetpageUpdate($id)
    {

        $wp = Widgetsetting::findorfail($id);

        if ($wp->page == 1) {
            Widgetsetting::where('id', '=', $id)->update(['page' => "0"]);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            Widgetsetting::where('id', '=', $id)->update(['page' => "1"]);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function catfeaUpdate($id)
    {
        $cat = Category::findorfail($id);

        if ($cat->featured == 1) {
            Category::where('id', '=', $id)->update(['featured' => "0"]);
            return back()->with('added', __('Featured status set to NO !'));
        } else {
            Category::where('id', '=', $id)->update(['featured' => "1"]);
            return back()->with('added', __('Featured status set to YES !'));
        }
    }

    public function subfeaUpdate($id)
    {
        $sub = Subcategory::findorfail($id);

        if ($sub->featured == 1) {
            Subcategory::where('id', '=', $id)->update(['featured' => "0"]);
            return back()->with('added', __('Featured status set to NO !'));
        } else {
            Subcategory::where('id', '=', $id)->update(['featured' => "1"]);
            return back()->with('added', __('Featured status set to YES !'));
        }
    }

    public function childfeaUpdate($id)
    {
        $child = Grandcategory::findorfail($id);

        if ($child->featured == 1) {
            Grandcategory::where('id', '=', $id)->update(['featured' => "0"]);
            return back()->with('added', __('Featured status set to NO !'));
        } else {
            Grandcategory::where('id', '=', $id)->update(['featured' => "1"]);
            return back()->with('added', __('Featured status set to YES !'));
        }
    }

    public function productfeaUpdate($id)
    {
        $product = Product::findorfail($id);

        if ($product->featured == 1) {
            Product::where('id', '=', $id)->update(['featured' => "0"]);
            return back()->with('added', __('Featured status set to NO !'));
        } else {
            Product::where('id', '=', $id)->update(['featured' => "1"]);
            return back()->with('added', __('Featured status set to YES !'));
        }
    }

    public function specialoffer($id)
    {
        $spo = SpecialOffer::findorfail($id);

        if ($spo->status == 1) {
            SpecialOffer::where('id', '=', $id)->update(['status' => '0']);
            return back()->with('added', __('Status changed to Deactive !'));
        } else {
            SpecialOffer::where('id', '=', $id)->update(['status' => '1']);
            return back()->with('added', __('Status changed to active !'));
        }
    }

    public function acpstore($id)
    {
        abort_if(!auth()->user()->can('stores.accept.request'), 403, __('User does not have the right permissions.'));

        $store = Store::findorfail($id);

        if ($store->apply_vender == 1) {
            Store::where('id', '=', $id)->update(['status' => '0', 'apply_vender' => "0"]);
            return back()->with('added', __('Store Request not accepted !'));
        } else {
            Store::where('id', '=', $id)->update(['status' => '1', 'apply_vender' => "1"]);
            $store->user()->update([
                'role_id' => 'v',
            ]);
            return back()->with('added', __('Store Request accepted !'));
        }
    }

    public function detail_button_Update($id)
    {
        $ad = DetailAds::findorfail($id);

        if ($ad->status == 1) {
            $ad->status = 0;
        } else {
            $ad->status = 1;
        }

        $ad->save();

        return back()->with('updated', __('Status has been changed !'));
    }

}
