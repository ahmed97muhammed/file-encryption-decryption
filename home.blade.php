    @extends('index')
    <br><br>
    @section('title',trans('pages.home'))

    @section('content')

<!--Start Container-->
<div class="container">

    <!--start Card-->    
    <div class="card file_analysis_card" style="width:97%;height:68px;padding:5px;height:180px;width:550px;;margin:auto">

    <h5 class="card-title">{{trans("pages.file_analysis")}}</h5>

    <!--start Card Body-->    
    <div class="card-body">

    <!--start Form-->   
    <form method="post"  id="analysisfile_form" enctype="multipart/form-data">
      @csrf
      <label>{{trans('pages.choose_file')}}<span style="color:red;font-size:18px;">*</span></label>
      
      <label class="btn btn-default btn-file" style="height:30px;font-size:10px;">
      {{trans("pages.browse")}} <input type="file" name="analysis_file" id="analysis_file"  >
     </label>
     <br>
     <!-- Start Panel to show file details (file name, file size, file extension) -->

     <div class="panel panel-info file_details" style="display:none">
      <p>{{trans("pages.filename")}} <span class="filename"> </span></p>
      <p>{{trans("pages.filesize")}} <span class="filesize"></span></p>
      <p >{{trans("pages.fileextension")}} <span class="fileextension"></span></p>
     </div>

     <!-- End Panel to show file details (file name, file size, file extension) -->
      <p class="print_result" style="display:none">{{trans("pages.result")}} <span class="result"></span></p>

     <!--Encrypt file btn --->
     <button id="encrypt_file" type="button" class="btn btn-info" style="height:30px;font-size:10px;display:none;margin:5px">{{trans('pages.encrypt_file')}}</button>

     <a id="down_enc" style="height:30px;font-size:10px;display:none;margin:5px" class="btn btn-info downloadfile" href="{{url('/download/encrypted.txt')}}">{{trans("pages.downlaod_enc_file")}} <i class="fa fa-download" aria-hidden="true"></i></a>

   
     <!--Decrypt file btn --->
     
     <button  type="button" id="decrypt_file" class="btn btn-info" style="height:30px;font-size:10px;display:none;margin:5px">{{trans('pages.decrypt_file')}}</button>

     <a id="down_dec" style="height:30px;font-size:10px;display:none;margin:5px" class="btn btn-info downloadfile" href="{{url('/download/decrypted.txt')}}">{{trans("pages.downlaod_dec_file")}} <i class="fa fa-download" aria-hidden="true"></i></a>

    </form>
  <!--End Form -->   

    </div>
    <!--End Card Body-->   
    
    </div>
    <!--End Card--> 



</div>
<!--End Container-->


  <!-- Modal To Download File-->
  <div @if(lang()=='en') style="margin-top:60px;direction:ltr" @endif  @if(lang()=='ar') style="margin-top:60px;direction:rtl" @endif class="modal fade" id="downloadfile_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
  <div class="modal-header">
  @if(lang()=='ar') 
  <h5 class="modal-title" id="exampleModalLabel">{{trans('pages.downloadfile')}}<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
  </button></h5>
  @endif
  @if(lang()=='en') 
  <h5 class="modal-title" id="exampleModalLabel">{{trans('pages.downloadfile')}}</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
  </button>

  @endif

  </div>
  <div class="modal-body">
  
  <input type="text" style="display:none"   class="form-control " id="file_status" >  

  <div class="row">

  <div class="col-md-12">
  <label>{{trans('pages.filename')}}<span style="color:red;">*</span></label>
  <input type="text"   class="form-control filename" >
  
  </div>

  </div>

  </div>
  <div class="modal-footer" @if(lang()=='ar') style="direction:ltr !important"  @endif>
  
  <a id="download_now"  style="height:30px;font-size:10px;display:none;margin:5px" class="btn btn-info">{{trans("pages.download")}} <i class="fa fa-download" aria-hidden="true"></i></a>
  </div>
  </div>
  </div>
  </div>

  <!-- Modal To Download File-->


    @endsection