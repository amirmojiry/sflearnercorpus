<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <div class="image">
                <img src="../../images/user.png" width="48" height="48" alt="User" />
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <a href="profile.php">
                        <?php echo $userRow['First_Name']." ".$userRow['Last_Name']; ?>
                    </a>
                </div>
                <div class="email">
                    <?php echo $userRow['Email']; ?>
                </div>
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="profile.php">
                                <i class="material-icons">
                                    person
                                </i>
                                پروفایل
                            </a>
                        </li>
                        <li>
                            <a href="changepass.php">
                                <i class="material-icons">
                                    person
                                </i>
                                تغییر گذرواژه
                            </a>
                        </li>
                        <li role="seperator" class="divider"></li>
                        <li><a href="logout.php?logout">
                                <i class="material-icons">
                                    input
                                </i>
                                خروج
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">
                    پیکره زبان آموز
                </li>
                <?php
                if ($userRow['Level'] == '1'){
                    echo '<li>
                    <a href="adminProfile.php">
                        <i class="material-icons">layers</i>
                        <span>
                            پروفایل مدیریتی
                        </span>
                    </a>
                </li>';
                }
                ?>
                
                <li>
                    <a href="profile.php">
                        <i class="material-icons">home</i>
                        <span>
                            پروفایل
                        </span>
                    </a>
                </li>
                <li>
                    <a href="home.php">
                        <i class="material-icons">text_fields</i>
                        <span>
                            وارد کردن متن
                        </span>
                    </a>
                </li>
                <!--<li>
                    <a href="statistic.php">
                        <i class="material-icons">layers</i>
                        <span>
                            آمار کاربران
                        </span>
                    </a>
                </li>-->
                <li>
                    <a href="viewtext.php">
                        <i class="material-icons">layers</i>
                        <span>
جستجوی متن
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <?php include 'footer.php';?>
        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
</section>