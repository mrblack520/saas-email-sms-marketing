@extends('theme::layouts.dashboard')




@section('content')

<div class="container mt-4">
    <h2>Template </h2>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <a href="{{route('emailbulder', ['campaignid' => $templateid->id])}}">
                <div class="card-body" style="display: flex; justify-content: center; align-items: center;">
                    <i class="fa fa-plus" style="font-size: 54px;"></i>
                </div>
            </a>
            </div>
        </div>
        @foreach($templates as $template)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('template.editor', ['id' => $template->id, 'campaignid' => $templateid->id ]) }}"
                           class="edit-template-btn" data-template="{{ $template->html_content }}">
                            <img src="{{ asset('Buy_Later/email.png') }}"  class="card-img-top" alt="Image Description">
                            {{-- Add more properties as needed --}}
                        </a>
                    </div>
                </div>
                
            </div>
        @endforeach
    </div>

</div>
<script>
    // Store the selected template JSON in local storage when the button is clicked
    const editTemplateBtns = document.querySelectorAll('.edit-template-btn');
    editTemplateBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const templateJson = btn.dataset.template;
            console.log(templateJson);
            localStorage.setItem('selectedTemplate', templateJson);
        });
    });
</script>
@endsection