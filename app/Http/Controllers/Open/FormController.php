<?php

namespace App\Http\Controllers\Open;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modal\Location;
use App\Modal\Respon;
use DB;

class FormController extends Controller
{
    public function main($unique_id)
    {   
        //Generate form here
        // $location = Location::where('md5(id) = "'.$unique_id.'"')->first();
        $location = DB::table('location')->whereRaw('md5(id) = "'.$unique_id.'"')->first();
        // echo '<pre>';
        // var_dump($location); 
        // echo '</pre>';

        $variables['location_id'] = $location->id;
        $variables['nama_premis'] = $location->nama_premis;
        $variables['nama_bangunan'] = $location->nama_bangunan;
        $variables['kawasan'] = $location->kawasan;
        // exit;
        return view('open.form', $variables);
    }

    public function submit($location_id, Request $request)
    {
        // var_dump($location_id);
        // echo '<pre>';
        // var_dump($request->input()); 
        // echo '</pre>';
        // exit;

        if($location_id != $request->lid){
            return view('open.errorsubmit');
        }

        $location = DB::table('location')->whereRaw('md5(id) = "'.$location_id.'"')->first();

        if(empty($location)){
            return view('open.errorsubmit');
        }

        $id = $location->id;
        $nama = $request->input('nama');
        $no_tel = $request->input('no_tel');
        $verify = $request->input('verify');
        $agree = $request->input('agree');
        $date = date(now());

        $duplicate = DB::table('respon')->whereRaw('md5(form_id) = "'.$location_id.'" 
        AND phone = "'.$no_tel.'" AND DATE(created_at) = DATE("'.$date.'")')->first();

        if(!empty($duplicate)){
            return redirect('/form/'.$location_id)->with('status_error','Pendaftaran Tidak Berjaya. Nombor telefon yang dimasukkan telah didaftarkan hari ini!');
        }

        $record = Respon::insert(
            [
                'form_id' => $id,
                'name' => $nama,
                'phone' => $no_tel,
                'verify' => $verify,
                'agree' => $agree,
                'created_at' => $date,
                'updated_at' => $date,
            ]
        );

        $variables['nama_premis'] = $location->nama_premis;
        $variables['nama_bangunan'] = $location->nama_bangunan;
        $variables['kawasan'] = $location->kawasan;
        $variables['waktu_pendaftaran'] = date('d M Y (h:i a)', time());
        $variables['no_tel'] = $no_tel;

        if($record){
            return redirect('/form/receipt/summary?loc='.$location_id.'&t='.time().'&p='.urlencode($no_tel));
        }else{
            return view('open.errorsubmit');
        }
    }

    public function receipt(Request $request)
    {   
        $location_id = $request->get('loc');
        $time = $request->get('t');
        $phone = $request->get('p');

        if(empty($location_id) || empty($time)){
            return view('open.errorsubmit');
        }

        $location = DB::table('location')->whereRaw('md5(id) = "'.$location_id.'"')->first();

        $variables['nama_premis'] = $location->nama_premis;
        $variables['nama_bangunan'] = $location->nama_bangunan;
        $variables['kawasan'] = $location->kawasan;
        $variables['waktu_pendaftaran'] = date('d M Y (h:i a)', $time);
        $variables['no_tel'] = $phone;
        
        return view('open.success', $variables);
    }
}
