@auth
    <ul>
        <li><a class="text-blue-400" href="{{route('seller.items.index')}}">商品一覧</a></li>
        <li><a href="{{ route('seller.items.create') }}" class="btn btn-primary">商品登録</a></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="route('logout')"
            onclick="event.preventDefault();
            this.closest('form').submit();">ログアウト</a>
            </form>
        </li>
        <li><a class="text-blue-400" href="{{route('profile.edit')}}">マイページ</a></li>
    </ul>
@else
<ul>
    <li><a class="text-blue-400" href="{{route('seller.items.index')}}">商品一覧</a></li>
    <li><a href="{{ route('seller.items.create') }}" class="btn btn-primary">商品登録</a></li>
    <li><a class="text-blue-400" href="{{route('login')}}">ログイン</a></li>
    <li>
        <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="route('logout')"
        onclick="event.preventDefault();
        this.closest('form').submit();">ログアウト</a>
        </form>
    </li>
    <li><a class="text-blue-400" href="{{route('profile.edit')}}">マイページ</a></li>
</ul>
@endauth
