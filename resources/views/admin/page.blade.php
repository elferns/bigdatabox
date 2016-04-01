@extends('admin.layouts.logged')

@section('title')
    Pages
@endsection

@section('content')
    <div ng-controller="pageCtrl">
    <div class="title page-header">
        <h2>Pages</h2>
    </div>

    {!! Form::open(['url' => '/admin/pages/store', 'autocomplete' => 'off', 'ng-submit' => 'submit()', 'id' => 'pageForm']) !!}
    <div class="row" id="pageData">
        <div class="col-sm-5">
            <div class="form-group{!! ($errors->has('name')) ? ' has-error' : '' !!}">
                {!! Form::label('name', 'Name', ['class' => 'form-label']) !!}
                {!! Form::text('name', null, ['ng-model' => 'page.name', 'class' => 'form-control']) !!}
                @if ($errors->has('name'))
                    <div class="help-block">{!! $errors->first('name') !!}</div>
                @endif
            </div>
            <div class="form-group{!! ($errors->has('title')) ? ' has-error' : '' !!}">
                {!! Form::label('title', 'Title', ['class' => 'form-label']) !!}
                {!! Form::text('title', null, ['ng-model' => 'page.title', 'class' => 'form-control']) !!}
                @if ($errors->has('title'))
                    <div class="help-block">{!! $errors->first('title') !!}</div>
                @endif
            </div>
            <div class="form-group">
                {!! Form::label('seo_keywords', 'SEO keywords', ['class' => 'form-label']) !!}
                {!! Form::text('seo_keywords', null, ['ng-model' => 'page.seo_keywords', 'class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('seo_description', 'SEO description', ['class' => 'form-label']) !!}
                {!! Form::textarea('seo_description', null, ['ng-model' => 'page.seo_description', 'class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::checkbox('status', 1, ['ng-model' => 'page.status', 'class' => 'form-control']) !!} <b>Status</b>
            </div>
        </div>

        <div class="col-sm-6 col-sm-offset-1">
            <div class="form-group{!! ($errors->has('content')) ? ' has-error' : '' !!}">
                {!! Form::label('content', 'Content', ['class' => 'form-label']) !!}
                {!! Form::textarea('content', null, ['ng-model' => 'page.content', 'class' => 'form-control', 'id' => 'page_content']) !!}
                @if ($errors->has('content'))
                    <div class="help-block">{!! $errors->first('content') !!}</div>
                @endif
            </div>
        </div>

        <div class="form-group">
            {!! Form::hidden('ref', '', ['ng-value' => 'page.ref']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-11">
            <div class="form-group center-block">
                {!! Form::button('Save', ['type' => 'submit', 'class' => 'btn btn-lg btn-primary center-block save-btn']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <!--Pages Listing---->
    <div class="container-fluid" ng-controller="modelCtrl">
        @if(Session::has('successMessage'))
            <div class="alert alert-success" ng-hide="hideDeleteMsg">
                <strong>{{ Session::get('successMessage') }}</strong>
            </div>
        @endif
        @if ( is_array($pages) )
        <table class="table table-bordered table-striped list-dtable">
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Title</td>
                    <td>Slug</td>
                    <td>Status</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                <tr>
                    <td>{!! $page->name !!}</td>
                    <td>{!! $page->title !!}</td>
                    <td>{!! $page->slug !!}</td>
                    <td>{!! $page->status !!}</td>
                    <td>
                        <div class="list-dcenter">
                            <i class="fa fa-trash" ng-click="showDeleteConfirm($event, 'page', {!! $page->id !!})"></i>
                            <i class="fa fa-pencil" ng-click="showEditPage({!! $page->id !!})"></i>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        <div>
            {!! $pages->links() !!}
        </div>
    </div>
     <!--Pages Listing---->
    </div>
@endsection
