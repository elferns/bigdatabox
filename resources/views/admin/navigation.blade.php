@extends('admin.layouts.logged')

@section('title')
    Navigation
@endsection

@section('content')
    <div ng-controller="navigationCtrl">
        <div class="title page-header">
            <h2>Navigation</h2>
        </div>

        {!! Form::open(['url' => '/admin/navigation/store', 'autocomplete' => 'off',
                        'ng-submit' => 'submit(navigationForm.$valid)',
                        'name' => 'navigationForm', 'files' => true, 'novalidate']) !!}
        <div class="row">
            <div class="col-sm-5">

                @if(Session::has('success_navigation'))
                    <div class="alert alert-success" ng-hide="hideSuccessMsg">
                        <strong>{{ Session::get('success_navigation') }}</strong>
                    </div>
                @endif

                <div class="form-group{!! ($errors->has('name')) ? ' has-error' : '' !!}"
                     ng-class="{ 'has-error' : navigationForm.name.$invalid && !navigationForm.name.$pristine }">
                    {!! Form::label('name', 'Name', ['class' => 'form-label']) !!}
                    {!! Form::text('name', null, ['ng-model' => 'navigation.name', 'class' => 'form-control',
                                   'required', 'ng-model-options' => '{ updateOn: "blur" }']) !!}
                    @if ($errors->has('name'))
                        <div class="help-block">{!! $errors->first('name') !!}</div>
                    @endif
                    <p ng-show="navigationForm.name.$invalid && !navigationForm.name.$pristine" class="help-block">
                        The name field is required.</p>
                </div>

                <div class="form-group">
                    {!! Form::label('page', 'Page', ['class' => 'form-label']) !!}
                    {!! Form::selectOptions('page_id', $pages, 3, [
                                            'class' => 'form-control', 'ng-model' => 'navigation.page_id'],
                                            ['ng-selected' => '']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('order_no', 'Order', ['class' => 'form-label']) !!}
                    {!! Form::select('order_no', [1,2,3,4,5,6,7,8,9,10], null, ['placeholder' => 'Select order',
                                     'class' => 'form-control', 'ng-model' => 'navigation.order_no']) !!}
                </div>

                <div class="form-group">
                    {!! Form::checkbox('status', 1, ['class' => 'form-control', 'ng-model' => 'navigation.status']) !!}
                    <b>Status</b>
                </div>

                <div class="form-group">
                    {!! Form::hidden('ref', '', ['ng-value' => 'navigation.ref']) !!}
                </div>

                <div class="form-group center-block">
                    {!! Form::button('Save', ['type' => 'submit', 'class' => 'btn btn-lg btn-primary
                                      center-block save-btn', 'ng-disabled' => 'navigationForm.$invalid']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}

        <!--Navigation Listing---->
        @include('admin.layouts.list')
        <!--Navigation Listing---->
    </div>
@endsection