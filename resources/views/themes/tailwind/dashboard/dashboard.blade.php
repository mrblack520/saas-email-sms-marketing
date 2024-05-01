@extends('theme::layouts.dashboard')

@section("content")
<div class="modal fade" id="addOrderModalside">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Create Project</h5>
            <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <input type="hidden" name="_token" value="ot84xF0z4VuQ2UsjbPLrEKmIMnxgJOCHlQFGpksy">						<div class="form-group">
                    <label class="text-black font-w500">Project Name</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label class="text-black font-w500">Deadline</label>
                    <input type="date" class="form-control">
                </div>
                <div class="form-group">
                    <label class="text-black font-w500">Client Name</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary">CREATE</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<div class="row">
<div class="col-xl-11">
    <div class="row">
        <div class="col-sm-6">
            <div class="card fun">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="media-body me-3">
                            <h2 class="num-text text-black font-w600">{{ $totalEmailSent }}</h2>
                            <span class="fs-14">Total Email Sent</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card fun">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="media-body me-3">
                            <h2 class="num-text text-black font-w600">{{ $totalSmsSent }}</h2>
                            <span class="fs-14">Total SMS Sent</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card fun">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="media-body me-3">
                            <h2 class="num-text text-black font-w600">{{ $totalCampaigns }}</h2>
                            <span class="fs-14">Total Number of Campaigns</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card fun">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="media-body me-3">
                            <h2 class="num-text text-black font-w600">{{ $totalConnectedWebsites }}</h2>
                            <span class="fs-14">Total Number of Connected Websites</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header mb-0 d-sm-flex flex-wrap d-block shadow-sm border-0 align-items-center">
                    <div class="me-auto pe-3 mb-3">
                        <h4 class="text-black fs-20 mb-sm-0 mb-2">Project Created</h4>
                    </div>
                    <div class="card-action card-tabs mb-3">
                        <ul class="nav nav-tabs" id="project" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab"  href="#Daily" role="tab" aria-selected="false">
                                    Daily
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#Weekly" role="tab" aria-selected="false">
                                    Weekly
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#Monthly" role="tab" aria-selected="true">
                                    Monthly
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="Daily" role="tabpanel">
                            <div class="d-flex align-items-center">
                                <span class="fs-36 text-black font-w600 me-4">0,45%</span>
                                <div>
                                    <svg class="me-2" width="27" height="14" viewBox="0 0 27 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 13.435L13.435 0L26.8701 13.435H0Z" fill="#2FCA51"/>
                                    </svg>
                                    <span>last month $563,443</span>
                                </div>
                            </div>
                            <div id="chartTimeline"></div>
                        </div>
                        <div class="tab-pane" id="Weekly" role="tabpanel">
                            <div class="d-flex align-items-center">
                                <span class="fs-36 text-black font-w600 me-4">5,75%</span>
                                <div>
                                    <svg class="me-2" width="27" height="14" viewBox="0 0 27 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 13.435L13.435 0L26.8701 13.435H0Z" fill="#2FCA51"/>
                                    </svg>
                                    <span>last month $563,443</span>
                                </div>
                            </div>
                            <div id="chartTimeline2"></div>
                        </div>
                        <div class="tab-pane" id="Monthly" role="tabpanel">
                            <div class="d-flex align-items-center">
                                <span class="fs-36 text-black font-w600 me-4">1,20%</span>
                                <div>
                                    <svg class="me-2" width="27" height="14" viewBox="0 0 27 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 13.435L13.435 0L26.8701 13.435H0Z" fill="#2FCA51"/>
                                    </svg>
                                    <span>last month $563,443</span>
                                </div>
                            </div>
                            <div id="chartTimeline3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-xxl-12 col-md-12">
            <div class="card">
                <div class="card-header border-0 shadow-sm">
                    <h4 class="fs-20 text-black font-w600">New Clients</h4>
                    <div class="dropdown">
                        <a href="javascript:void(0)" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="javascript:void(0);">Edit</a>
                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                        </div>
                    </div>
                </div>
                <div class="card-body text-center">
                    <canvas id="widgetChart1" class="max-h80"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
</div>



@endsection


