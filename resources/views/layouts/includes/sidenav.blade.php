<div class="sidebar">

    <a href="{{ route('home') }}" class="active"><i class="fas fa-home"></i> Home</a>
    <a href="{{ route('produk.index') }}"><i class="fas fa-shopping-basket"></i> Produk</a>
    <a href="{{ route('profil.index') }}"><i class="fas fa-user"></i> Profil</a>
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
    <form id="logout-form" action="logout" method="POST" style="display: none;">
        @csrf
    </form>
</div>
