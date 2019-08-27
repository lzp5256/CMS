@extends('Admin.Layout.layout')

@section('content')

@endsection
<div class="content-wrapper">
    <div class="container-fluid">

        <div class="row mt-4">
            <div class="col-12 col-lg-6 col-xl-3">
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <div class="media-body">
                                <p class="mb-0">Total Orders</p>
                                <h5 class="mb-0">452 <small class="extra-small-font py-1 px-2 rounded mb-0">-1.2%</small></h5>
                            </div>
                            <div class="w-icon">
                                <i class="zmdi zmdi-shopping-cart text-danger"></i>
                            </div>
                        </div>
                    </div>
                    <canvas id="dash1-chart-1" height="45"></canvas>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3">
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <div class="media-body">
                                <p class="mb-0">Total Revenue</p>
                                <h5 class="mb-0">$656 <small class="extra-small-font py-1 px-2 rounded mb-0">+2.3%</small></h5>
                            </div>
                            <div class="w-icon">
                                <i class="zmdi zmdi-balance-wallet text-success"></i>
                            </div>
                        </div>

                    </div>
                    <canvas id="dash1-chart-2" height="45"></canvas>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3">
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <div class="media-body">
                                <p class="mb-0">Support Requests</p>
                                <h5 class="mb-0">854 <small class="extra-small-font py-1 px-2 rounded">+1.5%</small></h5>
                            </div>
                            <div class="w-icon">
                                <i class="zmdi zmdi-pin-help text-warning"></i>
                            </div>
                        </div>

                    </div>
                    <canvas id="dash1-chart-3" height="45"></canvas>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3">
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <div class="media-body">
                                <p class="mb-0">Messages</p>
                                <h5 class="mb-0">230 <small class="extra-small-font py-1 px-2 rounded">-1.2%</small></h5>
                            </div>
                            <div class="w-icon">
                                <i class="zmdi zmdi-email-open text-primary"></i>
                            </div>
                        </div>

                    </div>
                    <canvas id="dash1-chart-4" height="45"></canvas>
                </div>
            </div>
        </div><!--end row-->

        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12">
                <div class="card rounded-0">
                    <div class="card-header">Views & Sales
                        <div class="btn-group btn-group-sm float-right">
                            <button type="button" class="btn btn-primary waves-effect waves-light">Monthly</button>
                            <button type="button" class="btn btn-outline-primary waves-effect waves-light">Weekly</button>
                            <button type="button" class="btn btn-outline-primary waves-effect waves-light">Daily</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-group align-items-center">
                            <div class="col-12 col-lg-12 col-xl-3 text-center">
                                <div class="icon-box gradient-branding">
                                    <i class="zmdi zmdi-eye text-white"></i>
                                </div>
                                <p class="mb-0 mt-2">Views</p>
                                <h4 class="mb-0">4350</h4>
                                <hr>
                                <div class="icon-box gradient-ibiza">
                                    <i class="zmdi zmdi-money text-white"></i>
                                </div>
                                <p class="mb-0 mt-2">Sales</p>
                                <h4 class="mb-0">720</h4>
                            </div>
                            <div class="col-12 col-lg-12 col-xl-9">
                                <canvas id="dash1-chart5" height="100"></canvas>
                            </div>
                        </div><!--End Row-->
                    </div>
                </div><!--End Card-->
            </div>
        </div><!--End Row-->


        <div class="row">
            <div class="col-12 col-lg-12 col-xl-5">
                <div class="card rounded-0">
                    <div class="card-header">Task To Complete
                        <div class="card-action">
                            <div class="dropdown">
                                <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                                    <i class="icon-options"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="javascript:void();">Action</a>
                                    <a class="dropdown-item" href="javascript:void();">Another action</a>
                                    <a class="dropdown-item" href="javascript:void();">Something else here</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="javascript:void();">Separated link</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush shadow-none">
                        <li class="list-group-item bg-transparent">
                            <div class="media align-items-center">
                                <div class="icheck-material-primary">
                                    <input type="checkbox" id="check1" checked="" />
                                    <label for="check1"></label>
                                </div>
                                <div class="media-body ml-2">
                                    <h6 class="mb-0">Bulona</h6>
                                    <p class="mb-0 extra-small-font">Bootstrap Admin Dashboard Template</p>
                                </div>
                                <div class="date">
                                    <button class="btn btn-outline-primary btn-sm btn-round">20 JAug</button>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item bg-transparent">
                            <div class="media align-items-center">
                                <div class="icheck-material-primary">
                                    <input type="checkbox" id="check2" checked="" />
                                    <label for="check2"></label>
                                </div>
                                <div class="media-body ml-2">
                                    <h6 class="mb-0">Dashtreme</h6>
                                    <p class="mb-0 extra-small-font">Multipurpose Admin Template</p>
                                </div>
                                <div class="date">
                                    <button class="btn btn-outline-primary btn-sm btn-round">22 Sep</button>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item bg-transparent">
                            <div class="media align-items-center">
                                <div class="icheck-material-primary">
                                    <input type="checkbox" id="check3" checked="" />
                                    <label for="check3"></label>
                                </div>
                                <div class="media-body ml-2">
                                    <h6 class="mb-0">Rukada</h6>
                                    <p class="mb-0 extra-small-font">Responsive Admin Template</p>
                                </div>
                                <div class="date">
                                    <button class="btn btn-outline-primary btn-sm btn-round">30 Sep</button>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item bg-transparent">
                            <div class="media align-items-center">
                                <div class="icheck-material-primary">
                                    <input type="checkbox" id="check4"/>
                                    <label for="check4"></label>
                                </div>
                                <div class="media-body ml-2">
                                    <h6 class="mb-0">Rocker</h6>
                                    <p class="mb-0 extra-small-font">Bootstrap4 Admin Template</p>
                                </div>
                                <div class="date">
                                    <button class="btn btn-outline-primary btn-sm btn-round">10 Oct</button>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item bg-transparent">
                            <div class="media align-items-center">
                                <div class="icheck-material-primary">
                                    <input type="checkbox" id="check5" checked="" />
                                    <label for="check5"></label>
                                </div>
                                <div class="media-body ml-2">
                                    <h6 class="mb-0">Fobia</h6>
                                    <p class="mb-0 extra-small-font">Web Application UI+Kit</p>
                                </div>
                                <div class="date">
                                    <button class="btn btn-outline-primary btn-sm btn-round">25 Nov</button>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item bg-transparent">
                            <div class="media align-items-center">
                                <div class="icheck-material-primary">
                                    <input type="checkbox" id="check6"/>
                                    <label for="check6"></label>
                                </div>
                                <div class="media-body ml-2">
                                    <h6 class="mb-0">Bulona</h6>
                                    <p class="mb-0 extra-small-font">Bootstrap Admin Dashboard Template</p>
                                </div>
                                <div class="date">
                                    <button class="btn btn-outline-primary btn-sm btn-round">28 Nov</button>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item bg-transparent">
                            <div class="media align-items-center">
                                <div class="icheck-material-primary">
                                    <input type="checkbox" id="check7" checked="" />
                                    <label for="check7"></label>
                                </div>
                                <div class="media-body ml-2">
                                    <h6 class="mb-0">Dashtreme</h6>
                                    <p class="mb-0 extra-small-font">Multipurpose Admin Template</p>
                                </div>
                                <div class="date">
                                    <button class="btn btn-outline-primary btn-sm btn-round">20 Dec</button>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="card-footer text-center border-0">
                        <a href="javascript:void();">View all Task</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-12 col-xl-7">
                <div class="card-group">
                    <div class="card border-right border-light rounded-0">
                        <div class="card-header">Traffic Referrels
                            <div class="card-action">
                                <div class="dropdown">
                                    <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                                        <i class="icon-options"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void();">Action</a>
                                        <a class="dropdown-item" href="javascript:void();">Another action</a>
                                        <a class="dropdown-item" href="javascript:void();">Something else here</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="javascript:void();">Separated link</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="dash1-chart-8" height="160"></canvas>
                            <hr>
                            <p class="mb-0"><i class="zmdi zmdi-circle text-success mr-1"></i> Direct <span class="float-right">60%</span></p>
                            <hr>
                            <p class="mb-0"><i class="zmdi zmdi-circle text-warning mr-1"></i> Affiliate <span class="float-right">15%</span></p>
                            <hr>
                            <p class="mb-0"><i class="zmdi zmdi-circle text-secondary mr-1"></i> E-mail <span class="float-right">25%</span></p>
                        </div>
                    </div>
                    <div class="card rounded-0">
                        <div class="card-header">Sales Satus
                            <div class="card-action">
                                <div class="dropdown">
                                    <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                                        <i class="icon-options"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void();">Action</a>
                                        <a class="dropdown-item" href="javascript:void();">Another action</a>
                                        <a class="dropdown-item" href="javascript:void();">Something else here</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="javascript:void();">Separated link</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">Over All Earning</p>
                            <h4 class="mb-0">$851963</h4>
                            <hr/>
                            <ul class="list-inline">
                                <li class="list-inline-item"><i class="zmdi zmdi-circle mr-1" style="color: #b2e3f9;"></i> Orders</li>
                                <li class="list-inline-item"><i class="zmdi zmdi-circle mr-1" style="color: #14acef;"></i> Sales</li>
                            </ul>
                        </div>
                        <canvas id="dash1-chart-9" height="200"></canvas>
                    </div>
                </div>
                <div class="card-group">
                    <div class="card border-right border-light rounded-0">
                        <div class="card-body">
                            <div class="media align-items-center">
                                <div class="media-body">
                                    <h5 class="mb-0">9854 </h5>
                                    <p class="mb-0">Total Clicks</p>
                                </div>
                                <div>
                                    <span id="dash1-chart-10"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card rounded-0">
                        <div class="card-body">
                            <div class="media align-items-center">
                                <div class="media-body">
                                    <h5 class="mb-0">4526 </h5>
                                    <p class="mb-0">Total Views</p>
                                </div>
                                <div>
                                    <span id="dash1-chart-11"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--End Row-->


        <div class="row">
            <div class="col-12 col-lg-6 col-xl-4">
                <div class="card rounded-0">
                    <div class="card-body">
                        <p class="mb-0 extra-small-font">Top Selling Country</p>
                        <h4>$98,252</h4>
                    </div>
                    <canvas id="dash1-chart-6" height="220"></canvas>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table task-table align-items-center">
                                <tbody>
                                <tr>
                                    <td><i class="flag-icon flag-icon-us mr-1"></i> USA</td>
                                    <td>$456</td>
                                    <td>12.54%</td>
                                </tr>
                                <tr>
                                    <td><i class="flag-icon flag-icon-cu mr-1"></i> Canada</td>
                                    <td>$856</td>
                                    <td>34.14%</td>
                                </tr>
                                <tr>
                                    <td><i class="flag-icon flag-icon-au mr-1"></i> Australiya</td>
                                    <td>$786</td>
                                    <td>52.34%</td>
                                </tr>
                                <tr>
                                    <td><i class="flag-icon flag-icon-in mr-1"></i> India</td>
                                    <td>$966</td>
                                    <td>14.54%</td>
                                </tr>
                                <tr>
                                    <td><i class="flag-icon flag-icon-ch mr-1"></i> China</td>
                                    <td>$456</td>
                                    <td>34.34%</td>
                                </tr>
                                <tr>
                                    <td><i class="flag-icon flag-icon-br mr-1"></i> Brasil</td>
                                    <td>$852</td>
                                    <td>32.24%</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12 col-lg-6 col-xl-4">
                <div class="card rounded-0">
                    <div class="card-content">
                        <div class="row row-group m-0 border-light border-bottom">
                            <div class="col-12 col-lg-6 col-xl-6 text-center">
                                <div class="card-body">
                                    <div class="server-easy_chart server-easy1" data-percent="65">
                                        <span class="server-easy_percent"></span>
                                    </div>
                                    <p class="mb-0 mt-2">Server Load</p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-xl-6 text-center">
                                <div class="card-body">
                                    <div class="server-easy_chart server-easy2" data-percent="75">
                                        <span class="server-easy_percent"></span>
                                    </div>
                                    <p class="mb-0 mt-2">Band Width</p>
                                </div>
                            </div>
                        </div>
                        <div class="row row-group m-0">
                            <div class="col-12 col-lg-6 col-xl-6 text-center">
                                <div class="card-body">
                                    <div class="server-easy_chart server-easy3" data-percent="80">
                                        <span class="server-easy_percent"></span>
                                    </div>
                                    <p class="mb-0 mt-2">Used Ram</p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-xl-6 text-center">
                                <div class="card-body">
                                    <div class="server-easy_chart server-easy4" data-percent="55">
                                        <span class="server-easy_percent"></span>
                                    </div>
                                    <p class="mb-0 mt-2">Bounce Rate</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <i class="zmdi zmdi-facebook-box text-facebook fa-2x mr-2"></i>
                            <div class="media-body ml-2">
                                <h5 class="mb-0">8456</h5>
                                <p class="mb-0">Facebook Likes</p>
                            </div>
                            <span id="dash1-chart-12"></span>
                        </div>
                        <hr>
                        <div class="media align-items-center">
                            <i class="zmdi zmdi-twitter-box text-twitter fa-2x mr-2"></i>
                            <div class="media-body ml-2">
                                <h5 class="mb-0">7386</h5>
                                <p class="mb-0">Twitter Tweets</p>
                            </div>
                            <span id="dash1-chart-13"></span>
                        </div>
                        <hr>
                        <div class="media align-items-center">
                            <i class="zmdi zmdi-instagram text-instagram fa-2x mr-2"></i>
                            <div class="media-body ml-2">
                                <h5 class="mb-0">6587</h5>
                                <p class="mb-0">Instagram Likes</p>
                            </div>
                            <span id="dash1-chart-14"></span>
                        </div>
                        <hr>
                        <div class="media align-items-center">
                            <i class="zmdi zmdi-linkedin-box text-linkedin fa-2x mr-2"></i>
                            <div class="media-body ml-2">
                                <h5 class="mb-0">8589</h5>
                                <p class="mb-0">Linkedin Users</p>
                            </div>
                            <span id="dash1-chart-15"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-12 col-xl-4">
                <div class="card rounded-0">
                    <div class="card-body">
                        <p class="mb-0 extra-small-font">Top Selling Product</p>
                        <h4>589,462</h4>
                    </div>
                    <canvas id="dash1-chart-7" height="220"></canvas>
                    <div class="card-body">

                        <div class="progress-wrapper">
                            <p class="my-3">Mobiles <span class="float-right">90%</span></p>
                            <div class="progress" style="height: 2px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 90%"></div>
                            </div>
                        </div>

                        <div class="progress-wrapper">
                            <p class="my-3">Laptops <span class="float-right">60%</span></p>
                            <div class="progress" style="height: 2px;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 60%"></div>
                            </div>
                        </div>

                        <div class="progress-wrapper">
                            <p class="my-3">Headphones <span class="float-right">45%</span></p>
                            <div class="progress" style="height: 2px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 45%"></div>
                            </div>
                        </div>

                        <div class="progress-wrapper">
                            <p class="my-3">Shoes <span class="float-right">45%</span></p>
                            <div class="progress" style="height: 2px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 35%"></div>
                            </div>
                        </div>

                        <div class="progress-wrapper">
                            <p class="my-3">T-Shirts <span class="float-right">65%</span></p>
                            <div class="progress" style="height: 2px;">
                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 65%"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div><!--End Row-->


    </div>
    <!-- End container-fluid-->

</div><!--End content-wrapper-->
<!--Start Back To Top Button-->
<a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
<!--End Back To Top Button-->
<script src="{{URL::asset('js/index.js')}}"></script>
