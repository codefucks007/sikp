<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>


            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Notifications -->
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell fa-fw"></i>
                        <!-- Counter - Alerts -->
                        <?php if ($data['unread_count'] > 0) : ?>
                            <span class="badge badge-danger badge-counter"><?= $data['unread_count'] ?></span>
                        <?php endif; ?>
                    </a>
                    <!-- Dropdown - Alerts -->
                    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                        <h6 class="dropdown-header">Notifications</h6>
                        <?php foreach ($notifikasi as $item) : ?>
                            <a class="dropdown-item d-flex align-items-center" href="<?= base_url('data_kegiatan/' . $item['id']) ?>">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500"><?= date('d-m-Y H:i', strtotime($item['created_at'])) ?></div>
                                    <span class="font-weight-bold"><?= $item['message'] ?></span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                        <a class="dropdown-item text-center small text-gray-500" href="<?= base_url('notification/show_all') ?>">Show All</a>
                    </div>
                </li>

                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $user['name']; ?></span>
                        <img class="img-profile rounded-circle" src="<?= base_url('assets/img/profile/') . $user['image']; ?>">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <!-- Edit Profile -->
                        <?php if ($user['role_id'] == 2 || $user['role_id'] == 1) : ?>
                            <!-- For User and Admin Roles -->
                            <a class="dropdown-item" href="<?= base_url('user/edit'); ?>">
                                <i class="fas fa-user-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                                Edit Profile
                            </a>
                        <?php elseif (in_array($user['role_id'], [3, 4, 5])) : ?>
                            <!-- For Petugas Roles -->
                            <a class="dropdown-item" href="<?= base_url('petugas/edit_petugas'); ?>">
                                <i class="fas fa-user-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                                Edit Profile
                            </a>
                        <?php endif; ?>
                        <div class="dropdown-divider"></div>

                        <!-- Change Password -->
                        <?php if ($user['role_id'] == 2 || $user['role_id'] == 1) : ?>
                            <!-- For User and Admin Roles -->
                            <a class="dropdown-item" href="<?= base_url('user/changepassword'); ?>">
                                <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                                Ubah Password
                            </a>
                        <?php elseif (in_array($user['role_id'], [3, 4, 5])) : ?>
                            <!-- For Petugas Roles -->
                            <a class="dropdown-item" href="<?= base_url('petugas/changepassword'); ?>">
                                <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                                Ubah Password
                            </a>
                        <?php endif; ?>
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="<?= base_url('auth/logout'); ?>" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>




            </ul>

        </nav>
        <!-- End of Topbar -->