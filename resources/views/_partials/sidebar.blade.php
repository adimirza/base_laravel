<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ url('') }}" class="brand-link">
        <img src="{{ url('upload/image/logo/'.$profil->getProfil()['logo']->logo) }}" alt="{{ $profil->getProfil()['nama']->nama }} Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ $profil->getProfil()['nama']->nama }}</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ url('/assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ session()->get('username') }}</a>
            </div>
        </div>
        <nav class="mt-2">
            <?php
            use App\Lib\GetMenu;
            $menu = new GetMenu;
            echo $menu->getMenus($title);
            ?>
        </nav>
        <div class="sidebar-custom">
            <br>
            <center>
                <a href="{{ url('http://localhost:8000/logout') }}" class="btn btn-secondary btn-block">Log Out</a>
            </center>
        </div>
    </div>
</aside>