@extends('student.layouts.student-master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<link rel="stylesheet" href="{{ asset('dashboard/css/style.css') }}" type="text/css" media="screen, print">     
    <!-- Main Contents -->
    <div class="main_content">
        <div class="container">

        <div class="items-center justify-between pb-5 sm:flex">
            <div class="flex-1">
                <h3 class="text-2xl font-semibold text-black"> {{ $title }}</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        {{-- <h5>Vehicle Number : {{ @$vehicle->vehicle->number ?? '--' }}</h5> --}}
                        <h5>Vehicle Number : TS28M9219</h5>

                    </div>
                    <div class="card-block">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d18110.142064543637!2d78.39139371211951!3d17.40274468541182!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcb96b085001d67%3A0x4f48deff88efc042!2sG.%20Narayanamma%20Institute%20of%20Technology%20and%20Science!5e0!3m2!1sen!2sin!4v1709887014983!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
<!--                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2822.7806761080233!2d-93.29138368446431!3d44.96844997909819!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x52b32b6ee2c87c91%3A0xc20dff2748d2bd92!2sWalker+Art+Center!5e0!3m2!1sen!2sus!4v1514524647889" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Vehicle Details') }}</h5>
                    </div>
                    <div class="card-block">
                        <div>
                            @php 
                               $fleet = App\Models\Fleets::where('vehicle_id',@$vehicle->transport_vehicle_id)->first();
                            @endphp
                            <p><mark class="text-primary">{{ __('Driver Name') }}:</mark> 
                                {{-- @if(isset($vehicle))
                                    {{ @$fleet->user ? @$fleet->user->first_name : 'Not Assigned'}} {{ @$fleet->user ? @$fleet->user->last_name : '' }}
                                @endif --}}
                           Rajesh </p><hr/>

                            <p><mark class="text-primary">{{ __('Vehicle Type') }}:</mark> 
                                Minivan</p><hr/>

                            <p><mark class="text-primary">{{ __('Status') }}:</mark> 
                                Active</p><hr/>

                            <p><mark class="text-primary">{{ __('Start Date') }}:</mark>
                                 2023-12-12</p><hr/>

                            <p><mark class="text-primary">{{ __('End Date') }}:</mark>
                                 {{ @$vehicle->end_date ?? '--' }}</p><hr/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection
@section('page_js')

@yield('sub-script')

@endsection