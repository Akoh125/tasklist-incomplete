
<header class="mb-4">
    <nav class="navbar bg-neutral text-neutral-content">
        {{-- トップページへのリンク --}}
        <div class="flex-1">
            <h1><a class="btn btn-ghost normal-case text-xl" href="{{ route('tasks.index') }}">Tasklists</a></h1>
        </div>

        <div class="flex">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <ul tabindex="0" class="menu lg:menu-horizontal">
                    @include('commons.link_items')
                </ul>
            </form>
        </div>
    </nav>
</header>