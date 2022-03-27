<?php
namespace App\Http\Controllers;

use App\Allcity;
use App\Allcountry;
use App\Config;
use App\Country;
use App\PinCod;
use App\State;
use App\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Rap2hpoutre\FastExcel\FastExcel;

class PinCodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function enablesystem(Request $request)
    {

        $config = Config::first();

        $config->pincode_system = $request->enable;

        $config->save();

        return 'success';

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $data = PinCod::create($input);

        $data->save();

        return back()
            ->with("category_message", __("Pincode has been created"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PinCod  $pinCod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $user = PinCod::findOrFail($id);

        $user->update($input);

        return back()->with("added", "Pincode has been updated !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PinCod  $pinCod
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = PinCod::find($id);
        $value = $user->delete();
        if ($value) {
            session()->flash("deleted", "Pincode has been deleted !");
            return redirect("admin/pincode");
        }
    }

    public function destination(Request $request)
    {

        $countries = Country::join('allcountry', 'countries.country', '=', 'allcountry.iso3')
            ->select('allcountry.*');

        if ($request->ajax()) {
            return Datatables::of($countries)
                ->addColumn('country', function ($row) {
                    return $row->nicename;
                })
                ->addIndexColumn()
                ->addColumn('country', function ($row) {
                    return $row->nicename;
                })
                ->addColumn('view', function ($row) {

                    $btn = '<a title="'.__('Click to view list of cities').'" href=' . url('/admin/destination/listbycountry/' . $row->id . '/pincode') . ' class="btn btn-primary-rgba btn-sm">View</a>';

                    return $btn;
                })
                ->rawColumns(['country', 'view'])
                ->make(true);

        }

        return view('admin.destination.index');
    }

    public function getDestinationdata(Request $request, $id)
    {

        $country_name = Allcountry::query();

        $country = $country_name->where('id', $id)->first();

        if ($request->ajax()) {

            $data = \DB::table('allcities')->join('allstates', 'allstates.id', '=', 'allcities.state_id')
                ->select('allcities.id as id', 'allcities.name as c', 'allcities.pincode as pincode', 'allstates.name as statename')
                ->where('allstates.country_id', $country->id);

            return Datatables::of($data)
                ->editColumn('checkbox', function ($row) {

                    $chk = "<div class='inline'>
                        <input type='checkbox' form='bulk_export_form' class='filled-in material-checkbox-input' name='checked[]'' value='$row->id' id='checkbox$row->id'>
                        <label for='checkbox$row->id' class='material-checkbox'></label>
                        </div>";

                    return $chk;
                })
                ->addIndexColumn()
                ->addColumn('cityname', function ($row) {
                    return $row->c;
                })
                ->addColumn('statename', function ($row) {
                    return $row->statename;
                })
                ->editColumn('pincode', function ($row) {

                    if (!empty($row->pincode)) {
                        $html = "<span id='show-pincode$row->id'></span><div class='code'><input class='checkPin' s='a' type='text' id='pincode$row->id' name='pincode' value='$row->pincode'>&nbsp;<button id='btnAddProfile$row->id' class='btn btn-xs rounded btn-primary-rgba' onClick='checkPincode($row->id)'><i class='feather icon-edit'></i></button></div>";

                    } else {
                        $html = "<span id='show-pincode$row->id'></span><div class='code'><input class='checkPin' s='a' type='text' id='pincode$row->id' name='pincode' value=''>&nbsp;<button id='btnAddProfile$row->id' onClick='checkPincode($row->id)' class='btn rounded btn-xs btn-success-rgba'><i class='feather icon-plus'></i></button></div>";

                    }

                    return $html;

                })->rawColumns(['checkbox','cityname', 'statename', 'pincode'])
                ->make(true);

        }

        return view('admin.destination.table', compact('country'));

    }

    public function show_destination()
    {
        $city = Allcity::where('pincode', '<>', 'Null')->get();
        $state = State::all();
        $countrys = Country::all();
        return view('admin.destination.show_destination', compact('city', 'state', 'countrys'));
    }

    public function pincode_add(Request $request)
    {
        $data = Allcity::where('id', $request->id)
            ->first();
        Allcity::where('id', $request->id)
            ->update(array(
                'pincode' => $request->code,
            ));
        if ($data) {
            echo $request->code;
        }

    }

    //Front Check
    public function pincode_check(Request $request)
    {
        $pincode = $request->name;
        $len = strlen($pincode);

        if ($len < 6) {
            return 'Invalid Pincode';
        }

        $db_pincod = Allcity::where('pincode', $pincode)->first();

        if (!empty($db_pincod)) {
            if ($db_pincod->pincode == $pincode) {
                return "Delivery is Available";
            } else {
                echo "Delivery is not Available";
            }
        } else {
            echo "Delivery is not Available";
        }
    }

    public function export(Request $request){

        $request->validate([
            'checked' => 'required'
        ],[
            'checked.required' => __("Please select atleast one city in order to export !")
        ]);

        $data = Allcity::whereIn('id',$request->checked)->with(['state:id,name'])->get();

        $filename = 'pincodelist.xlsx';

        (new FastExcel($data))->export($filename, function ($city) {
            return [
                'id'         => $city->id,
                'city_name'  => $city->name,
                'state_name' => $city->state->name,
                'pincode'    => $city->pincode ?? NULL
            ];
        });

        $filePath = public_path().'/'.$filename;

        $fileContent = file_get_contents($filePath);

        try{
            ob_end_clean();
        }catch(\Exception $e){
            // no code
        }

        $response = response($fileContent, 200, [
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);

        unlink(public_path().'/'.$filename);

        return $response;
    }

    public function import(Request $request){
        

        $validator = Validator::make(
            [
                'file' => $request->pincodecsv,
                'extension' => strtolower($request->pincodecsv->getClientOriginalExtension()),
            ],
            [
                'file' => 'required',
                'extension' => 'required|in:xlsx,xls,csv',
            ]

        );

        if ($validator->fails()) {
            return back()->withErrors(__('Invalid file !'));
        }

        if (!$request->has('pincodecsv')) {
            notify()->warning(__('Please choose a file !'));
            return back();
        }

        $fileName = time() . '.' . $request->pincodecsv->getClientOriginalExtension();

        if (!is_dir(public_path() . '/excel')) {
            mkdir(public_path() . '/excel');
        }

        $request->pincodecsv->move(public_path('excel'), $fileName);

        $pincodefile = (new FastExcel)->import(public_path() . '/excel/' . $fileName);

        if (count($pincodefile)) {

            $pincodefile->each(function($pin){

                DB::table('allcities')->where('id',$pin['id'])->update([
                    'pincode' => $pin['pincode'] != '' ? $pin['pincode'] : NULL,
                    'updated_at' => now()
                ]);
                
            });

            return back()->with('added',__('Pincodes has been updated !'));

        }else{

            notify()->warning(__('Your excel file is empty !'));

            if (file_exists(public_path() . '/excel/' . $fileName)) {
                unlink(public_path() . '/excel/' . $fileName);
            }

            return back();

        }

    }
}
