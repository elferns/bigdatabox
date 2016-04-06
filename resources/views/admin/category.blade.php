@extends('admin.layouts.logged')

@section('title')
    Categories
@endsection

@section('content')
    <div ng-controller="categoryCtrl">
        <div class="title page-header">
            <h2>Categories</h2>
        </div>

        {!! Form::open(['url' => '/admin/categories/store', 'autocomplete' => 'off',
                        'ng-submit' => 'submit(categoryForm.$valid)',
                        'name' => 'categoryForm', 'files' => true, 'novalidate']) !!}
        <div class="row">
            <div class="col-sm-5">

                @if(Session::has('success_categories'))
                    <div class="alert alert-success" ng-hide="hideDeleteMsg">
                        <strong>{{ Session::get('success_categories') }}</strong>
                    </div>
                @endif

                <div class="form-group{!! ($errors->has('name')) ? ' has-error' : '' !!}"
                     ng-class="{ 'has-error' : categoryForm.name.$invalid && !categoryForm.name.$pristine }">
                    {!! Form::label('name', 'Name', ['class' => 'form-label']) !!}
                    {!! Form::text('name', null, ['ng-model' => 'category.name', 'class' => 'form-control', 'required',
                                   'ng-model-options' => '{ updateOn: "blur" }']) !!}
                    @if ($errors->has('name'))
                        <div class="help-block">{!! $errors->first('name') !!}</div>
                    @endif
                    <p ng-show="categoryForm.name.$invalid && !categoryForm.name.$pristine" class="help-block">
                        The name field is required.</p>
                </div>

                <div class="form-group">
                    {!! Form::checkbox('status', 1, ['class' => 'form-control', 'ng-model' => 'category.status']) !!}
                    <b>Status</b>
                </div>

                <div class="form-group">
                    {!! Form::hidden('ref', '', ['ng-value' => 'category.ref']) !!}
                </div>

                 <div class="form-group center-block">
                        {!! Form::button('Save', ['type' => 'submit', 'class' => 'btn btn-lg btn-primary
                                          center-block save-btn', 'ng-disabled' => 'categoryForm.$invalid']) !!}
                 </div>
            </div>
        </div>
        {!! Form::close() !!}

        <!--Category Listing---->
        @include('admin.layouts.list')
        <!--Category Listing---->
    </div>
@endsection