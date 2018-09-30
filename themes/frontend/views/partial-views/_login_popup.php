<div class="modal fade" id="login-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4>
                    <span class="svg svg-user-login"></span>
                    <span>ثبت آگهی / ورود به حساب کاربری</span>
                    <span><button type="button" data-dismiss="modal" class="close">&times;</button></span>
                </h4>
            </div>
            <div class="modal-body">
                <?= $this->renderPartial('//partial-views/_loading') ?>
                <div class="tab-content">
                    <!--  User Auth Tab -->
                    <div id="login-modal-auth-tab" class="auth-tab tab-pane active in divider-parent">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 login-box">
                            <div class="icon-box">
                                <div class="icon-inner-box">
                                    <i class="svg-icons lock-icon"></i>
                                </div>
                            </div>
                            <div class="button-box">
                                <p>عضو سایت هستید؟
                                    برای ثبت آگهی خود وارد شوید</p>
                                <button type="button" data-toggle="tab" data-target="#login-modal-login-tab" class="btn btn-custom blue next-in">
                                    ورود به حساب کاربری
                                    <span class="next-span"><i class="icon-chevron-left"></i></span>
                                </button>
                            </div>
                        </div>
                        <div class="col-divider hidden-sm hidden-xs"></div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 register-box">
                            <div class="icon-box">
                                <div class="icon-inner-box">
                            <span class="circle-border">
                                <i class="svg-icons user-icon"></i>
                            </span>
                                </div>
                            </div>
                            <div class="button-box">
                                <p>تازه وارد هستید؟
                                    برای ثبت آگهی خود ثبت‌نام کنید</p>
                                <button type="button" data-toggle="tab" data-target="#login-modal-register-tab" class="btn btn-custom green next-in">
                                    ساخت حساب کاربری
                                    <span class="next-span"><i class="icon-chevron-left"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!--  Login Tab -->
                    <div id="login-modal-login-tab" class="auth-tab login-tab tab-pane fade">
                        <div class="col-lg-7 col-md-7 col-sm-10 col-xs-12 col-lg-push-2 col-md-push-2 col-sm-push-1 login-box">
                            <?= $this->renderPartial('users.views.public._ajaxLogin',array('loading_parent' => '#login-modal')); ?>
                        </div>
                    </div>
                    <!--  Forget Tab -->
                    <div id="login-modal-forget-password-tab" class="auth-tab login-tab tab-pane fade">
                        <div class="col-lg-7 col-md-7 col-sm-10 col-xs-12 col-lg-push-2 col-md-push-2 col-sm-push-1 login-box">
                            <?= $this->renderPartial('users.views.public._ajaxForget',array('loading_parent' => '#login-modal')); ?>
                        </div>
                    </div>
                    <!--  Register Tab -->
                    <div id="login-modal-register-tab" class="auth-tab register-tab tab-pane fade">
                        <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12 col-lg-push-1 col-md-push-1 register-box">
                            <?= $this->renderPartial('users.views.public._ajaxRegister',array('loading_parent' => '#login-modal')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>