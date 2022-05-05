@push('js')
    <script src="{{ asset('components/ckeditor4/ckeditor.js') }}"></script>
    <script src="{{ asset('components/ckeditor4/config-full.js') }}"></script>
@endpush

@component('core::admin._buttons-form', ['model' => $model])
@endcomponent


{!! BootForm::hidden('id') !!}
<file-manager related-table="{{ $model->getTable() }}" :related-id="{{ $model->id ?? 0 }}"></file-manager>

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
        <file-field type="image" field="image_id" :init-file="{{ $model->image ?? 'null' }}"></file-field>
        <files-field :init-files="{{ $model->files }}"></files-field>

        <div class="row gx-3">
            <div class="col-md-6">
                {!! TranslatableBootForm::text(__('Title'), 'title') !!}
            </div>
            <div class="col-md-6">
                @include('core::form._slug')
            </div>
            <div class="col-md-6">
                {!! TranslatableBootForm::text(__('Sub Title'), 'sub_title') !!}
            </div>
        </div>

        <div class="form-group">
            {!! TranslatableBootForm::hidden('status')->value(0) !!}
            {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
        </div>
        {!! BootForm::select(__('Area'), 'area', Casecategories::area())->addClass('custom-select')->required() !!}
        {!! BootForm::select(__('Category'), 'category_id', Casecategories::allForSelect())->addClass('custom-select')->required() !!}
        {!! TranslatableBootForm::textarea(__('Summary'), 'summary')->addClass('ckeditor-full') !!}
        {!! BootForm::textarea(__('Template'), 'template')->addClass('ckeditor-full')->disable()->value('<h2 class="casebox__title">天心太陽能光電場</h2>
        <div class="casebox__field">土地面積<span>23.6公頃</span></div>
        <div class="casebox__field">裝置容量<span>26MW</span></div>') !!}

        {!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor-full') !!}
        <div class="row gx-3">
            <div class="col-md-6">
                {!! TranslatableBootForm::text(__('Tag1'), 'tag1') !!}
            </div>
            <div class="col-md-6">
                {!! TranslatableBootForm::text(__('Tag2'), 'tag2') !!}
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="tab-meta">
        {!! TranslatableBootForm::text(__('Meta title'), 'meta_title') !!}
        {!! TranslatableBootForm::text(__('Meta keywords'), 'meta_keywords') !!}
        {!! TranslatableBootForm::text(__('Meta description'), 'meta_description') !!}
    </div>
</div>
