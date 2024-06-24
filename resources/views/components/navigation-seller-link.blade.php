<ul>
    <li><a class="text-blue-400" href="{{route('seller.login')}}">ログイン</a></li>
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
