<!-- Template du formulaire de connexion -->
<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form class="custom-border" action="#" method="POST" id="form-login">
                <input type="hidden" name="formulaire" value="log">
                <p id="switch-login">Pas encore de compte ? Inscrivez vous !</p>
                <p id="error-log"><small><?php if(!empty($_SESSION["error-log"])){echo $_SESSION["error-log"]; $_SESSION["error-log"] == "";} ?></small></p>
                    <h2 class="mb-4"></h2>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" name="log-submit">Se Connecter</button>
                </form>
            </div>
        </div>
    </div>
