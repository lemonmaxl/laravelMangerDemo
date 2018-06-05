<!-- 左侧导航开始-->
@inject('leftMenus', 'App\Repositories\Presenter\MenuPresenter')
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="nav-close"><i class="fa fa-times-circle"></i>
    </div>
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span><img alt="image" class="img-circle" src="{{ asset('img/profile_small.jpg') }}" /></span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                       <span class="block m-t-xs"><strong class="font-bold">{{Auth::guard('admin')->user()->username}}</strong></span>
                        <span class="text-muted text-xs block">
                            @empty($roleName)
                                无操作权限
                            @else
                                {{implode(',' , $roleName)}}
                            @endempty
                            <b class="caret"></b>
                        </span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="J_menuItem" href="form_avatar.html">修改头像</a>
                        </li>
                        <li><a class="J_menuItem" href="profile.html">修改密码</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="/admin/logout">安全退出</a>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">H+
                </div>
            </li>
            {!! $leftMenus->getLeftMenusList($leftMenusList) !!}
            

        </ul>
    </div>
</nav>
<!--左侧导航结束