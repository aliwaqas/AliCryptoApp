<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Countrylist;
use App\Models\Form;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use DataTables;
use Image;
use Illuminate\Support\Facades\DB;



class SettingController extends Controller
{
    public function ImportCountry()
    {

        $json =  Http::get('https://restcountries.eu/rest/v2/');  /// country details api path
        $upload_path = '/settings/flags/';   /// save img path

        $data =  json_decode($json , true);

        // foreach to import into table products
        foreach ($data as $key => $obj) {

            $foundData = Countrylist::where('slug', $obj['alpha2Code'] )->first();
            $importSlug = '';

            if (!$foundData) {
                $flaglink = file_get_contents('https://www.countryflags.io/'.$obj['alpha2Code'].'/shiny/64.png');
                $filename = $obj['alpha2Code'].'-'.time().'.png';
                Image::make($flaglink)->save(public_path($upload_path . $filename));

                $imgFile  = $upload_path . $filename;

                DB::table('countrylists')->insert([
                    'slug' => $obj['alpha2Code'],
                    'name' => $obj['name'],
                    'time_zone' => $obj['timezones'][0],
                    'details' => $obj['alpha2Code'],
                    'is_active' => 1,
                    'img' => $imgFile,
                ]);
                $importSlug = $importSlug.'<br'. $obj['alpha2Code'];
            }



        }
        return $importSlug;
    }

    public function test()
    {

        $data = geoip($ip = '59.103.190.86');
        dd($data);
    }
    public function index()
    {
        //$arr_ip = geoip_time_zone_by_country_and_region('JP', '01'); //geoip()->getLocation('232.223.11.11');
        //dd($arr_ip);



        if (Auth::guest())
        {

            return redirect()->route('admin.home');

        }
        else
        {
            $result = Countrylist::all();

            return view('settings.country',compact('result'));
        }
    }
    // GET ALL COUNTRIES
    public function getCountriesList(Request $request){

            $countries = Countrylist::where('is_active', '!=' , 0)->orWhereNull('is_active')->get();
            foreach($countries as $country)
            {
                $country['is_active'] = $country['is_active'];
                if($country['is_active'] == 1)
                {
                    $country['is_active'] = 'Active';
                }
                if($country['is_active'] == 2)
                {
                    $country['is_active'] = 'Inactive';
                }

            }

            //return $countries;
            return DataTables::of($countries)
                    ->addIndexColumn()
                    ->addColumn('actions', function($row){
                        return '<div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item userUpdate" data-toggle="modal" data-id="'.$row['id'].'" data-target="#edit_user"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item userDelete" data-id="'.$row['id'].'"   ><i class="fa fa-trash-o m-r-5"></i> Delete</a>

                                    </div>
                                </div>';
                    })
                    ->addColumn('flagImg', function($row){
                        return '<h2 class="table-avatar">
                                    <a href="profile.html" class=""><img src="'.$row['img'].'" alt="" style="width:40px"></a>
                                </h2>';
                    })
                    ->addColumn('statusBtn', function($row){

                        if($row['is_active'] == 'Active')
                        {
                            $btnCode = ' <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false" data-id="'.$row['id'].'" >
                                        <i class="fa fa-dot-circle-o text-success"></i>
                                        <span class="statuss">Active</span>
                                    </a>';


                        }
                        elseif($row['is_active'] == 'Inactive')
                        {

                            $btnCode = ' <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false" data-id="'.$row['id'].'" >
                                        <i class="fa fa-dot-circle-o text-info"></i>
                                        <span class="statuss">Inactive</span>
                                 </a>';
                        }

                        else
                        {
                            $btnCode = '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-dot-circle-o text-dark"></i>
                                            <span class="statuss">N/A</span>
                                        </a>';
                        }

                        return '<div class="dropdown action-label">'.$btnCode.'
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a  class="activeStatus dropdown-item" data-status="Active" data-id="'.$row['id'].'" >
                                            <i class="fa fa-dot-circle-o text-success"></i> Active
                                        </a>
                                        <a  class="activeStatus dropdown-item" data-status="Inactive" data-id="'.$row['id'].'" >
                                            <i class="fa fa-dot-circle-o text-warning"></i> Inactive
                                        </a>

                                    </div>
                                </div>';
                    })


                    ->rawColumns(['actions','statusBtn','flagImg'])
                    ->make(true);
    }
    //UPDATE COUNTRY Status
    public function updateCountryStatus(Request $request){

        $validator = Validator::make($request->all(),[
            'rowID'=>'required',
            'status'=>'required'
        ]);

        if(!$validator->passes()){
               return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $country_id = $request->rowID;
            $status = $request->status;
            if($status == 'Active')
            {
               $updateStatus = 1;
            }
            else
            {
                $updateStatus = 2;
            }
            $country = Countrylist::find($country_id);
            $country->is_active = $updateStatus;
            $query = $country->save();

            if($query){
                return response()->json(['code'=>200, 'msg'=>'Country Details have Been updated']);
            }else{
                return response()->json(['code'=>0, 'msg'=>'Something went wrong']);
            }
        }
    }
    //UPDATE COUNTRY Details
    public function updateCountryDetails(Request $request){
        return response()->json(['code'=>1, 'msg'=>'Country Details have Been updated']);
        $validator = Validator::make($request->all(),[
            'rowID'=>'required',
            'status'=>'required'
        ]);

        if(!$validator->passes()){
               return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $country_id = $request->rowID;
            $status = $request->status;
            if($status == 'Active')
            {
               $updateStatus = 1;
            }
            else
            {
                $updateStatus = 2;
            }
            $country = Countrylist::find($country_id);
            $country->is_active = $updateStatus;
            $query = $country->save();

            if($query){
                return response()->json(['code'=>1, 'msg'=>'Country Details have Been updated']);
            }else{
                return response()->json(['code'=>0, 'msg'=>'Something went wrong']);
            }
        }
    }
    //ADD NEW COUNTRY
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'slug' => 'required|unique:countrylists|max:4',
                'name' => 'required|max:150',
                'details' => 'required|max:150',
                'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message'=> $validator->messages()
                  ]);
            }
            else
            {
                $image = $request->file('img');
                $filename = $request->input('slug').'-'.time().'.'.$image->getClientOriginalExtension();
                $upload_path = public_path('settings/flags'); //Creating Sub directory in Public folder to put image
                $imgFile = Image::make($image->getRealPath());

                $imgFile->resize(64, 64, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($upload_path.'/'.$filename);

                $image_url =  '/settings/flags/'.$filename;

                $countrylist = new Countrylist;

                $countrylist->slug = $request->input('slug');
                $countrylist->name = $request->input('name');
                $countrylist->img = $image_url;
                $countrylist->details = $request->input('details');
                $countrylist->is_active = 1;
                $countrylist->time_zone = 'sadasdas';
                $query = $countrylist->save();


                if(!$query){
                    return response()->json(['status'=>0,'msg'=>'Something went wrong']);
                }else{
                    return response()->json(['status'=>200,'msg'=>'New Country has been successfully saved']);
                }

            }

        }catch(\Exception $e)
        {

        }






    }
    // DELETE COUNTRY RECORD
    public function deleteCountry(Request $request)
    {
        $country_id = $request->dataID;
        $query = Countrylist::find($country_id)->delete();

        if($query){
            return response()->json(['code'=>1, 'msg'=>'Country has been deleted from database']);
        }else{
            return response()->json(['code'=>0, 'msg'=>'Something went wrong']);
        }
    }

    ///================================================================End Country Settings =================================================================
    //................................................................
    //================================================================Start Country Zone  Settings ==========================================================
}
