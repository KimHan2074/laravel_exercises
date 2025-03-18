@extends('master')

@section('content')
<div class="container">
    <div id="content" class="space-top-none">
        <div class="main-content">
            <div class="space60">&nbsp;</div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="beta-products-list">
                        @if(isset($results))
                            <h4>Kết quả tìm kiếm</h4>
                            <p class="pull-left">{{ count($results) }} sản phẩm được tìm thấy</p>
                        @else
                            <h4>Search Results</h4>
                            <p class="pull-left">{{ count($results) }} styles found</p>
                        @endif
                        
                        <div class="clearfix"></div>

                        <div class="row">
                           
                            @foreach($results as $rs)
                                <div class="col-sm-3">
                                    <div class="single-item" style="margin-bottom: 20px;">
                                        <div class="single-item-header">
                                            <a href="/detail/{{$rs->id}}">
                                                <img width="200" height="200" src="/source/image/product/{{$rs->image}}" alt="">
                                            </a>
                                        </div>

                                        @if($rs->promotion_price != 0)
                                            <div class="ribbon-wrapper">
                                                <div class="ribbon sale">Sale</div>
                                            </div>
                                        @endif

                                        <div class="single-item-body">
                                            <p class="single-item-title">{{ $rs->name }}</p>
                                            <p class="single-item-price" style="text-align:left;font-size: 15px;">
                                                @if($rs->promotion_price == 0)
                                                    <span class="flash-sale">{{ number_format($rs->unit_price) }} Đồng</span>
                                                @else
                                                    <span class="flash-del">{{ number_format($rs->unit_price) }} Đồng</span>
                                                    <span class="flash-sale">{{ number_format($rs->promotion_price) }} Đồng</span>
                                                @endif
                                            </p>
                                        </div>

                                        <div class="single-item-caption">
                                            <a class="add-to-cart pull-left" href=""> 
                                                <i class="fa fa-shopping-cart"></i>
                                            </a>
                                            <a class="add-to-wishlist" href="">
                                                <i class="fa fa-heart"></i>
                                            </a>
                                            <a class="beta-btn primary" href="/detail/{{$rs->id}}">
                                                Details <i class="fa fa-chevron-right"></i>
                                            </a>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
