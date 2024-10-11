<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Contracts\Validation\Rule;
use Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    $this->middleware('auth');

    //Middleware for languages
    $this->middleware('Lang');

    }


    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */

    public function index()
    { 
      return view('home');
    }


    //Start Function to get details of a file

    public function file_analysis_ajax_url(Request $request)
    {
      //Start Ajax Check
      if(request()->ajax()) 
      {
            $validation = Validator::make($request->all(), [
            'analysis_file' => ['required'],
    
            ]);
    
            //Start validation Check
            if($validation->passes())
            {
                  $file=$request->file('analysis_file'); 
                    
                  session()->forget('encrypted_file_content');
                  session()->forget('decrypted_file_content');
                    
                  $file_contents=file_get_contents($file->getRealPath());
        
                  $encrypted_file=Crypt::encrypt($file_contents);
        
                  $decrypted_file=Crypt::decrypt($encrypted_file);
        
                  //start show file details
                  $file_name_with_ext=$file->getClientOriginalName();
        
                  $file_name=pathinfo($file_name_with_ext, PATHINFO_FILENAME);
        
                  $file_size=$file->getSize();
                  $human_File_Size=$this->humanFileSize($file_size);
        
                  $file_ext=$file->getClientOriginalExtension();
        
                  //Store encrypted_file_content decrypted_file_content in sessions
        
                  Session::put('encrypted_file_content',[$encrypted_file,$file_ext]);
        
                  Session::put('decrypted_file_content',[$decrypted_file,$file_ext]);
        
                  return [$file_name,$human_File_Size,$file_ext];
              }
          }
        
      }
    
      function humanFileSize($size,$unit="") 
      {
            if( (!$unit && $size >= 1<<30) || $unit == "GB")
            return number_format($size/(1<<30),2)."GB";
            if( (!$unit && $size >= 1<<20) || $unit == "MB")
            return number_format($size/(1<<20),2)."MB";
            if( (!$unit && $size >= 1<<10) || $unit == "KB")
            return number_format($size/(1<<10),2)."KB";
            return number_format($size)." bytes";
      }

      public function file_encrypt_ajax_url(Request $request)
      {
        //Start Ajax Check
        if(request()->ajax()) 
        {
              $encrypted_file_content=session()->get('encrypted_file_content')[0];
    
              $file_ext=session()->get('encrypted_file_content')[1];
              $headers = array(
              'Content-Type: application/'.$file_ext,
              );
              Storage::disk('local')->put('encrypted.'.$file_ext,$encrypted_file_content,$headers);
    
              return trans("pages.encrypted");
        }
      }
    
      public function file_decrypt_ajax_url(Request $request)
      {
            if(request()->ajax()) 
            {
                  $decrypted_file_content=session()->get('decrypted_file_content')[0];
                  $file_ext=session()->get('decrypted_file_content')[1];
                  $headers = array(
                    'Content-Type: application/'.$file_ext,
                  );
                  Storage::disk('local')->put('decrypted.'.$file_ext,$decrypted_file_content,$headers);
        
                  return trans("pages.decrypted");
            }
      }

      public function download($file,$fname=null)
      {
          ob_clean();  
          return response()->download(storage_path('app/'.$file),$fname);
      }
}
 
