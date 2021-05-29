<div class="container section">
    <div class="row">
    <div class="col s12 m4"></div>
    <div class="col s12 m4">
        <form class="card hoverable">
            <div class="card-content">
                <span class="card-title center-align">Acceso al sistema</span>
                <!-- <form action="#"> -->
                <div class="s12 input-field">
                    <!-- <i class="material-icons prefix">phone</i> -->
                    <input type="text" id="usuario" class="validate" required >
                    <label for="usuario">Usuario</label>
                </div>
                <div class="s12 input-field">
                    <!-- <i class="material-icons prefix">email</i> -->
                    <input type="password" id="password" class="validate" required>
                    <label for="password">Clave de acceso</label>
                </div>
                <div class="s12 offset-s1">
                    <button class="btn waves-effect waves-light" type="submit" name="login">
                        <i class="material-icons left">vpn_key</i>
                        Ingresar
                    </button>
                    <!-- <a class="waves-effect waves-light btn"><i class="material-icons left">cloud</i>Recuperar clave</a> -->
                </div>
                <!-- <div class="s12">
                    <br>
                    <blockquote>Solo para usuarios registrados.</blockquote>
                </div> -->
            </div>
        </form>
    </div>
    <div class="col s12 m4"></div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        M.AutoInit()
    })
    // $(document).ready(function(){
    //     $('.collapsible').collapsible();
    // });
</script>