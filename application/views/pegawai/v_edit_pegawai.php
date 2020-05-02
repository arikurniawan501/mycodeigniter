<?php $this->load->view('layout/header'); ?>
<?php $this->load->view('layout/sidebar'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard v3</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v3</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="containter-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= $title   ?></h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body">
                            <!-- ./row -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card card-primary card-tabs">
                                        <div class="card-header p-0 pt-1">
                                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="user-tab" data-toggle="pill" href="#user" role="tab" aria-controls="user" aria-selected="true">Data User</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="listperan-tab" data-toggle="pill" href="#listperan" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">List Peran</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Messages</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Settings</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                                <div class="tab-pane fade show active" id="user" role="tabpanel" aria-labelledby="user">
                                                    <form class="form-horizontal">
                                                        <div class="card-body">
                                                            <div class="form-group row">
                                                                <label for="inputEmail3" class="col-sm-2 col-form-label">Nama </label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" value="<?= $nama ?>" disabled class="form-control" id="inputEmail3" placeholder="Username">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="inputEmail3" class="col-sm-2 col-form-label">Username</label>
                                                                <div class="col-sm-10">
                                                                    <input type="email" value="<?= $username ?>" class="form-control" id="inputEmail3" placeholder="Email">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                                                                <div class="col-sm-10">
                                                                    <input type="password" value="<?= $password ?>" class="form-control" id="inputPassword3" placeholder="Password">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="offset-sm-2 col-sm-10">
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                                                        <label class="form-check-label" for="exampleCheck2">Remember me</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- /.card -->
                                                <div class="tab-pane fade" id="listperan" role="tabpanel" aria-labelledby="listperan-tab">
                                                    <div class="col-md-6">
                                                        <table id="mytable" class="table table-hover table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Nama Role</th>
                                                                    <th style="text-align: center;">Action</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>

                                                </div>
                                                <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                                                    Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
                                                </div>
                                                <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                                                    Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis.
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div><!-- Row -->


<?php $this->load->view('layout/footer'); ?>
<script>
    $('#mytable').dataTable();
</script>