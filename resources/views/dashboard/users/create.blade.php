@extends('layouts.dashboard.app')


@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1> @lang('site.add_user') </h1>


            <ol class="breadcrumb">
                <li ><a href="{{asset(route('dashboard.welcome'))}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a> </li>
                <li ><a href="{{asset(route('dashboard.users.index'))}}"><i class="fa fa-dashboard"></i> @lang('site.users')</a> </li>
                <li class="active">@lang('site.add') </li>

            </ol>
        </section>

        <section class="content">

           <div class="box box-primary">

               <div class="box-header">
                   <h3 class="box-title">@lang('site.add')</h3>
               </div>

               <div class="box-body">

                   @include('partials._errors')

                   <form action="{{asset(route('dashboard.users.store'))}}" method="post" enctype="multipart/form-data">
                       @csrf

                       <div class="form-group">
                           <label>
                               @lang('site.first_name')
                               <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}">
                           </label>
                       </div>

                       <div class="form-group">
                           <label>
                               @lang('site.last_name')
                               <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
                           </label>
                       </div>

                       <div class="form-group">
                           <label>
                               @lang('site.email')
                               <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                           </label>
                       </div>

                       <div class="form-group">
                           <label>
                               @lang('site.password')
                               <input type="password" name="password" class="form-control" value="{{ old('password') }}">
                           </label>
                       </div>

                       <div class="form-group">
                           <label>
                               @lang('site.password_confirmation')
                               <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
                           </label>
                       </div>

                       <div class="form-group">
                           <label>
                               @lang('site.image')
                               <input type="file" name="image" id="Image" class="form-control" value="{{ old('image') }}">
                           </label>
                       </div>

                       <div class="form-group">
                           <img src="{{ asset('uploads/user_images/default.png')}}" id="Image-preview" style="width:100px" class="img-thumbnail"/>
                       </div>



                       <div class="form-group">
                           <label>@lang('site.permissions')</label>
                           <div class="nav-tabs-custom">

                               @php
                                   $models = ['users', 'categories', 'products', 'clients', 'orders'];
                                   $maps = ['create', 'read', 'update', 'delete'];
                               @endphp

                               <ul class="nav nav-tabs">
                                   @foreach($models as $index =>$model)

                                      <li class="{{ $index==0 ? "active" : ""}}"><a href="#{{ $model }}" data-toggle="tab">@lang('site.'.$model)</a></li>
                                   @endforeach
                               </ul>

                               <div class="tab-content">

                                   @foreach( $models as $index =>$model)
                                       <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="{{ $model }}">

                                            @foreach( $maps as $key=>$map )
                                                 <label><input type="checkbox" name="permissions[]" value="{{ $model. "_" . $map }}"> @lang('site.'.$map )</label>
                                            @endforeach
                                       </div>
                                   @endforeach


                               </div><!-- end of tab content -->

                           </div><!-- end of nav tabs -->

                       </div>




                       <div class="form-group">
                          <button TYPE="submit" class="btn btn-primary"><i class="fa fa-plus"> @lang('site.add')</i></button>
                       </div>

                   </form>
               </div>

           </div>
        </section>
    </div>
    @endsection
