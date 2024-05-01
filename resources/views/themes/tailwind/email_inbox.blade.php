@extends('theme::layouts.dashboard')




@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Email</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Inbox</a></li>
    </ol>
</div>
<!-- row -->
<div class="row">
    <div class="col-lg-11">
        <div class="card">
            <div class="card-body">
                <div class="email-left-box px-0 mb-3">
                    <div class="p-0">
                        <a href="{{ Route('campaigns.index') }}" class="btn btn-primary d-block">Create New Campaign</a>
                    </div>
                    <div class="mail-list mt-4">
                        {{-- <a href="javascript:void(0);" class="list-group-item"><i
                            class="fa fa-star font-18 align-middle me-2"></i>Campaign <span
                            class="badge badge-danger text-white badge-sm float-end">47</span>
                    </a> --}}
                    <a href="{{ route('campaign.inbox') }}" class="list-group-item active"> <i class="fa fa-inbox font-18 align-middle me-2"></i> Campaign  </a>
                    <a href="{{ route('campaigns.sent') }}" class="list-group-item"><i class="fa fa-paper-plane font-18 align-middle me-2"></i>Sent</a>
                    <a href="{{ route('campaigns.draft') }}" class="list-group-item"><i class="fa fa-paper-plane font-18 align-middle me-2"></i>Draft</a>

                        {{-- <a href="javascript:void(0);" class="list-group-item"><i
                                class="mdi mdi-file-document-box font-18 align-middle me-2"></i>Draft</a><a href="javascript:void(0);" class="list-group-item"><i
                                class="fa fa-trash font-18 align-middle me-2"></i>Trash</a> --}}
                    </div>
                    <div class="intro-title d-flex justify-content-between">
                        <h5>Categories</h5>
                        <i class="icon-arrow-down" aria-hidden="true"></i>
                    </div>
                    <div class="mail-list mt-4">
                        <a href="{{ route('campaigns.SMS.inbox') }}" class="list-group-item"><span class="icon-warning"><i
                                    class="fa fa-circle" aria-hidden="true"></i></span>
                            SMS </a>
                        <a href="{{ route('campaigns.Email.inbox') }}" class="list-group-item"><span class="icon-primary"><i
                                    class="fa fa-circle" aria-hidden="true"></i></span>
                            Email </a>
                        <a href="https://vora.dexignlab.com/laravel/demo/email-inbox" class="list-group-item"><span class="icon-success"><i
                                    class="fa fa-circle" aria-hidden="true"></i></span>
                            Whatsapp </a>

                    </div>
                </div>
                <div class="email-right-box ms-0 ms-sm-4 ms-sm-0">
                    <div class="toolbar mb-4" role="toolbar">
                        <div class="btn-group mb-1 me-2">
                            <button type="button" class="btn btn-primary light px-3"><i class="fa fa-archive"></i></button>
                            <button type="button" class="btn btn-primary light px-3"><i class="fa fa-exclamation-circle"></i></button>
                            <button type="button" class="btn btn-primary light px-3"><i class="fa fa-trash"></i></button>
                        </div>


                    </div>
                    <div id="dynamic-content-container" class="email-list mt-3">
                        @foreach ($campaignEmails as $email)
                        <div class="message">
                            <div>
                                <div class="d-flex message-single">
                                    <div class="ps-1 align-self-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="form-check-input" id="checkbox21">
                                            <label class="custom-control-label" for="checkbox21"></label>
                                        </div>
                                    </div>
                                    <div class="ms-2">
                                        <button class="border-0 bg-transparent align-middle p-0"><i
                                                class="fa fa-star" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                                <a href="{{ Route("open.email", ['id' => $email->id]) }}" class="col-mail col-mail-2">
                                    <div class="subject">{{ $email->subject }}</div>
                                    <div class="date">{{ $email->created_at }}</div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- panel -->
                    <div class="row mt-4">
                        <div class="col-12 ps-3">
                            <nav>
                                <ul class="pagination pagination-gutter pagination-primary pagination-sm no-bg" id="pagination-links">
                                    {{ $campaignEmails->links() }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





@endsection


