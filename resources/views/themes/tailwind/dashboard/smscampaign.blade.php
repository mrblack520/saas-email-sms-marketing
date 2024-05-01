@extends('theme::layouts.dashboard')

@section('content')

{{-- <div class="flex items-center justify-center min-h-screen">

        <form class="w-full max-w-lg" action="{{ route('send-sms') }}" enctype="multipart/form-data" method="POST">
            @csrf
        <div class="flex flex-wrap -mx-3 mb-6">
          <div class="w-full px-3">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
              Number
            </label>
            <input name="number" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="email" type="text ">

          </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
          <div class="w-full px-3">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
              Message
            </label>
            <textarea name="message" class=" no-resize appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 h-48 resize-none" id="message"></textarea>
          </div>
        </div>
        <div class="md:flex md:items-center">
         <div class="md:w-1/3">
    <button type="submit" class="shadow bg-teal-400 hover:bg-teal-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="button">
        Send
    </button>

  </div>




  <div class="flex w-full  border-transparent w-100 justify-center">
    <div id="multi-upload-button"
        class="inline-flex items-center  px-4 py-2 bg-gray-600 border border-gray-600 rounded-l font-semibold cursor-pointer text-sm text-white tracking-widest hover:bg-gray-500 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ">
        Click to browse
    </div>
    <div class="w-4/12 lg:w-3/12 border border-gray-300 rounded-r-md flex items-center justify-between">
        <span id="multi-upload-text" class="p-2"></span>
        <button id="multi-upload-delete" class="hidden" onclick="removeMultiUpload()">
            <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-red-700 w-3 h-3" viewBox="0 0 320 512">
                <path
                    d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z" />
            </svg>
        </button>
    </div>

    <input type="file" name="csv_file" accept=".csv" id="multi-upload-input" class="hidden" multiple/>
</div>


          <div class="md:w-2/3"></div>
        </div>
      </form>
    </div>



 --}}
 <div class="row">
    <div class="col-lg-11">
        <div class="card">
            <div class="card-body">

                <div class=" ms-0 ms-sm-0 ms-sm-0">

                    <div class="compose-content dropzone">
        <form  action="{{ route('send-sms') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="form-group">

                                <input type="text" name="number" class="form-control bg-transparent" placeholder="Enter Numbers:">
                            </div>

                            <div class="form-group">
                                <textarea id="email-compose-editor" name="message" class="textarea_editor form-control bg-transparent" rows="12" placeholder="Enter text ..."></textarea>

                            </div>

                        <h5 class="mb-4"><i class="fa fa-paperclip"></i> Attatchment</h5>

                        <label for="formFileLg" class="form-label">Large file input example</label>
                        <input name="csv_file" accept=".csv" class="form-control form-control-lg" id="fileNamePlaceholder" type="file" />
                    </div>
                    <div class="text-left mt-4">
                        <button class="btn btn-primary btn-sl-sm me-2" type="submit"><span class="me-2"><i class="fa fa-paper-plane"></i></span>Send</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
