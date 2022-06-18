
<div class="col-md-5 text">
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><b>Zaloguj się</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="index.php" method="post">
                        <label> <i class="fas fa-user"></i>Nazwa użytkownika</label>
                        <div>
                            <input type="text" placeholder="Username" name="login" required />
                        </div>

                        <label><i class="fas fa-key"></i>Hasło</label>
                   
                        <div>
                            <input type="password" placeholder="Password" name="password" required />
                        </div>

                        <div>
                            <button class="btn btn-dark" type="submit"><i class="fas fa-lock"></i>Login </button>
                        </div>
                    </form>
                </div>
            </div>
        </div><br>
    </div>
</div>