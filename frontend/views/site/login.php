<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;

?>
<div class="site-contact">
    <div class="row" id="row-form-todo-list">
        <div class="col-lg-6" id="panel-sigin">
            <h1>Sign In</h1>
            <p>Sign in to manage URL.</p>
            <div class="panel panel-default">
                <div class="panel-body">
                    <form id="todolist-form">
                        <div class="form-group">
                            <label>Username</label>
                            <input class="form-control" placeholder="Masukkan username anda" id="signin-username">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Masukkan password anda" id="signin-password">
                        </div>
                        <div class="alert alert-info" id="signin-alert">You can sign in if already have an account.</div>
                    </form>
                </div>
                <div class="panel-footer">
                    <div class="form-group" class="text-right">
                        <button type="button" class="btn btn-success" id="btn-signin-signin">Sign In</button>
                        <button type="button" class="btn btn-warning" id="btn-signin-signup">Have no account ? Sign Up!</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6" id="panel-sigup">
            <h1>Sign Up</h1>
            <p>Sign up to start manage URL!</p>
            <div class="panel panel-default">
                <div class="panel-body">
                    <form id="todolist-form">
                        <div class="form-group">
                            <label>Username</label>
                            <input class="form-control" placeholder="Masukkan username" id="signup-username">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Masukkan password" id="signup-password">
                        </div>
                        <div class="form-group">
                            <label>Retype Password</label>
                            <input type="password" class="form-control" placeholder="Ketik ulang password" id="signup-password2">
                        </div>
                        <div class="alert alert-info" id="signup-alert">Please fill all fields above.</div>
                    </form>
                </div>
                <div class="panel-footer">
                    <div class="form-group" class="text-right">
                        <button type="button" class="btn btn-success" id="btn-signup-signup">Create</button>
                        <button type="button" class="btn btn-warning" id="btn-signup-signin">Have an account ? Sign In!</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-form-todolist" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-hidden="true" id="btn-cancel2-delete-todo-list">&times;</button>
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure want to delete di record ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="btn-cancel-delete-todo-list">Cancel</button>
                <button type="button" class="btn btn-primary" id="btn-delete-todo-list">Yes, I'm Sure!</button>
            </div>
        </div>
    </div>
</div>