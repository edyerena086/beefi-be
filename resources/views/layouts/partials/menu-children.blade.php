<ul class="nav child_menu">
    @foreach ($children as $item)
        @if ($item->children->count() > 1)
            <li><a href="{{url('dashboard/'.$parent.'/'.$item->url)}}">{{$item->name}} <span class="fa fa-chevron-down"></span></a></li>
            @include('layouts.partials.menu-children', ['children' => $item->children, 'parent' => $item->url])
        @else
            <li><a href="{{url('dashboard/'.$parent.'/'.$item->url)}}">{{$item->name}}</a></li>
        @endif
    @endforeach
</ul>