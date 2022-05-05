@push('js')
    <script src="{{ asset('components/ckeditor4/ckeditor.js') }}"></script>
    <script src="{{ asset('components/ckeditor4/config-full.js') }}"></script>
@endpush

@component('core::admin._buttons-form', ['model' => $model])
@endcomponent

{!! BootForm::hidden('id') !!}
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" href="#tab-content"  data-bs-toggle="tab">{{ __('Content') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#tab-meta"  data-bs-toggle="tab">{{ __('Meta') }}</a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="tab-content">
        <file-manager related-table="{{ $model->getTable() }}" :related-id="{{ $model->id ?? 0 }}"></file-manager>
        @include('core::form._title-and-slug')
        <div class="form-group">
            {!! TranslatableBootForm::hidden('status')->value(0) !!}
            {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
        </div>
        {!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor-full') !!}
        {!! BootForm::textarea(__('Template'), 'template')->addClass('ckeditor-full')->disable()->value('') !!}
    </div>
    <div class="tab-pane fade" id="tab-meta">
        {!! TranslatableBootForm::text(__('Meta title'), 'meta_title') !!}
        {!! TranslatableBootForm::text(__('Meta keywords'), 'meta_keywords') !!}
        {!! TranslatableBootForm::text(__('Meta description'), 'meta_description') !!}
    </div>
</div>
