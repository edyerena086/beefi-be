<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><i class="fa fa-desktop"></i> <span>{{ENV('APP_NAME')}}</span></a>
        </div>

        <div class="clearfix"></div>

        {{-- Profile info --}}
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="{{asset('images/user.png')}}" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>¡Hola!</span>
                <h2>{{Auth::user()->name}}</h2>
            </div>
        </div>

        {{-- Menu --}}
        @include('layouts.partials.menu')
    </div>
</div>