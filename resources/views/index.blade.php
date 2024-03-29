@extends('layouts.dashboard')

@section('content')
<!--Section: Minimal statistics cards-->
<section>
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                            <div class="align-self-center">
                                <i class="fa fa-file-lines text-info fa-3x"></i>
                            </div>

                            <div class="text-end">
                                <h3>{{ $activeQuizzes->count() }}</h3>
                                <p class="mb-0">{{ __('Quiz Actifs') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                            <div class="align-self-center">
                                <i class="fa fa-file-lines text-warning fa-3x"></i>
                            </div>

                            <div class="text-end">
                                <h3>{{ $upcomingQuizzes->count() }}</h3>
                                <p class="mb-0">{{ __('Quiz à venir') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                            <div class="align-self-center">
                                <i class="fas fa-chart-line text-success fa-3x"></i>
                            </div>

                            <div class="text-end">
                                <h3>64.89 %</h3>
                                <p class="mb-0">Bounce Rate</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                            <div class="align-self-center">
                                <i class="fas fa-map-marker-alt text-danger fa-3x"></i>
                            </div>

                            <div class="text-end">
                                <h3>423</h3>
                                <p class="mb-0">Total Visits</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Section: Minimal statistics cards-->

<!-- Section: Main chart -->
<section class="mb-4">
    <div class="container">
        <div class="card">
            <div class="card-header py-3">
                <h5 class="mb-0 text-center"><strong>{{ __('Quiz') }}</strong></h5>
            </div>

            <div class="card-body">
                <canvas class="my-4 w-100" id="myChart" height="380"></canvas>
            </div>
        </div>
    </div>
</section>
<!-- Section: Main chart -->

<!--Section: Sales Performance KPIs-->
<section class="mb-4">
    <div class="container">
        <div class="card">
            <div class="card-header text-center py-3">
                <h5 class="mb-0 text-center">
                <strong>Sales Performance KPIs</strong>
                </h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Product Detail Views</th>
                                <th scope="col">Unique Purchases</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Product Revenue</th>
                                <th scope="col">Avg. Price</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <th scope="row">Value</th>
                                <td>18,492</td>
                                <td>228</td>
                                <td>350</td>
                                <td>$4,787.64</td>
                                <td>$13.68</td>
                            </tr>

                            <tr>
                                <th scope="row">Percentage change</th>
                                <td>
                                    <span class="text-danger">
                                        <i class="fas fa-caret-down me-1"></i><span>-48.8%%</span>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-success">
                                        <i class="fas fa-caret-up me-1"></i><span>14.0%</span>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-success">
                                        <i class="fas fa-caret-up me-1"></i><span>46.4%</span>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-success">
                                        <i class="fas fa-caret-up me-1"></i><span>29.6%</span>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-danger">
                                        <i class="fas fa-caret-down me-1"></i><span>-11.5%</span>
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">Absolute change</th>
                                <td>
                                    <span class="text-danger">
                                        <i class="fas fa-caret-down me-1"></i><span>-17,654</span>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-success">
                                        <i class="fas fa-caret-up me-1"></i><span>28</span>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-success">
                                        <i class="fas fa-caret-up me-1"></i><span>111</span>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-success">
                                        <i class="fas fa-caret-up me-1"></i><span>$1,092.72</span>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-danger">
                                        <i class="fas fa-caret-down me-1"></i><span>$-1.78</span>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Section: Sales Performance KPIs-->
@endsection
