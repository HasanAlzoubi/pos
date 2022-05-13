@extends('layouts.dashboard.app')

@section('content')
 <div class="content-wrapper">
    <section class="content-header">
    <h1>@lang('site.dashboard')

    </h1>
        <ol class="breadcrumb">
{{--            <a href="{{asset(route('dashboard.welcome'))}}">--}}
            <li > <i class="fa fa-dashboard"></i> @lang('site.dashboard')</li>
{{--            <li class="active">  @lang('site.users')</li>--}}
        </ol>

    </section>

     <section class="content">
         <h1>This is dashboard</h1>
     </section>
 </div>
@endsection
