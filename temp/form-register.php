<!-- Template du formulaire d'inscription -->
<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form class="custom-border" action="login.php" method="POST" id="form-reg">
                    <input type="hidden" name="formulaire" value="reg">
                <p id="switch-reg">Déja un compte ? Connectez-vous </p>
                <p id="error-reg"><small></small></p>
                    <h2 class="mb-4"></h2>
                    <div class="mb-3">
                        <label for="reg-email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="reg-email" name="reg-email">
                    </div>
                    <div class="mb-3">
                        <label for="reg-password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="reg-password" name="reg-password">
                    </div>
                    <div class="mb-3">
                        <label for="reg-password" class="form-label">Repetez votre mot de passe</label>
                        <input type="password" class="form-control" id="reg-rp-password" name="reg-rp-password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" name="reg-submit">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
