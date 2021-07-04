<div class="wrapper">
    <div class="navbar">
        <div class="navbar_left">
            <div class="logo">
                <a href="admin.php">ญวนใจขนมปัง</a>
            </div>
        </div>
        <div class="navbar_right">
            <div class="notifications">
                <div class="icon_wrap"><i id="noti-ring" class="far fa-bell" style="position: relative; top: 12px;"></i>
                </div>
                <div class="notification-num" id="noti-num">0</div>
                <div class="notification_dd">
                    <li class="title">
                        <p>การแจ้งเตือน</p>
                    </li>
                    <div class="notification_ul" id="notification_ul"></div>
                    <li class="show_all">
                        <p class="link">แสดงรายการแจ้งเตือนทั้งหมด</p>
                    </li>
                    </ul>
                </div>
            </div>
            <div class="profile">
                <div class="icon_wrap">
                    <div class="img-thumbnail-cd1 img-circle-cd1">
                        <div style="position: relative; padding: 0; cursor: pointer;" type="file" id="profile-picture">
                            <img  src="../IMG/profile/<?php echo $profile_pic; ?>" class="img-circle nav-priflie-pic"
                                style="transform: scale(2); height:20px;">
                        </div>
                    </div>
                    <span class="name"><?=$name?></span>
                    <i class="fas fa-chevron-down"></i>
                </div>

                <div class="profile_dd">
                    <ul class="profile_ul">
                        <li><a class="settings" id="profile-edit"><span class="picon">
                                    <i class="fas fa-cog"></i></span>ตั้งค่า</a></li>
                        <li><a class="logout" href="../logout.php"><span class="picon">
                                    <i class="fas fa-sign-out-alt"></i></span>ออกจากระบบ</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>