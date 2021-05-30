<div class="navbar-fixed">
    <nav class="hoverable  teal lighten-2">
        <div class="container nav-wrapper ">
           <a href="" class="brand-logo right">[contabilidad]</a>

            <ul id="nav-mobile">
                <li><a href="/">Inicio</a></li>
                <li><a href="/ejercicios">Ejecrcicios</a></li>
                <li><a href="/cuentas">Cuentas</a></li>
                <li><a href="asientos">Asientos</a></li>
                <li>
                    <a href="#" class="dropdown-trigger" data-target="book_drop">
                        Libros
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                </li>
                <li>
                    <a href="#" class="dropdown-trigger" data-target="user_drop">
                        Usuario
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>


<ul id="book_drop" class="dropdown-content">
    <li><a href="ldiario">Diario</a></li>
    <li class="divider"></li>
    <li><a href="lmayor">Mayor</a></li>
    <li class="divider"></li>
</ul>

<ul id="user_drop" class="dropdown-content">
    <li><a href="information">Datos personales</a></li>
    <li class="divider"></li>
    <li><a href="password">Contraseña</a></li>
    <li class="divider"></li>
    <li><a href="logout">Salir</a></li>
    <li class="divider"></li>
</ul>

<script>
     document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.sidenav');
        var instances = M.Sidenav.init(elems);
        M.AutoInit()
    });
</script>