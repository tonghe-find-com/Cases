@extends('core::admin.master')

@section('title', __('New case'))

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'cases'])
        <h1 class="header-title">@lang('New case')</h1>
    </div>

    {!! BootForm::open()->action(route('admin::index-cases'))->multipart()->role('form') !!}
        @include('cases::admin.item._form')
    {!! BootForm::close() !!}

@endsection
