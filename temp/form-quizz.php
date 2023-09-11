<!-- Template d'un formulaire de creation de quizz -->

<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form class="custom-border" action="#" method="POST" id="form-quizz">
                    <p id="error-quizz"></p>
                    <!-- Div pour demander le titre -->
                    <div class="mb-3 titre">
                    <label for="titre" class="form-label">Titre du quizz</label>
                    <input type="text" name="titre" id="titre" class="form-control">
                    </div>

                    <div class="mb-3 nb-question">
                    <label for="nb-question" class="form-label">Nombre de question :</label>
                    <input type="number" name="nb-question" id="nb-question" class="form-control" min="0">
                    </div>
                    <div class="questions">

                    </div>
                    <button class="btn btn-primary btn-block" type="button" id="btn-quizz-next">Suivant</button>
                    <button class="btn btn-primary btn-block" type="submit" id="btn-quizz-submit">Valider</button>
                </form>
            </div>
        </div>
    </div>
