@extends('admin.layouts.logged')

@section('title')
    Portfolio
@endsection

@section('content')
    <div ng-controller="portfolioCtrl">
    <div class="title page-header">
        <h2>Portfolio</h2>
    </div>

    {!! Form::open(['url' => '/admin/portfolio/store', 'autocomplete' => 'off', 'ng-submit' => 'submit(portfolioForm.$valid)',
                    'id' => 'portfolioForm', 'name' => 'portfolioForm', 'novalidate']) !!}
    <div class="row">
        <div class="col-sm-5">

            <div class="form-group{!! ($errors->has('name')) ? ' has-error' : '' !!}"
                 ng-class="{ 'has-error' : portfolioForm.name.$invalid && !portfolioForm.name.$pristine }">
                {!! Form::label('name', 'Website name', ['class' => 'form-label']) !!}
                {!! Form::text('name', null, ['ng-model' => 'portfolio.name', 'class' => 'form-control', 'required',
                               'ng-model-options' => '{ updateOn: "blur" }']) !!}
                @if ($errors->has('name'))
                    <div class="help-block">{!! $errors->first('name') !!}</div>
                @endif
                <p ng-show="portfolioForm.name.$invalid && !portfolioForm.name.$pristine" class="help-block">
                    The name field is required.</p>
            </div>

            <div class="form-group{!! ($errors->has('url')) ? ' has-error' : '' !!}"
                 ng-class="{ 'has-error' : portfolioForm.url.$invalid && !portfolioForm.url.$pristine }">
                {!! Form::label('url', 'Website URL', ['class' => 'form-label']) !!}
                {!! Form::text('url', null, ['ng-model' => 'portfolio.url', 'class' => 'form-control', 'required',
                               'ng-model-options' => '{ updateOn: "blur" }']) !!}
                @if ($errors->has('url'))
                    <div class="help-block">{!! $errors->first('url') !!}</div>
                @endif
                <p ng-show="portfolioForm.url.$invalid && !portfolioForm.url.$pristine" class="help-block">
                    The url field is required.</p>
            </div>

            <div class="form-group{!! ($errors->has('image_name')) ? ' has-error' : '' !!}"
                     ng-class="{ 'has-error' : portfolio.image_name.$invalid && !portfolio.image_name.$pristine }">
                    {!! Form::label('image_name', 'Image', ['class' => 'form-label']) !!}
                    {!! Form::file('image_name', ['class' => 'form-control', 'valid-file',
                                   'extension' => 'jpg,jpeg,png', 'maxsize' => '1000000',
                                   'ng-model' => 'image_name', 'required']) !!}
                    <div class="spacer img-cover" ng-if="imageDisplay">
                        <img ng-src="<% imageDisplay %>" width="200" class="img-thumbnail"/>
                    </div>
                    @if ($errors->has('image_name'))
                        <div class="help-block">{!! $errors->first('image_name') !!}</div>
                    @endif
                    <p ng-show="portfolio.image_name.$error.extension" class="help-block">The image must be
                        a file of type: jpg,jpeg,png</p>
                    <p ng-show="portfolio.image_name.$error.maxsize" class="help-block">The image may not be
                        greater than 1000 kilobytes</p>
            </div>

            <div class="form-group">
                {!! Form::label('launch_date', 'Launch date', ['class' => 'form-label']) !!}
                {!! Form::text('launch_date', null, ['ng-model' => 'portfolio.launch_date', 'class' => 'form-control datepicker']) !!}
            </div>

            <div class="form-group">
                {!! Form::checkbox('status', 1, ['ng-model' => 'portfolio.status', 'class' => 'form-control']) !!}
                <b>Status</b>
            </div>

        </div>

        <div class="col-sm-6 col-sm-offset-1">

            <div class="form-group{!! ($errors->has('description')) ? ' has-error' : '' !!}">
                {!! Form::label('description', 'Description', ['class' => 'form-label']) !!}
                {!! Form::textarea('description', $launchDate, ['ng-model' => 'portfolio.description', 
                                   'class' => 'form-control']) !!}
                @if ($errors->has('description'))
                    <div class="help-block">{!! $errors->first('description') !!}</div>
                @endif
            </div>

        </div>

        <div class="form-group">
            {!! Form::hidden('ref', '', ['ng-value' => 'portfolio.ref']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-11">
            <div class="form-group center-block">
                {!! Form::button('Save', ['type' => 'submit', 'class' => 'btn btn-lg btn-primary
                                  center-block save-btn', 'ng-disabled' => 'portfolioForm.$invalid']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <!--Portfolio Listing---->
    
    <!--Portfolio Listing---->
    </div>
@endsection
