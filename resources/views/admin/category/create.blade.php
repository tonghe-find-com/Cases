@extends('core::admin.master')

@section('title', __('New casecategory'))

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'casecategories'])
        <h1 class="header-title">@lang('New casecategory')</h1>
    </div>

    {!! BootForm::open()->action(route('admin::index-casecategories'))->multipart()->role('form') !!}
        @include('cases::admin.category._form')
    {!! BootForm::close() !!}

@endsection
