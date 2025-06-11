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

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        padding: 20px;
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

    .product-info {
        padding: 15px;
        background-color: #FDFDFD;
        color: #000;
    }

    .product-info h3 {
        margin: 0;
        font-size: 18px;
        color: #000;
    }

    .product-info .price {
        margin: 5px 0;
        font-size: 20px;
        font-weight: bold;
        color: #015158;
    }

    .product-info .location {
        display: flex;
        align-items: center;
        font-size: 14px;
        color: #777;
    }

    .product-info .location i {
        margin-right: 5px;
        color: #80cbc4;
    }
        #searchResults {
        margin-top: 20px;
    }
    #searchForm button {
    background: #015158;
    border: navajowhite;
    border-radius: 10px;
    padding: 10px 30px;
}
#searchForm select {
    color: #6c757d;
}
#searchForm .location {
    color: #6c757d;
    border-left: 1px solid #E4E7EC !important;
    padding-left: 20px;
}
#searchForm .category {
    color: #6c757d;
    border-left: 1px solid #E4E7EC !important;
    padding-left: 20px;
    margin-left: 20px;
}
#searchForm input, select {
    width: 18%;
}
.category_filter select {
    background: #F5FEFF;
    border: none;
    padding: 14px 10px;
    border-radius: 8px;
    margin-right: 10px;
}
.category_filter button {
    border: 1px solid #E4E7EC !important;
    background: transparent !important;
    padding: 10px !important;
    border-radius: 8px !important;
}
</style>
@php
    // $categories = App\Models\Category::with('translationLatest')->where('type_id', 13)->get();
    // $subcategories = App\Models\SubCategory::all();

@endphp
<link rel="stylesheet" type="text/css" href="{{asset('front-assets/css/price-range.css')}}">
<link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

@endsection
@section('content')
<section class="section-b-space ratio_asos">
   <div class="container">
    <div class="banner_category w-100 d-inline-block ">
        <form  id="searchForm">
            <span class="p-3 w-100 d-flex my-3" style="border: 1px solid #E4E7EC; border-radius: 16px;">
                <span class="w-100">
                    <input type="text" class="border-0" name="keyword" placeholder="What are you looking for?" required>
                    <select name="location" class="location border-0" style="background: transparent;">
                        <option value="" selected disabled >Locations</option>
                        @foreach($countries as $key => $val)
                            <option value="{{$val->nicename}}">{{ $val->nicename}}</option>
                        @endforeach
                    </select>
                    <select name="category" class="category border-0" style="background: transparent;">
                        <option value="" selected disabled >Select Category</option>
                        @foreach($categories as $cate)
                        <option value="{{$cate['id']}}">{{$cate['hierarchy']}}</option>
                    @endforeach
                    </select>
                </span>
                <button type="submit" class="text-white">Search</button>
              
            </span>
            <div class="category_filter">
                <select name="price_filter" id="price_filter">
                    <option value="" selected disabled>Select Price Range</option>
                    <option value="0-1000">{{$currencysymbol}} 0 - {{$currencysymbol}} 1000</option>
                    <option value="1000-5000">{{$currencysymbol}} 1000 - {{$currencysymbol}} 5000</option>
                    <option value="5000-10000">{{$currencysymbol}} 5000 - {{$currencysymbol}} 10000</option>
                    <option value="10000-50000">{{$currencysymbol}} 10000 - {{$currencysymbol}} 50000</option>
                    <option value="50000-100000">{{$currencysymbol}} 50000 - {{$currencysymbol}} 100000</option>
                    <option value="100000">Above {{$currencysymbol}} 100000</option>
                </select>
                <button type="button" id="clearFilters">Clear Filters</button>
        </div>
        </form>
        
          
    </div>

    <div class="d-flex justify-content-between">

        <div class="collection-wrapper">
            <h4 class="mt-3" id="dynamic_text">Trending</h4>
        </div>
        {{-- <select name="location" class="location px-2 rounded-lg">
            <option value="" selected disabled >Sort By</option>
            @foreach($countries as $key => $val)
                <option value="{{$val->nicename}}">{{ $val->nicename}}</option>
            @endforeach
        </select> --}}
        <select id="sortProducts" class="location px-1 rounded-lg" style="width: 175px;">
            {{-- <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Sort By</option> --}}
            <option value="" selected disabled>Sort By</option>
            <option value="price_low_high" {{ request('sort') == 'price_low_high' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_high_low" {{ request('sort') == 'price_high_low' ? 'selected' : '' }}>Price: High to Low</option>
        </select>
    </div>


    
    <div id="searchResults">
        @if($product->isEmpty())
            <p style="text-align: center; color: red;">No products found.</p>
        @else
        <div class="collection-wrapper">
            <div class="product-grid px-0">
                @foreach($product as $key => $val)
              
                        <a href="{{ url($val->vendor->slug . '/product-page/' . $val->url_slug) }}">
                            <div class="product-card">
                                <img class="blur blurload" data-src="{{ get_file_path($val->image_url,'FILL_URL','60','60') }}" src="{{ get_file_path($val->image_url,'FILL_URL','26','26') }}" alt="" title="">
                                    <div class="pref-timing"> </div>
                                <div class="product-info">
                                    <h3>{{$val->dataname}}</h3>
                                    <div class="price">{{$currencysymbol}}{{$val->variantSingle->price ?? '0'}}</div>
                                    <div class="location">
                                        <i class="fa fa-map-martranslationker"></i> {{ $val->address}}
                                    </div>
                                </div>
                            </div>
                        </a>
                @endforeach
            </div>
        </div>
        <div class="pagination-wrapper">
            {!! $product->appends(['sort' => request('sort')])->links() !!}
        </div>
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

$(document).ready(function () {
    $('#sortProducts').on('change', function () {
        let sortValue = $(this).val();
        var currencysymbol = {!! json_encode($currencysymbol) !!};
        let urlParams = new URLSearchParams(window.location.search);

        let searchData = {
            sort: sortValue,
            keyword: $('input[name="keyword"]').val(),
            location: $('select[name="location"]').val(),
            category: $('select[name="category"]').val(),
            price_filter: $('#price_filter').val(),
            page_type: 'search_main'
        };

       // Define specific parameters to check
        let checkParams = ['keyword', 'location', 'category', 'price_filter'];
        let isEmpty = checkParams.every(param => !searchData[param]);

        if (isEmpty) {
            searchData = {
                sort: sortValue, // Add sort value here too
                keyword: urlParams.get('keyword') || '',
                lat: urlParams.get('lat') || '',
                long: urlParams.get('long') || '',
                address: urlParams.get('address') || '',
                min_price: urlParams.get('min_price') || '',
                max_price: urlParams.get('max_price') || '',
                page_type: 'search_home'
            };
        }
         
        $.ajax({
            url: "{{ route('filter.search') }}",
            method: "GET",
            data: searchData,
            success: function(response) {
                let output = `<div class="collection-wrapper">
                    <div class="product-grid px-0">`;
                        
                if (response.products && response.products.length > 0) {
                    
                    response.products.forEach(val => {
                        // Check if required properties exist before accessing them
                        
                            console.log(val.vendor);
                            console.log(val.translation);
                            console.log(val.translation.length);
                            console.log(val.address);
                            console.log(val.variants);
                            console.log(val.variants.length);
                        if (val.vendor && val.translation && val.translation.length > 0 && val.variants && val.variants.length > 0) {
                            let productUrl = `/${val.vendor.slug}/product-page/${val.url_slug}`;
                            console.log(productUrl);
                            console.log(val.image_url);
                            output += `
                                <a href="${productUrl}">
                                    <div class="product-card">
                                        <img class="blur blurload no-blur" 
                                             src="${val.image_url}" 
                                             alt="${val.translation[0].title}" 
                                             title="${val.translation[0].title}">
                                        <div class="pref-timing"></div>
                                        <div class="product-info">
                                            <h3>${val.translation[0].title}</h3>
                                            <div class="price">${currencysymbol} ${val.variants[0].price}</div>
                                            <div class="location">
                                                <i class="fa fa-map-marker"></i> ${val.address || 'Location not available'}
                                            </div>
                                        </div>
                                    </div>
                                </a>`;
                        }
                    });
                } else {
                    output = `<p style="text-align: center; color: red;">No products found.</p>`;
                }
                output += `</div></div>`;
                console.log('response');
                console.log(output);
                $('#searchResults').html(output);
                
                // Only update pagination if it exists in the response
                if (response.pagination) {
                    $('.pagination-wrapper').html(response.pagination);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                $('#searchResults').html('<p style="text-align: center; color: red;">Error loading products. Please try again.</p>');
            }
        });
    });
});

// ... existing code ...


    $(document).ready(function() {
    $('#searchForm').on('submit', function(event) {
        event.preventDefault();
        var currencysymbol = {!! json_encode($currencysymbol) !!};
        let locationValue = $("select[name='location']").val();
        $.ajax({
            url: "{{ route('filter.search') }}",
            method: "GET",
            data: $(this).serialize(),
            success: function(response) {
                let output = `<div class="collection-wrapper">
                    <div class="product-grid px-0">`;
                console.log(response);
                if (locationValue != null) {
                    $("#dynamic_text").text('Company in '+ locationValue);
                }else{
                    $("#dynamic_text").text('Trending');
                } 
                if (response.products.length > 0) {
                    response.products.forEach(val => {
                        let productUrl = `/${val.vendor.slug}/product-page/${val.url_slug}`;
                        let productImage = `{{ get_file_path('', 'FILL_URL', '60', '60') }}`.replace('', val.image_url);
                        let smallImage = `{{ get_file_path('', 'FILL_URL', '26', '26') }}`.replace('', val.image_url);
                          
                        output += `
                                <a href="${productUrl}">
                                    <div class="product-card">
                                        <img class="blur1 blurload" data-src="${val.image_url}" src="${val.image_url}" alt="" title="">
                                        <div class="pref-timing"></div>
                                        <div class="product-info">
                                            <h3>${val.translation[0].title}</h3>
                                            <div class="price">${currencysymbol} ${val.variants[0].price}</div>
                                            <div class="location">
                                                <i class="fa fa-map-marker"></i> ${val.address}
                                            </div>
                                        </div>
                                    </div>
                                </a>`;
                    });
                } else {
                    output = `<p style="text-align: center;color: red;">No products found.</p>`;
                }
                output += `</div></div>`;
                $('#searchResults').html(output);
                $('.pagination-wrapper').html(response.pagination);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", error);
            }
        });
    });

    $('#clearFilters').on('click', function() {
        $('#searchForm')[0].reset();
        // $('#searchResults').html('');
    });
});

</script>

@endsection
