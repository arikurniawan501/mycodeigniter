 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-light-info elevation-4">
     <a href="index3.html" class="brand-link navbar-info">
         <img src="<?= base_url('assets/') ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3 " style="opacity: .8">
         <span class="brand-text font-weight-light text-white">SURATKU</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 <img src="<?= base_url('assets/') ?>dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
             </div>
             <div class="info">
                 <a href="#" class="d-block"><?= $this->session->userdata('username') ?></a>
             </div>
         </div>

         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                 <?php

                    ?>
                 <li class="nav-item">
                     <a href="<?= base_url('') ?>" class="nav-link <?= $this->uri->segment(1) == "" ? 'active' : "" ?>">
                         <i class="fa fa-home nav-icon text-danger"></i>
                         <p>DASHBOARD</p>
                     </a>
                 </li>
                 <li class=" nav-item has-treeview <?= $this->uri->segment(2) == "jabatan" || $this->uri->segment(2) == "skpd" || $this->uri->segment(2) == "unit_kerja" || $this->uri->segment(2) == "golongan" ? 'menu-open' : "" ?>">
                     <a href=" #" class="nav-link <?= $this->uri->segment(2) == "jabatan" || $this->uri->segment(2) == "skpd" || $this->uri->segment(2) == "unit_kerja" || $this->uri->segment(2) == "golongan" ? 'active' : "" ?>">
                         <i class=" nav-icon fas fa-th text-success"></i>
                         <p> DATA MASTER<i class="right fas fa-angle-left"></i></p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="<?= base_url('master/jabatan') ?>" class="nav-link <?= $this->uri->segment(2) == "jabatan" ? 'active' : "" ?>">
                                 <i class=" fa fa-file-import nav-icon text-info"></i>
                                 <p>Jabatan</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="<?= base_url('master/golongan') ?>" class="nav-link <?= $this->uri->segment(2) == "golongan" ? 'active' : "" ?>">
                                 <i class=" fa fa-file-import nav-icon text-info"></i>
                                 <p>Golongan</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="<?= base_url('master/skpd') ?>" class="nav-link <?= $this->uri->segment(2) == "skpd" ? 'active' : "" ?>">
                                 <i class="fa fa-file-import nav-icon text-info"></i>
                                 <p>SKPD</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="<?= base_url('master/unit_kerja') ?>" class="nav-link <?= $this->uri->segment(2) == "unit_kerja" ? 'active' : "" ?>">
                                 <i class="fa fa-file-import nav-icon text-info"></i>
                                 <p>Unit Kerja / Bidang</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item">
                     <a href="<?= base_url('pegawai') ?>" class="nav-link <?= $this->uri->segment(1) == "pegawai" ? 'active' : "" ?>">
                         <i class="nav-icon fa fa-user text-maroon"></i>
                         <p> MASTER PEGAWAI</p>
                     </a>
                 </li>
                 <li class="nav-header">LABELS</li>
                 <li class="nav-item has-treeview">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fa fa-book text-info"></i>
                         <p> REKAPITULASI SURAT</p><i class="right fas fa-angle-left"></i>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="<?= base_url('master/jabatan') ?>" class="nav-link">
                                 <i class="fa fa-file-import nav-icon text-danger"></i>
                                 <p>SURAT MASUK</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="<?= base_url('master/skpd') ?>" class="nav-link">
                                 <i class="fa fa-file-import nav-icon text-danger"></i>
                                 <p>SURAT KELUAR</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-header">MENU</li>
                 <li class="nav-item">
                     <a href="<?= base_url('menu') ?>" class="nav-link <?= $this->uri->segment(1) == "menu" ? 'active' : "" ?>">
                         <i class="nav-icon fa fa-user text-maroon"></i>
                         <p> MENU</p>
                     </a>
                 </li>

                 <li class="nav-header">MENU</li>
                 <li class="nav-item">
                     <a href="<?= base_url('myconfig/logout') ?>" class="nav-link">
                         <i class="nav-icon fa fa-sign-out-alt text-maroon"></i>
                         <p> LOGOUT</p>
                     </a>
                 </li>
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>