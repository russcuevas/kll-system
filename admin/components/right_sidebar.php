        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#account" data-toggle="tab">ACCOUNT</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="account">
                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 548px;">
                        <ul class="account-settings" style="overflow: hidden; width: auto; height: 548px;">
                            <li style="display: flex; align-items: center;" data-toggle="modal" data-target="#changePassModal">
                                <div>
                                    <label class="mb-0 hov-pointer">
                                        <i class="material-icons mr-2" style="font-size: 18px; vertical-align: middle;">lock</i> Change Password
                                    </label>
                                </div>
                            </li>

                            <li onclick="Logout()" style="display: flex; align-items: center;">
                                <div>
                                    <label class=" mb-0 hov-pointer">
                                        <i class="material-icons mr-2" style="font-size:18px; vertical-align: middle;">exit_to_app</i>
                                        Log Out
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->