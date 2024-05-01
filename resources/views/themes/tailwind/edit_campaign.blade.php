@extends('theme::layouts.dashboard')




@section('content')
<div class="row">
    <div class="col-lg-11">
        <div class="card bg-transparent ">

<div class="text-left mt-4">
    <a class="btn btn-primary btn-sl-sm me-2" href="{{route('template.index', ['id' => $latestRecord->id])}}"><span class="me-2"><i class="fa fa-paper-plane"></i></span>Create Template</a>
</div>

        </div>
    </div>
    <input type="hidden" id="campid" data-id="{{ $latestRecord->id }}" name="campID" value="{{ $latestRecord->id }}">

    <span id="table" class="table-editable">
        <span class="table-add float-right mb-3 mr-2"
          >Campaning title</span>
        <table class="table table-bordered table-responsive-md table-striped text-center">

          <tbody>
            <tr>
              <td class="pt-3-half" contenteditable="true">{{ $latestRecord->campaign_name }}</td>

             </tr>

          </tbody>
        </table>
      </span>
</div>

<div class="row">
    <div class="col-lg-11">
        <div class="card">
            <div class="card-body">

                <div class=" ms-0 ms-sm-0 ms-sm-0">

                    <div class="compose-content dropzone">
                        <form action="{{Route('Send.email')}}" method="POST"  enctype="multipart/form-data">
                            @csrf


                                <input type="text" name="to" class="form-control bg-transparent" placeholder=" To:">
                            </div>
                            <div class="form-group">
                                <input name="subject" type="text" class="form-control bg-transparent" placeholder=" Subject:">
                            </div>
                            <div class="form-group">
                                {{-- <textarea id="email-compose-editor" class="textarea_editor form-control bg-transparent" placeholder="Enter text ..."></textarea> --}}
                <textarea id="body" name="content" class="ckeditor textarea_editor form-control bg-transparent"  rows="8"  placeholder="Message..."></textarea>

                            </div>

                        <h5 class="mb-4"><i class="fa fa-paperclip"></i> Attatchment</h5>

                        <label for="formFileLg" class="form-label">Large file input example</label>
                        <input class="form-control form-control-lg" accept=".csv" id="fileNamePlaceholder" type="file" />
                    </div>
                    <div class="text-left mt-4">
                        <button class="btn btn-primary btn-sl-sm me-2" type="submit"><span class="me-2"><i class="fa fa-paper-plane"></i></span>Send</button>
                        <button class="btn btn-danger light btn-sl-sm" type="button"><span class="me-2"><i class="fa fa-times" aria-hidden="true"></i></span>Discard</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

<script>

  document.addEventListener('DOMContentLoaded', function () {

    const ckeditorInstance = CKEDITOR.instances['body'];


    if (ckeditorInstance) {

      const designHtml = localStorage.getItem('designHtml');

      if (designHtml !== null && designHtml !== undefined) {

        ckeditorInstance.setData(designHtml);
      }
    }
  });
</script>

<script>
    $(document).ready(function () {

        $('td[contenteditable="true"]').on('input', function () {
            var cell = $(this);
            var dataId = $('#campid').data('id');
            var campID = $('#campid').val();
            var newValue = cell.text().trim();


            $.ajax({
                url: '/update-campaign-title',
                method: 'POST',
                data: {
                    id: dataId,
                    value: newValue,
                    campID:campID,
                },
                success: function (response) {
                    console.log(response);
                },
                error: function (error) {
                    console.error(error);
                }
            });
        });
    });
</script>
@endsection
