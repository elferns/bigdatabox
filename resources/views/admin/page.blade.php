@extends('admin.layouts.logged')

@section('title')
    Pages
@endsection

@section('content')
    <div class="title page-header">
        <h2>Pages</h2>
    </div>

    {!! Form::open(['url' => '/admin/pages/store', 'autocomplete' => 'off']) !!}
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group{!! ($errors->has('name')) ? ' has-error' : '' !!}">
                {!! Form::label('name', 'Name', ['class' => 'form-label']) !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                @if ($errors->has('name'))
                    <div class="help-block">{!! $errors->first('name') !!}</div>
                @endif
            </div>
            <div class="form-group{!! ($errors->has('title')) ? ' has-error' : '' !!}">
                {!! Form::label('title', 'Title', ['class' => 'form-label']) !!}
                {!! Form::text('title', null, ['class' => 'form-control']) !!}
                @if ($errors->has('title'))
                    <div class="help-block">{!! $errors->first('title') !!}</div>
                @endif
            </div>
            <div class="form-group">
                {!! Form::label('seo_keywords', 'SEO keywords', ['class' => 'form-label']) !!}
                {!! Form::text('seo_keywords', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('seo_description', 'SEO description', ['class' => 'form-label']) !!}
                {!! Form::textarea('seo_description', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::checkbox('status', 1, ['class' => 'form-control']) !!} <b>Status</b>
            </div>
        </div>

        <div class="col-sm-6 col-sm-offset-1">
            <div class="form-group{!! ($errors->has('content')) ? ' has-error' : '' !!}">
                {!! Form::label('content', 'Content', ['class' => 'form-label']) !!}
                {!! Form::textarea('content', null, ['class' => 'form-control', 'id' => 'page_content']) !!}
                @if ($errors->has('content'))
                    <div class="help-block">{!! $errors->first('content') !!}</div>
                @endif
            </div>
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

    <div class="row">
        <div class="col-sm-11">
            @foreach ($pages as $page)
                {!! $page->name !!}
            @endforeach

            {!! $pages->links() !!}
        </div>
    </div>
@endsection
