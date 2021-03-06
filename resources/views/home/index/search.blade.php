<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <meta http-equiv="Cache-Control" content="no-transform">
    <title>yell cool</title>

    <link rel="shortcut icon" href="http://doweit.com/usr/themes/default/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('home/css/laymei.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('home/css/drop_menu.css') }}" type="text/css">
    
</head>
    <body>
    <div id="header" class="dowe-shead">
    <div class="hbox clearfix">
        <h1 class="logo">
            <a title="" href="/"></a>
        </h1>
        <div class="nav" id="head_nav">
            <div class="box">
                <ul id="nav_links" class="select_main clearfix">
                    <li>
                        <a class="menu" href="/"><strong>首页</strong></a>
                    </li>
                    
                    <li>
                        <a class="menu" href="javascript:;"><strong class="icon">分类</strong></a>
                        <ul class="drop category">
                            @foreach($cates as $cate)
                            <li class="clear"><a href="{{url('home/index')}}/{{$cate->id}}">{{$cate->name}}</a></li>
                            @endforeach
                        </ul>  
                    </li>
                    <li>
                        <a class="menu" href="/topic/46"><strong>朋友圈</strong></a>
                    </li>
                    
                   
                </ul>
            </div>
            <!-- /box -->
        </div>
        <!-- /nav -->
        <div class="search_form">
            <form method="get" action="{{url('home/index/search_goods')}}" class="form">
            
                <input type="text" style="color: rgb(182, 183, 185);" onkeydown="this.style.color='#404040'" autocomplete="off" name="kw" value="" class="sr" placeholder="搜索">
                <input type="submit" class="sub" value="搜索">
            </form>
        </div>
        <!--/ search_form-->
    </div>
    
    </div>
        <!-- /header cocodiy-shead-->
<div id="content">

    <div class="crumbs_nav">
        关键字 '{{$kw}}' 的搜索结果如下：
    </div>
    <!-- /crumbs_nav -->

    <div class="goods-probox clearfix">
        <ul class="clearfix">
        @foreach($goods as $good)
            <li id="goods_{{$good->id}}" class="">
                <dl>
                    <dt>
                        <a target="_blank" class="img-h" href="{{$good->link_tui}}">
                            <img class="lazy" alt="{{$good->title}}" src="{{$good->pic_url}}" data-original="{{$good->pic_url}}" style="display: inline;">
                        </a>
                        
                        <!-- <span class="bt">推荐</span> -->
                    </dt>
                    <!-- <dd class="name">
                        <a target="_blank" href="{{$good->link_tui}}">{{$good->title}}</a>
                    </dd> -->
                    <dd class="pricebox">
                        <span class="price">
                            <span class="rmb">¥</span><span class="m-num">{{$good->price}}</span>
                        </span>
                        <a href="javascript:;" onclick="pickGoods({{$good->id}})" class="likebut-num" id="pick_{{$good->id}}" title="喜欢">{{$good->like}}</a>
                    </dd>
                </dl>
            </li>
            @endforeach

            
        </ul>
        	
    </div>

    <div class="page tc">       
        {{ $goods->appends(['kw' => $kw])->links() }}
        
        @if($goods->count() == 0)
			抱歉.未查找到结果!
        @endif
    </div>
    <!--/ page-->
</div>
<!-- /content -->
<script type="text/javascript" src="{{ asset('home/js/jquery-1.7.2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('home/js/jquery.lazyload.js') }}"></script>
<script type="text/javascript" src="{{ asset('home/js/drop_menu.js') }}"></script>

<script type="text/javascript">
$(document).ready(function () {
        for(var i=0; i<localStorage.length;i++){
            var key_name = localStorage.key(i);
            if (key_name.indexOf('key') != -1) {
                var local_data = JSON.parse(localStorage.getItem(key_name));
                $('#'+local_data.id).addClass('hover');
            }
        }
    });
    $(".goods-probox li").hover(function () {
        $(this).addClass("hover");
    }, function () {
        $(this).removeClass("hover");
    });
    $(".goods-probox li:nth-child(4n)").addClass('last');
    
    function pickGoods(gid) {
        var el_id = 'pick_'+gid;
        var  info ={id:el_id,msg:'ok'};
        if (localStorage.getItem("key"+gid) === null) {
            $.ajax({
                type:'post',
                url:"{{url('home/index/pick_goods')}}",
                data:{gid:gid , _token:"{{csrf_token()}}"},
                success:function(data) {
                    if (data.code ==200) {
                        var num = parseInt($('#pick_'+gid).text());
                        $('#pick_'+gid).text(num+1);
                        $('#pick_'+gid).addClass('hover');
                        // 本地存储
                        localStorage.setItem('key'+gid, JSON.stringify(info));
                        
                    }
                }
            });
        }
    }
</script>

<div id="footer">
    <div class="slinks mb">
        <a href="/about/aboutus.html" target="_blank">关于我们</a>
        <a href="/about/shop.html" target="_blank">如何购买</a>
        <a href="/about/biz.html" target="_blank">商家合作</a>
        <a href="/about/link.html" target="_blank">友情链接</a>
        <a href="/about/law.html" target="_blank">版权声明</a>
        <a href="/about/contact.html" target="_blank">联系我们</a>
    </div>
    <div class="copyright">
    	©2017 Cocodiy.com All Rights Reserved.
    </div>
</div>
    <!-- /footer -->


</body>
</html>