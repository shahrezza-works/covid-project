<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modal\Location;
use App\Modal\Respon;
use Auth;
use DB;

class TemperatureController extends Controller
{

    public function index(Request $request)
    {
        if(Auth::user()->usertype == -1){
            $location = Location::where([['remove','=','0']])->orderBy('nama_premis','asc')->get();
        }else{
            $user_id = Auth::user()->id;
            $location = Location::where([['remove','=','0'],['user_id', '=', $user_id]])->orderBy('nama_premis','asc')->get();
        }
        // var_dump($location); exit;
        $variables['location'] = $location;
        $variables['location_select'] = $request->get('location_selected');
        $variables['date_select'] = date('Y-m-d');
        $variables['table_data'] = array();
        return view('admin.respon', $variables);
    }

    public function temperature(Request $request)
    {
        if(Auth::user()->usertype == -1){
            $location = Location::where([['remove','=','0']])->orderBy('nama_premis','asc')->get();
        }else{
            $user_id = Auth::user()->id;
            $location = Location::where([['remove','=','0'],['user_id', '=', $user_id]])->orderBy('nama_premis','asc')->get();
        }
        // var_dump($location); exit;
        $variables['location'] = $location;
        $variables['location_select'] = $request->get('location_selected');
        $variables['date_select'] = date('Y-m-d');
        $variables['table_data'] = array();
        return view('admin.respon', $variables);
    }

    public function filter(Request $request)
    {
        // var_dump($request->input('location_select'));
        // exit;
        $user_id = Auth::user()->id;
        $location_select = $request->input('location_select');
        $tarikh = $request->input('tarikh');

        if(Auth::user()->usertype == -1){
            $location = Location::where([['remove','=','0']])->orderBy('nama_premis','asc')->get();
        }else{
            $user_id = Auth::user()->id;
            $location = Location::where([['remove','=','0'],['user_id', '=', $user_id]])->orderBy('nama_premis','asc')->get();
        }
        // var_dump($location); exit;
        $variables['location'] = $location;
        $variables['location_select'] = $location_select;

        if(Auth::user()->usertype != -1){
            $verify_access = Location::where([['remove','=','0'],['user_id', '=', $user_id],['id','=',$location_select]])->orderBy('nama_premis','asc')->first();

            if(empty($verify_access)){
                return redirect('/temperature');
            }
        }

        $data = DB::table('respon')->whereRaw('form_id = '.$location_select.' AND DATE(created_at) = "'.$tarikh.'"')->orderBy('name','asc')->get();
        // var_dump($data); exit;
        $variables['table_data'] = $data;
        $variables['date_select'] = $tarikh;
        // return view('temperature');
        return view('admin.respon', $variables);
    }

    public function details(Request $request)
    {
        // var_dump($request->get('rid'));
        $respon_id = $request->get('rid');

        if(empty($respon_id)){
            return array('status'=>false,'message'=>'Failed to get information!');
        }

        $data = DB::table('respon')->whereRaw('id = '.$respon_id)->get();

        if(empty($data)){
            return array('status'=>false,'message'=>'Record not exist!');
        }

        return array('status'=>true, 'message'=>'Successful!', 'data'=>$data);

    }

    public function update(Request $request)
    {  
        $respon_id = $request->get('respon_id');
        $_token = $request->get('_token');
        $location_select = $request->get('location_select');
        $tarikh = $request->get('tarikh');
        $suhu = $request->get('suhu');
        $date = date(now());

        $record = Respon::where('id', $respon_id)->update(['suhu'=>$suhu, 'updated_at'=>$date]);

        if($record){
            return redirect('/temperature/filter?_token='.$_token.'&location_select='.$location_select.'&tarikh='.$tarikh)->with('status','Successful update!');
        }else{
            return redirect('/temperature/filter?_token='.$_token.'&location_select='.$location_select.'&tarikh='.$tarikh)->with('status_error','Failed to update!');
        }
    }
}
