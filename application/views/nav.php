<div class="navbar-fixed">
    <nav class="hoverable  teal lighten-2">
        <div class="container nav-wrapper ">
           <a href="" class="brand-logo right hide-on-med-and-down">[contabilidad]</a>
           <a href="" class="brand-logo right sidenav-trigger">[conta]</a>

            <a href="#" data-target="menu-responsive" class="sidenav-trigger">
                <i class="material-icons">menu</i>
            </a>

            <ul id="nav-mobile" class="left hide-on-med-and-down">
                <li><a href="/">Inicio</a></li>
                <li><a href="/exercises">Ejecrcicios</a></li>
                <li><a href="/accounts">Cuentas</a></li>
                <li><a href="entries">Asientos</a></li>
                <li>
                    <a href="#" class="dropdown-trigger" data-target="book_drop">
                        Libros
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                </li>
                <li>
                    <a href="#" class="dropdown-trigger" data-target="balance_drop">
                        Balances
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                </li>
                <!-- <li>
                    <a href="#" class="dropdown-trigger" data-target="user_drop">
                        Usuario
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                </li> -->
                <li><a href="logout">Salir</a></li>
            </ul>
        </div>
    </nav>
</div>

<ul class="sidenav" id="menu-responsive">
    <li><a href="/">Inicio</a></li>
    <li><a href="/exercises">       Ejecrcicios</a></li>
    <li><a href="/accounts">        Cuentas</a></li>
    <li><a href="entries">          Asientos</a></li>
    <li class="divider"></li>
    <li><a href="diarybook">        Libro diario</a></li>
    <li><a href="ledger">           Libro mayor</a></li>
    <li class="divider"></li>
    <li><a href="balancesheet">     Balance general</a></li>
    <li><a href="result">           Balance de resultados</a></li>
    <li class="divider"></li>
    <!-- <li><a href="informatios">      Datos personales</a></li> -->
    <!-- <li><a href="password">         Contraseña</a></li> -->
    <li><a href="logout">           Salir</a></li>
</ul>

<ul id="book_drop" class="dropdown-content">
    <li><a href="diarybook">  Diario</a></li>
    <li class="divider"></li>
    <li><a href="ledger">   Mayor</a></li>
    <li class="divider"></li>
</ul>

<ul id="balance_drop" class="dropdown-content">
    <li><a href="balancesheet">     General</a></li>
    <li class="divider"></li>
    <li><a href="result">   Resultados</a></li>
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

<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
     document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.sidenav');
        var instances = M.Sidenav.init(elems);
        M.AutoInit()
    });
</script>
