<ul>
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
    <li><a class="text-blue-400" href="{{route('cart.index')}}">カート</a></li>
    {{-- <li><a class="text-blue-400" href="{{route('purchase.index')}}">購入履歴</a></li> --}}
    <li><a class="text-blue-400" href=''></a>お気に入り</li>
</ul>
