<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modal\Category1;
use App\Modal\Category2;
use App\Modal\Negeri;
use App\Modal\Location;
use App\Modal\Respon;
use App\Modal\Borang;
use Auth;
use URL;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataExport;

class LocationController extends Controller
{
    public function main()
    {   
        if(Auth::user()->usertype == -1){
            $location = DB::table('location')->selectRaw('location.*, borang.nama')->leftJoin('borang','borang.id','=','location.borang')->where([['location.remove','=','0']])->orderBy('nama_premis','asc')->get();
        }else{
            $user_id = Auth::user()->id;
            $location = DB::table('location')->selectRaw('location.*, borang.nama')->leftJoin('borang','borang.id','=','location.borang')->where([['location.remove','=','0'],['location.user_id', '=', $user_id]])->orderBy('nama_premis','asc')->get();
        }
        // $module_list = json_encode(Module::all());
        // print_r($module_list); exit;
        $variables = array();
        $variables['location_list'] = $location;

        $variables['ciphering'] = 'AES-128-CTR';
        // Use OpenSSl Encryption method 
        $iv_length = openssl_cipher_iv_length($variables['ciphering']); 
        $variables['options'] = 0;
        $variables['encryption_iv'] = '1234567891011121';
        $variables['encryption_key'] = "RTC-821-SEA";
        
        return view('admin.location', $variables);
    }

    public function kategori1_list()
    {
        return Category1::select(['id','description'])->where('remove','=','0')->orderBy('description','asc')->get();
    }

    public function kategori2_list()
    {
        return Category2::select(['id','description'])->where('remove','=','0')->orderBy('description','asc')->get();
    }

    public function negeri_list()
    {
        return Negeri::select(['name'])->where('remove','=','0')->orderBy('name','asc')->get();
    }

    public function borang_list()
    {
        return Borang::select(['id','nama'])->where('remove','=','0')->orderBy('nama','asc')->get();
    }

    public function single_details($location_id)
    {
        if(is_numeric($location_id)){
            $user_id = Auth::user()->id;
            $usertype = Auth::user()->usertype;
            if($usertype == -1){
                $data = Location::where([['remove','=','0'], ['id','=',$location_id]])->first();
            }else{
                $data = Location::where([['remove','=','0'], ['user_id','=',$user_id], ['id','=',$location_id]])->first();
            }

            if(empty($data)){
                return redirect('/location')->with('status_error','Record not found!');
            }else{
                return json_encode($data);
            }
            
        }else{
            return redirect('/location')->with('status_error','Not valid request!');
        }
    }

    public function create()
    {   
        $variables = array();

        $category_1 = $this->kategori1_list();
        $category_2 = $this->kategori2_list();
        $negeri = $this->negeri_list();
        $borang = $this->borang_list();

        $variables['kategori_1'] = $category_1;
        $variables['kategori_2'] = $category_2;
        $variables['negeri'] = $negeri;
        $variables['borang'] = $borang;

        return view('admin.location_create', $variables);
    }

    public function save(Request $request)
    {   
        // echo '<pre>';
        // var_dump($request->input()); 
        // echo '</pre>';
        // exit;

        $user_id = Auth::user()->id;

        $nama_premis = $request->input('nama_premis');
        $kategori_1 = $request->input('kategori_1');
        $kategori_2 = $request->input('kategori_2');
        $tel_premis = $request->input('tel_premis');
        $nama_bangunan = $request->input('nama_bangunan');
        $no_jalan = $request->input('no_jalan');
        $nama_jalan = $request->input('nama_jalan');
        $poskod = $request->input('poskod');
        $kawasan = $request->input('kawasan');
        $bandar = $request->input('bandar');
        $negeri = $request->input('negeri');
        $borang = $request->input('borang');
        $type = $request->input('type');
        $date = date(now());

        $record = Location::insert(
            [
                'nama_premis' => $nama_premis,
                'kategori_1' => $kategori_1,
                'kategori_2' => $kategori_2,
                'tel_premis' => $tel_premis,
                'nama_bangunan' => $nama_bangunan,
                'no_jalan' => $no_jalan,
                'nama_jalan' => $nama_jalan,
                'poskod' => $poskod,
                'kawasan' => $kawasan,
                'bandar' => $bandar,
                'negeri' => $negeri,
                'borang' => $borang,
                'type' => $type,
                'user_id' => $user_id,
                'created_at' => $date,
                'updated_at' => $date
            ]
        );

        if($record){
            return redirect('/location')->with('status','Successful!');
        }else{
            return redirect('/location/create')->with('status_error','Failed to save!');
        }
        
    }

    public function edit($location_id)
    {
        $data = json_decode($this->single_details($location_id),false);

        $variables['location_id'] = $data->id;
        $variables['nama_premis'] = $data->nama_premis;
        $variables['kategori1'] = $data->kategori_1;
        $variables['kategori2'] = $data->kategori_2;
        $variables['tel_premis'] = $data->tel_premis;
        $variables['nama_bangunan'] = $data->nama_bangunan;
        $variables['no_jalan'] = $data->no_jalan;
        $variables['nama_jalan'] = $data->nama_jalan;
        $variables['poskod'] = $data->poskod;
        $variables['kawasan'] = $data->kawasan;
        $variables['bandar'] = $data->bandar;
        $variables['negeri_'] = $data->negeri;
        $variables['borang'] = $data->borang;
        $variables['type'] = $data->type;

        $variables['kategori_1'] = $this->kategori1_list();
        $variables['kategori_2'] = $this->kategori2_list();
        $variables['negeri'] = $this->negeri_list();
        $variables['borang_list'] = $this->borang_list();

        return view('admin.location_edit', $variables);
    }

    public function update(Request $request)
    {
        $user_id = Auth::user()->id;
        // echo '<pre>';
        // var_dump($request->input()); 
        // echo '</pre>';
        // exit;
        $location_id = $request->input('location_id');
        $nama_premis = $request->input('nama_premis');
        $kategori_1 = $request->input('kategori_1');
        $kategori_2 = $request->input('kategori_2');
        $tel_premis = $request->input('tel_premis');
        $nama_bangunan = $request->input('nama_bangunan');
        $no_jalan = $request->input('no_jalan');
        $nama_jalan = $request->input('nama_jalan');
        $poskod = $request->input('poskod');
        $kawasan = $request->input('kawasan');
        $bandar = $request->input('bandar');
        $negeri = $request->input('negeri');
        $borang = $request->input('borang');
        $type = $request->input('type');
        $date = date(now());

        $record = Location::where('id', $location_id)
            ->update(['nama_premis'=>$nama_premis, 'kategori_1'=>$kategori_1,
                'kategori_2'=>$kategori_2, 'tel_premis'=>$tel_premis,
                'nama_bangunan'=>$nama_bangunan, 'no_jalan'=>$no_jalan,
                'nama_jalan'=>$nama_jalan, 'poskod'=>$poskod,
                'kawasan'=>$kawasan, 'bandar'=>$bandar,
                'negeri'=>$negeri, 'borang'=>$borang,
                'type'=>$type, 'updated_at'=>$date
            ]);

        if($record){
            return redirect('/location')->with('status','Successful updated!');
        }else{
            return redirect('/location')->with('status_error','Failed to update!');
        }
    }

    public function delete($location_id)
    {
        if(empty($location_id) || !is_numeric($location_id)){
            return redirect('/location')->with('status_error','Failed to delete!');
        }

        $user_id = Auth::user()->id;
        $usertype = Auth::user()->usertype;

        if($usertype == -1){
            $record = Location::where(['id'=>$location_id])->update(['remove'=>1]);
        }else{
            $record = Location::where(['user_id'=>$user_id, 'id'=>$location_id])->update(['remove'=>1]);
        }

        if($record){
            return redirect('/location')->with('status','Successful removed!');
        }else{
            return redirect('/location')->with('status_error','Failed to remove!');
        }
        
    }

    public function generateQR($hash)
    {   
        // $user_id = Auth::user()->id;
        $usertype = Auth::user()->usertype;

        if(empty($hash)){
            return redirect('/location')->with('status_error','Failed to generate QR Code!');
        }

        $encryption = $hash;
        $ciphering = 'AES-128-CTR';
        $iv_length = openssl_cipher_iv_length($ciphering); 
        $options = 0;
        $decryption_iv = '1234567891011121';
        $decryption_key = "RTC-821-SEA";

        $decryption=openssl_decrypt ($encryption, $ciphering, $decryption_key, $options, $decryption_iv); 

        $result = explode('|', $decryption);

        if(count($result) == 3)
        {
            $location_id = $result[0];
            $user_id = $result[1];
            $time = $result[2];

            if(($user_id == Auth::user()->id || $usertype == -1) && !empty($location_id)){
                $data = $this->single_details($location_id);
                $data = json_decode($data, true);
                
                $id = $data['id'];
                $nama_premis = $data['nama_premis'];
                $tel_premis = $data['tel_premis'];
                $poskod = $data['poskod'];

                $curl = curl_init();

                // $urlTesting = $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];
                $base_url = URL::to('/');

                if($data['borang'] == 1)
                {
                    $urlforQR = urlencode($base_url.'/form/staff/'.md5($location_id));
                }else if($data['borang'] == 2){
                    $urlforQR = urlencode($base_url.'/form/'.md5($location_id));
                }else{
                    $urlforQR = urlencode($base_url.'/form/kontraktor/'.md5($location_id));
                }

                $main_url = "https://chart.googleapis.com/chart";
                $chart_type = "cht=qr";
                $chart_size = "chs=500x500";
                // $chart_link = "chl=http%253A%252F%252Flocalhost%253A8000%252Fform%252F1";
                $chart_link = "chl=".$urlforQR;
                $combine = $main_url.'?'.$chart_type.'&'.$chart_size.'&'.$chart_link;

                // var_dump($combine); exit;

                curl_setopt_array($curl, array(
                CURLOPT_URL => $combine,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                $image = $response;
                $variables['QRimage'] = 'data:image/png;base64,'.base64_encode($image);
                
                if($usertype == -1){
                    $record = Location::where(['id'=>$location_id, 'remove'=>0])->first();
                }else{
                    $record = Location::where(['user_id'=>$user_id, 'id'=>$location_id, 'remove'=>0])->first();
                }
                // array_push($variables, $record);
                // var_dump($variables); exit;
                // var_dump($record); exit;
                $variables['data'] = $record;

                return view('admin.location_generate', $variables);
            }else{
                return redirect('/location')->with('status_error','Not authenticate user!');
            }

        }else{
            return redirect('/location')->with('status_error','Failed to generate QR Code!');
        }

        // var_dump($result); exit;
    }

    public function getdata($location_id, Request $request)
    {
        if(empty($request->input('date_from')) || empty($request->input('date_to'))){
            return redirect('/location')->with('status_error','Failed to get data. Date Range required!');
        }
        
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to');

        $location_details = Location::whereRaw('md5(id) = "'.$location_id.'"')->first();
        $borang_type = $location_details['borang'];

        // echo '<pre>';
        // var_dump($location_details);
        // echo '</pre>'; 
        // exit;
        
        $file_name = date('Y-m-d-',time()).str_replace(' ', '_', $location_details['nama_premis']);

        if($borang_type == 3){
            $record = DB::table('respon_kontraktor')
            ->leftJoin('location', 'location.id', 'respon_kontraktor.form_id')
            ->select('respon_kontraktor.id', 'respon_kontraktor.nama', 'respon_kontraktor.no_tel', 'respon_kontraktor.suhu', 'respon_kontraktor.created_at', 'location.nama_premis', 'location.nama_bangunan', 'location.kawasan', 'location.poskod', 'location.negeri')
            ->whereRaw('md5(form_id) = "'.$location_id.'" AND (respon_kontraktor.created_at >= "'.$date_from.' 00:00:00" AND respon_kontraktor.created_at <= "'.$date_to.' 23:59:59")')
            ->get();
        }elseif($borang_type == 1){
            $record = DB::table('respon_staff')
            ->leftJoin('location', 'location.id', 'respon_staff.form_id')
            ->select('respon_staff.id', 'respon_staff.nama', 'respon_staff.no_pekerja', DB::raw('IF(respon_staff.vaksin=1,"YA","TIDAK") AS vaksin'), 'respon_staff.pusat_vaksin1', 'respon_staff.dos1', 'respon_staff.jenis_vaksin_1', 'respon_staff.pusat_vaksin2', 'respon_staff.dos2', 'respon_staff.jenis_vaksin_2', 'respon_staff.pusat_booster', 'respon_staff.jenis_booster', 'respon_staff.booster1', 'respon_staff.clockin', 'respon_staff.clockout', 'respon_staff.jabatan', 'respon_staff.lokasi', 'respon_staff.suhu', DB::raw('DATE(respon_staff.created_at) as created_at, TIME(respon_staff.created_at) as time_at'), 'location.nama_premis', 'location.nama_bangunan', 'location.kawasan', 'location.poskod', 'location.negeri')
            ->whereRaw('md5(form_id) = "'.$location_id.'" AND (respon_staff.created_at >= "'.$date_from.' 00:00:00" AND respon_staff.created_at <= "'.$date_to.' 23:59:59")')
            ->get();
        }else{
            $record = DB::table('respon')
            ->leftJoin('location', 'location.id', 'respon.form_id')
            ->select('respon.id', 'respon.name', 'respon.phone AS no_pekerja/phone', 'respon.suhu', 'respon.created_at', 'location.nama_premis', 'location.nama_bangunan', 'location.kawasan', 'location.poskod', 'location.negeri')
            ->whereRaw('md5(form_id) = "'.$location_id.'" AND (respon.created_at >= "'.$date_from.' 00:00:00" AND respon.created_at <= "'.$date_to.' 23:59:59")')
            ->get();
        }
        
        // echo '<pre>';
        // var_dump($record); 
        // echo '</pre>'; 
        // exit;

        if(count($record) > 0){

            $columns = array_keys(json_decode(json_encode($record[0]), true));
            // echo '<pre>';
            // var_dump($columns); 
            // echo '</pre>'; 
            // exit;
            foreach ($record as $key) {
                $data[] = array_values(json_decode(json_encode($key), true)); 
            }

            // var_dump($data); exit;

            $export = new DataExport([
                $columns,
                $data
            ]);
        
            return Excel::download($export, $file_name.'.xlsx');
        }else{
            return redirect('/location')->with('status_error','No record(s) found!');
        }
    }
}
