@extends('admin.layouts.logged')

@section('title')
  Banners
@endsection

@section('content')
    <div ng-controller="bannerCtrl">
        <div class="title page-header">
            <h2>Banners</h2>
        </div>

        {!! Form::open(['url' => '/admin/banners/store', 'autocomplete' => 'off',
                        'ng-submit' => 'submit(bannerForm.$valid)',
                        'name' => 'bannerForm', 'files' => true, 'novalidate']) !!}
        <div class="row">
            <div class="col-sm-5">

                @if(Session::has('success_banners'))
                    <div class="alert alert-success" ng-hide="hideDeleteMsg">
                        <strong>{{ Session::get('success_banners') }}</strong>
                    </div>
                @endif

                <div class="form-group{!! ($errors->has('name')) ? ' has-error' : '' !!}"
                     ng-class="{ 'has-error' : bannerForm.name.$invalid && !bannerForm.name.$pristine }">
                    {!! Form::label('name', 'Name', ['class' => 'form-label']) !!}
                    {!! Form::text('name', null, ['ng-model' => 'banner.name', 'class' => 'form-control', 'required',
                                   'ng-model-options' => '{ updateOn: "blur" }']) !!}
                    @if ($errors->has('name'))
                        <div class="help-block">{!! $errors->first('name') !!}</div>
                    @endif
                    <p ng-show="bannerForm.name.$invalid && !bannerForm.name.$pristine" class="help-block">
                        The name field is required.</p>
                </div>

                <div class="form-group{!! ($errors->has('image_name')) ? ' has-error' : '' !!}"
                     ng-class="{ 'has-error' : bannerForm.image_name.$invalid && !bannerForm.image_name.$pristine }">
                    {!! Form::label('image_name', 'Image', ['class' => 'form-label']) !!}
                    {!! Form::file('image_name', ['class' => 'form-control', 'valid-file',
                                   'extension' => 'jpg,jpeg,png', 'maxsize' => '1000000', 'ng-model' => 'image_name',
                                   'required']) !!}
                    @if ($errors->has('image_name'))
                        <div class="help-block">{!! $errors->first('image_name') !!}</div>
                    @endif
                    <p ng-show="bannerForm.image_name.$error.extension" class="help-block">The image must be
                        a file of type: jpg,jpeg,png</p>
                    <p ng-show="bannerForm.image_name.$error.maxsize" class="help-block">The image may not be
                        greater than 1000 kilobytes</p>
                </div>

                <div class="form-group">
                    {!! Form::hidden('ref', '', ['ng-value' => 'banner.ref']) !!}
                </div>

            </div>
            <div class="col-sm-6 col-sm-offset-1">
                <div class="form-group{!! ($errors->has('caption')) ? ' has-error' : '' !!}">
                    {!! Form::label('caption', 'Caption', ['class' => 'form-label']) !!}
                    {!! Form::textarea('caption', null, ['ng-model' => 'banner.caption', 'class' => 'form-control']) !!}
                    @if ($errors->has('caption'))
                        <div class="help-block">{!! $errors->first('caption') !!}</div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-sm-11">
                    <div class="form-group center-block">
                        {!! Form::button('Save', ['type' => 'submit', 'class' => 'btn btn-lg btn-primary
                                          center-block save-btn', 'ng-disabled' => 'bannerForm.$invalid']) !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

        <!--Banners Listing---->
        @include('admin.layouts.list')
        <!--Banners Listing---->
    </div>
@endsection