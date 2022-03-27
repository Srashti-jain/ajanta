<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategorySlider;
use Illuminate\Support\Facades\Input;


class CategorySliderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:sliders.manage']);
    }
    
    public function get()
    {
        $slider = CategorySlider::first();
        return view('admin.slider.categoryslider', compact('slider'));
    }

    public function post(Request $request)
    {

        $data = CategorySlider::first();
        $input = $request->all();

        if (isset($request->status))
        {
            $input['status'] = 1;
        }
        else
        {
            $input['status'] = 0;
        }

        if (isset($data))
        {
            $data->update($input);
            return back()->with('updated', __('Category Slider has been updated !'));
        }
        else
        {
            $data2 = new CategorySlider();
            $data2->create($input);
            return back()->with('added', __('Category Slider has been created !'));
        }
    }
}

