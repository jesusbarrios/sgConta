<div class="navbar-fixed">
    <nav class="hoverable  teal lighten-2">
        <div class="container nav-wrapper ">
           <a href="" class="brand-logo right">Contabilidad | S. de gestión</a>

            <a href="#" data-target="menu-responsive" class="sidenav-trigger">
                <i class="material-icons">menu</i>
            </a>
<?php
if ( $login ) {
?>
            <ul id="nav-mobile" class="left hide-on-med-and-down">
                <li><a href="/">Inicio</a></li>
                <li><a href="/ejercicios">Ejecrcicios</a></li>
                <li><a href="/cuentas">Cuentas</a></li>
                <li><a href="asientos">Asientos</a></li>
                <li>
                    <a href="#" class="dropdown-trigger" data-target="id_drop">
                        Libros
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                </li>
            </ul>
<?php
}
?>
        </div>
    </nav>
</div>
<ul class="sidenav" id="menu-responsive">
    <li><a href="/">Inicio</a></li>
    <li><a href="/ejercicios">Ejecrcicios</a></li>
    <li><a href="/cuentas">Cuentas</a></li>
    <li><a href="asientos">Asientos</a></li>
    <li><a href="ldiario">Libro diario</a></li>
    <li><a href="lmayor">Libro mayor</a></li>
</ul>


<ul id="id_drop" class="dropdown-content">
    <li><a href="ldiario">Diario</a></li>
    <li class="divider"></li>
    <li><a href="lmayor">Mayor</a></li>
    <li class="divider"></li>
</ul>

<script>
     document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.sidenav');
        var instances = M.Sidenav.init(elems);
        M.AutoInit()
    });
</script>