@extends('pages::public.master')

@isset($model)
    @section('title',$model->meta_title==""?$model->title:$model->meta_title)
    @section('keywords',$model->meta_keywords)
    @section('description',$model->meta_description)
@else
    @section('title',$page->meta_title==""?$page->title:$page->meta_title)
    @section('keywords',$page->meta_keywords)
    @section('description',$page->meta_description)
@endisset

@push('css')

@endpush


@push('js')

@endpush

@push('banner')
    @include('template.banner')
@endpush

@section('content')
<section>

    <div class="wrapper-B wrapper-case">

            <div class="flexCC">
                <h1 class="heading"><i class="fas fa-solar-panel"></i>{{$model->title ?? $page->title}}</h1>
            </div>
            {!! $model->body ?? $page->body !!}
            <div class="flexCC mt-md">
                <div class="itemcate-group">
                    <a href="{{ $model->url() }}" class="itemcate @if(!$area)itemcate--all @endif">全部</a>
                    @foreach ($area_list as $item)
                    <a href="{{ $model->url() }}?area={{ $item }}" class="itemcate @if($area && $area == $item) itemcate--now @endif">{{ Casecategories::getAreaName($item)}}</a>
                    @endforeach
                </div>
            </div>
            <div class="casebox-group">
                @foreach ($list as $item)
                <div class="casebox">
                    <div class="casebox__pic" style="background-image: url('/project/images/jumbotron2.jpeg');"></div>
                    <div class="casebox__label">
                        {{$item->sub_title}}
                    </div>
                    <div class="casebox__textbox">
                        <h2 class="casebox__title">{{$item->title}}</h2>
                        {!! $item->summary !!}
                    </div>
                    <div class="casebox__context">
                        <div>
                            <!-- 置入編輯器 -->
                            <div class="casebox__content">
                                {!! $item->body !!}
                            </div>
                        </div>
                        <a href="#!" class="casebox__btn">
                            看詳細 <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                    <div class="casebox__tag-group">
                        @if($item->tag1)
                        <div class="casebox__tag">{{$item->tag1}}</div>
                        @endif
                        @if($item->tag2)
                        <div class="casebox__tag">{{$item->tag2}}</div>
                        @endif
                    </div>
                    <div class="casebox__gallery">
                        @foreach ($item->images as $image)
                        <span data-img="{{ $item->present()->image() }}"></span>
                        @endforeach

                    </div>
                </div>
                @endforeach
            </div>
           
        </div>

    </div>

</section>
@endsection
