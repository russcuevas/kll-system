<aside id="leftsidebar" class="sidebar">
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header" style="font-size:14px !important; color: #333 !important;">Administrator <br>
                <label style="font-weight:700; color: #7D0A0A;">
                    <?php echo $_SESSION['fullname']; ?> <br>
                    <?php echo $_SESSION['email']; ?>
                </label>
            </li>
            <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
                <a href="index.php">
                    <i class="material-icons">home</i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="<?php echo (in_array(basename($_SERVER['PHP_SELF']), ['admin_management.php', 'add_admin.php', 'update_admin.php'])) ? 'active' : ''; ?>">
                <a href="admin_management.php">
                    <i class="material-icons">admin_panel_settings</i>
                    <span>Admin</span>
                </a>
            </li>
            <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'add_examiners.php' || basename($_SERVER['PHP_SELF']) == 'examinees_list.php' || basename($_SERVER['PHP_SELF']) == 'add_default_id.php') ? 'active' : ''; ?>">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">groups</i>
                    <span>Examinees</span>
                </a>
                <ul class="ml-menu">
                    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'add_examiners.php' || basename($_SERVER['PHP_SELF']) == 'add_default_id.php') ? 'active' : ''; ?>">
                        <a href="add_examiners.php">Add Examiners</a>
                    </li>
                    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'examinees_list.php') ? 'active' : ''; ?>">
                        <a href="examinees_list.php">Examinees List</a>
                    </li>
                </ul>
            </li>

            <li class="<?php echo (
                            basename($_SERVER['PHP_SELF']) == 'course.php' ||
                            basename($_SERVER['PHP_SELF']) == 'questionnaire.php' ||
                            basename($_SERVER['PHP_SELF']) == 'add_course.php' ||
                            basename($_SERVER['PHP_SELF']) == 'update_course.php' ||
                            basename($_SERVER['PHP_SELF']) == 'add_questionnaire.php' ||
                            basename($_SERVER['PHP_SELF']) == 'update_questionnaire.php' ||
                            basename($_SERVER['PHP_SELF']) == 'update_question.php'
                        ) ? 'active' : ''; ?>">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">description</i>
                    <span>Assessment</span>
                </a>
                <ul class="ml-menu">
                    <li class="<?php echo (
                                    in_array(basename($_SERVER['PHP_SELF']), ['course.php', 'add_course.php', 'update_course.php'])
                                ) ? 'active' : ''; ?>">
                        <a href="course.php">Course</a>
                    </li>
                    <li class="<?php echo (
                                    in_array(basename($_SERVER['PHP_SELF']), ['questionnaire.php', 'add_questionnaire.php', 'update_question.php']) // <-- Also updated this line
                                ) ? 'active' : ''; ?>">
                        <a href="questionnaire.php">Questionnaire</a>
                    </li>
                </ul>
            </li>

            <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'exam_results.php' || basename($_SERVER['PHP_SELF']) == 'view_results.php') ? 'active' : ''; ?>">
                <a href="exam_results.php">
                    <i class="material-icons">done_all</i>
                    <span>Exam Results</span>
                </a>
            </li>

        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
    </div>
    <!-- #Footer -->
</aside>