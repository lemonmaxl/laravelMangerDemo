/*
 鏇挎崲select涓哄彲缂栬緫鏍峰紡
 */
function repselect(className) {
    var se = $("." + className);
    var seli = se.find("ul li");
    se.hover(function () {
            $(this).css("z-index", "9999");
            $(this).find(".select_item").addClass("active");
            $(this).find("ul.item_list").css("display", "block");
        },
        function () {
            $(this).css("z-index", "");
            $(this).find("ul.item_list").css("display", "none");
            $(this).find(".select_item").removeClass("active");
        }
    );
    return false;
    seli.click(function () {
        $(this).parent().parent().find("span.select_item").html($(this).find("a").html());
        $(this).parent().parent().find("input").val($(this).find("a").attr("dc"));
        if ($(this).find("a").attr("dc") == 'bldgcode') {
            $(this).parent().parent().find("input").attr('name', 'bldgcode');
            $(this).parent().parent().find("input").val('21');
            $('#houselr').val('0');
            $('#houseba').val('0');
        }
        $(this).parent().css("display", "none");
    });
}
function repselect2(className) {
    var se = $("." + className);
    var seli = se.find("ul li");
    se.hover(
        function () {
            $(this).css("z-index", "9999");
            $(this).find("ul.item_list").css("display", "block");
        },
        function () {
            $(this).css("z-index", "");
            $(this).find("ul.item_list").css("display", "none");
        }
    );
    seli.click(function () {
        $(this).parent().parent().find("span.mn").html($(this).find("a").html());
        $(this).parent().parent().find("input").val($(this).find("a").attr("dc"));
        if ($(this).find("a").attr("dc") == 'bldgcode') {
            $(this).parent().parent().find("input").attr('name', 'bldgcode');
            $(this).parent().parent().find("input").val('21');
            $('#houselr').val('0');
            $('#houseba').val('0');
        }
        $(this).parent().css("display", "none");
    });
}




//detailbanner
//par
//contag
//menu
//menutag
function detailbanner(par,contag,menu,menutag){
    var contArray=jQuery(par+" "+contag);
    var menuArray=jQuery(menu+" "+menutag);
    menuArray.each(function(i){
        jQuery(this).click(function(){
            menuArray.each(function(n){
                if(i==n){
                    if(jQuery(contArray[n]).attr("style"))jQuery(contArray[n]).removeAttr("style");
                    jQuery(this).addClass("selected");
                }else{
                    jQuery(this).removeClass("selected");
                    jQuery(contArray[n]).css("display","none");
                }

            })
        });
    });

    $(".photo .banner").hover(
            function () {
                $(this).addClass("hover");
                $(".alpha-bg").attr("style", "height:450px;");
            },
            function () {
                $(this).removeClass("hover");
            }
    );


}

// navlist
function navlist(cont, ss, links) {
    var linksbox = $(ss + " " + links);
    $(cont).hover(
        function () {
            $(this).addClass("hover");
            $(ss).attr("style", "display:block");
        },
        function () {
            $(this).removeClass("hover");
            $(ss).attr("style", "display:none");
        }
    );
    $(ss).hover(
        function () {
            $(this).addClass("hover");
            $(cont).addClass("hover");
            $(ss).attr("style", "display:block");
        },
        function () {
            $(this).removeClass("hover");
            $(cont).removeClass("hover");
            $(ss).attr("style", "display:none");
        }
    );
    $(links).hover(
        function () {
            $(this).addClass("hover");
        },
        function () {
            $(this).removeClass("hover");
        }
    );
}

// menubox
function menubox(cont, ss) {
    $(cont).hover(
        function () {
            $(this).addClass("hover");
            //cont).children(ss).attr("style", "display:block");
        },
        function () {
            $(this).removeClass("hover");
            //cont).children(ss).attr("style", "display:none");
        }
    );
}


//杩斿洖椤堕儴js
function b() {
    h = $(window).height();
    t = $(document).scrollTop();
    if (t > h) {
        $('#gotop').show();
    } else {
        $('#gotop').hide();
    }
    
    $("#tbox .share").hover(
      function () {
        $(this).addClass("hover");
      },
      function () {
        $(this).removeClass("hover");
      }
    );


    $("#xiangguan").hover(
        function () {
            $(this).addClass("hover");
        },
        function () {
            $(this).removeClass("hover");
        }
    );
    

}
$(window).scroll(function (e) {
    b();
})

$(document).ready(function(){
    b();
});


//棣栭〉搴曢儴鎮诞鑺傛棩鏁堟灉

jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') {
        options = options || {};
        if (value === null) {
            value = '';
            options = $.extend({}, options);
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 100 * 60 * 60 * 1000));//day * 24hour  60min  60sc  1000haomiao
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString();
        }
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else {
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};

$(document).ready(function(){
        var panda =$(".holiday");
        panda.find("span").click(function(){
            panda.fadeOut(600);
            $.cookie('closediv','close',{ expires: 1});
        });
        var hc = $.cookie('closediv');
        if(hc=="close"){
            panda.hide()
        }else{
            panda.show()
        } 

        var tipsfiiler =$(".tips");
        tipsfiiler.find("span").click(function(){
            tipsfiiler.fadeOut(600);
            $.cookie('closediv2','close',{ expires: 1});
        });
        var hc = $.cookie('closediv2');
        if(hc=="close"){
            tipsfiiler.hide()
        }else{
            tipsfiiler.show()
        } 
});

// 澶撮儴鎮诞鏁堟灉
function head_nav_fixtop() {
    var head_nav = document.getElementById("header");
    if (document.documentElement && document.documentElement.scrollTop) {
        scroll_top = document.documentElement.scrollTop;
    }
    else if (document.body) {
        scroll_top = document.body.scrollTop;
    }
    if (scroll_top > 120) {
         // head_nav.className = "head app_fixdiv";
        $(head_nav).addClass("app_fixdiv");

        head_nav.style.top = 0;
    }
    if (scroll_top <= 120) {
        //head_nav.className = "head";
        $(head_nav).removeClass("app_fixdiv");
        head_nav.style.top = '';
    }
}

var is_store = 0;
function likeGood(id) {
    var favnum = parseInt($('#fav_num').text().replace('(', '').replace(')', ''));
    var like_dom = null;
    if ($('#like_' + id).length) {
        like_dom = $('#like_' + id);
    } else {
        like_dom = $('#like_' + id + '_num');
    }
    if (like_dom.hasClass('hover')) {
        favnum--;
        $('.fav_num').html(favnum);
        setOwned(false, id);
        $('#xiangguan').addClass('hover');
        setTimeout(function () {
            $('#xiangguan').removeClass('hover');
        }, 5000);
        if (is_store) {
            $('#good_' + id).fadeOut();
        }
    } else {
        if (like_dom.length > 0) {
            $('#xiangguan').addClass('hover');
            setTimeout(function () {
                $('#xiangguan').removeClass('hover');
            }, 5000);
            favnum++;
            $('#fav_num').html('(' + favnum + ')');
        }
        setOwned(true, id);
    }
}
var fav_goods = '';
function setOwned(is_owned, gid) {
    var like_num = '';
    if($('#like_' + gid).length){
         like_num = $('#like_' + gid).attr('rel');
    }else{
         like_num = $('#like_' + gid + '_num').attr('rel');
    }
    var owncache = fav_goods;
    owncache = owncache || "";
    var owns = owncache.split(',');
    var newowns = [];
    is_owned = is_owned || false;
    for (var i in owns) {
        if (owns[i] != gid && owns[i]) {
            newowns.push(owns[i]);
        }
    }
    if (is_owned) {
        like_num = parseInt(like_num) + 1;
        newowns.push(gid);
        if ($('#like_' + gid).find('strong').length) {
            $('#like_' + gid).addClass('hover');
            $('#like_' + gid).find('strong').html(like_num + '');
        } else if ($('#like_' + gid).find('span').length && $('#like_' + gid).find('strong').length == 0) {
            $('#like_' + gid).addClass('hover');
            $('#like_' + gid).find('span').html(like_num + '');
        } else {
            $('#like_' + gid).addClass('hover').html(like_num + '浜哄凡鍠滄');
            $('#like_' + gid + '_num').addClass('hover').html(like_num + '');
        }
        $.post('/like', {
            ac: 'add',
            id: gid
        }, function (data) {
            $('#liked_' + gid).html(data);
        });
    } else {
        like_num = parseInt(like_num) - 1;
        like_num = like_num >= 0 ? like_num : 0;
        if ($('#like_' + gid).find('strong,span').length) {
            $('#like_' + gid).removeClass('hover');
            $('#like_' + gid).find('strong,span').html(like_num + '');
        } else {
            $('#like_' + gid).removeClass('hover').html(like_num + '浜哄凡鍠滄');
            $('#like_' + gid + '_num').removeClass('hover').html(like_num + '');
        }
        $.post('/like', {
            ac: 'remove',
            id: gid
        }, function (data) {
//            $('#liked_' + gid).html(data);
        });
    }
    fav_goods = newowns.join(',');
//    $.cookie('owned', newowns.join(','), {expires: 9999, path: '/' });
}
function initOwned() {
    var owncache = fav_goods;
    owncache = owncache || "";
    var owns = owncache.split(',');
    for (var i in owns) {
        $('#like_' + owns[i]).addClass('hover').html('宸插枩娆�');
        $('#like_' + owns[i] + '_num').addClass('hover');
    }
}
function gongLike(gong_id, me) {
    $.ajax({
        type: 'POST',
        url: '/gongluelike',
        data: {"gonglue_id": gong_id},
        dataType: "json",
        cache: false,
        success: function (jdata) {
            $('#liked_' + gong_id).find('span').html(jdata);
            // $(me).html('宸插枩娆�');
        },
        error: function (jdata) {
            alert(jdata.info);
        }
    });
}
$(document).ready(function () {
    var panda = $(".holiday");
    initOwned();
    panda.find("span").click(function () {
        panda.fadeOut(600);
        $.cookie('closediv', 'close', {expires: 1});
    });
    var hc = $.cookie('closediv');
    if (hc == "close") {
        panda.hide()
    } else {
        panda.show()
    }
    initOwned();
    $('.ask_like').click(function () {
        var me = this;
        var id = $(me).attr('data-rel');
        $.ajax({
            type: 'POST',
            url: '/asklike',
            data: {"ask_id": id},
            dataType: "json",
            cache: false,
            success: function (jdata) {
                $(me).next('.num').find('span').html(jdata + '');
            },
            error: function (jdata) {
                alert(jdata.info);
            }
        });
    })
});