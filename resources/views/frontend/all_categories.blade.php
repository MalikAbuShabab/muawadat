@extends('layouts.store', [])

@section('css')
@php 
    $multiply =  session()->get('currencyMultiplier') ?? 1;
    $currencysymbol = session()->get('currencySymbol') ?? 'AED'; 
@endphp
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;
    }

    .page-heading {
        text-align: center;
        margin: 87px 3px 5px 9px;
        color: #010303;
        font-weight: bold;
        font-size: 24px;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            padding: 15px;
        }
        
        .product-card img {
            height: 150px;
        }
        
        .page-heading {
            font-size: 1.5rem;
            margin: 20px 0;
        }
    }

    @media (max-width: 480px) {
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 10px;
            padding: 10px;
        }
        
        .product-card img {
            height: 120px;
        }
    }

    .product-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .product-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .product-info .location i {
        margin-right: 5px;
        color: #80cbc4;
    }
    
    .position-relative {
        position: relative;
    }
    
    .category-name-overlay {
        position: inherit;
        top : 0px;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(1, 81, 88, 0.8);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-weight: bold;
        text-transform: capitalize;
        text-align: center;
    }
        #searchResults {
        margin-top: 20px;
    }
</style>
@php
    // $categories = App\Models\Category::with('translationLatest')->where('type_id', 13)->get();
    // $subcategories = App\Models\SubCategory::all();

@endphp
<link rel="stylesheet" type="text/css" href="{{asset('front-assets/css/price-range.css')}}">
<link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
 

@endsection
@section('content')
<section class="section-b-space ratio_asos">
   <div class="container">
    <div class="row"><h4 class="page-heading">All Categories</h2></div>
    <div id="searchResults1">
        @if(!$navCategories)
            <p style="text-align: center; color: red;">No category found.</p>
        @else
        <div class="collection-wrapper">
           
            <div class="product-grid px-0">
                 
                @foreach($navCategories as $key => $cate)
                    <a href="{{route('categoryDetail', $cate['slug'])}}">
                        <div class="product-card mt-4">
                            <div class="position-relative">
                                <img style="width: 270px;height: 270px" class="blur-up lazyload"
                         data-icon_two="{{!is_null($cate['icon_two']) ? $cate['icon_two']['image_fit'].'200/200'.$cate['icon_two']['image_path'] : $cate['icon']['image_fit'].'200/200'.$cate['icon']['image_path']}}"
                         data-icon="{{$cate['icon']['image_fit']}}200/200{{$cate['icon']['image_path']}}"
                         data-src="{{$cate['icon']['image_fit']}}150/150{{$cate['icon']['image_path']}}"
                         alt="" />
                                <div class="category-name-overlay">{{ $cate['slug'] }}</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        {{-- <div class="pagination-wrapper">
            {!! $product->appends(['sort' => request('sort')])->links() !!}
        </div> --}}
        @endif    
    </div>
    <input type="hidden" id="vendor_id" value="">

        <div class="no_search_product_found text-center">
                {{-- <h3 style="color:#b11414;" >Data not found !</h3> --}}
        </div>

    </div>

</section>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="{{asset('assets/js/chat/commonChat.js')}}"></script>
<script src="{{asset('front-assets/js/rangeSlider.min.js')}}"></script>
<script src="{{asset('front-assets/js/my-sliders.js')}}"></script>
<script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

</script>
@endsection
