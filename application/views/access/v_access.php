<?php $this->load->view('layout/header') ?>
<?php $this->load->view('layout/sidebar') ?>
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

                                <button class="btn btn-sm bg-secondary" onclick="reload_table()"><span class="fas fa-sync-alt"></span> Reload Table</button>&nbsp;
                                <button class="btn btn-sm bg-secondary" onclick="add_access()"><span class="fa fa-plus"></span> Tambah Data</button>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Role</th>
                                        <th>Menu</th>
                                        <th>Sub Menu</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div><!-- Row -->



<?php $this->load->view('layout/footer') ?>

<!-- Javascripts -->

<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var base_url = '<?php echo base_url(); ?>';

    $(document).ready(function() {

        //datatables
        table = $('#table').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [],

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('access/ajax_list') ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                    "targets": [-1], //last column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [-2], //2 last column (photo)
                    "orderable": false, //set not orderable
                },
            ],

        });

        //set input/textarea/select event when change value, remove class error and remove text help block 
        $("input").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("textarea").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("select").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().next().empty();
        });

        $('select.select-submenu').empty();
        $('.submenu').hide();
        $('select[name="menu"]').on('change', function() {
            var id = $(this).val();
            
            if (id == '') {
                exit();
            }

            $.ajax({
            url: site_url + 'submenu/by_menu',
            type: 'POST',
            dataType: 'JSON',
            data: {menu: id},
            success: function(result){
                if (result.length > 0) {
                // $('select[name="submenu[]"]').empty().trigger('change');
                $('select.select-submenu').select2({
                    data: result,
                    placeholder: "Pilih Sub Menu",
                });

                $('select.select-submenu').attr('required', true);
                $('.submenu').show();
                }else{
                $('.submenu').hide();
                }
            }
            })    
        });
    });
    

    function add_access() {
        save_method = 'add';
        $('.submenu').hide();
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('#photo-preview').hide(); // hide photo preview modal
        $('.modal-title').text('Tambah Access'); // Set title to Bootstrap modal title
        $('.select-submenu').attr('name', 'submenu[]');
        $('.select-submenu').attr('multiple', 'multiple');

    }

    function edit_access(id) {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('.select-submenu').attr('name', 'submenu');
        $('.select-submenu').removeAttr("multiple");

        $('#form').append('<input type="hidden" value="" name="id" />');

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('access/ajax_edit') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                $('[name="id"]').val(data.id);
                $('select[name="role"]').val(data.role_id);
                $('select[name="menu"]').val(data.menu_id).trigger('change');
                if (data.submenu_id !== '' || data.submenu_id !== null || data.submenu_id !== undefined) {
                    $('select[name="submenu"]').val(data.submenu_id);
                }
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Access'); // Set title to Bootstrap modal title
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    function save() {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url;

        if (save_method == 'add') {
            url = "<?php echo site_url('access/ajax_add') ?>";
        } else {
            url = "<?php echo site_url('access/ajax_update') ?>";
        }

        // ajax adding data to database

        var formData = new FormData($('#form')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {
                swal({
                    title: "Data Berhasil Disimpan",
                    showConfirmButton: true,
                    confirmButtonClass: "btn btn-success",
                    type: "success",
                    timer: 1500
                });
                if (data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                    reload_table();
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 


            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 

            }
        });
    }

    function delete_access(id) {
        swal({
            title: "Anda Yakin?",
            text: "Data Akan Dihapus Secara Permanen!",
            type: 'warning',

            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Ya Hapus Data!",
            cancelButtonText: "Tidak, Batal Hapus!",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) {

            if (!isConfirm) return;
            $.ajax({
                url: "<?php echo base_url('access/ajax_delete') ?>/" + id,
                type: "post",
                dataType: "JSON",
                success: function(data) {
                    swal({
                        title: "Data Berhasil Di Hapus",
                        showConfirmButton: false,
                        type: "success",
                        timer: 1500
                    })
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    reload_table();
                },
                error: function() {
                    swal({
                        title: 'Gagal!',
                        text: 'Data Gagal Di Hapus.',
                        type: 'error',
                        confirmButtonClass: "btn btn-danger",
                        buttonsStyling: false
                    })
                }
            });
        })
    }
</script>
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Role</label>
                            <select class="form-control show-tick" data-style="btn bg-grey" name="role" style="width: 100%;" required>
                                <option selected disabled>--Pilih Role--</option>
                                <?php foreach ($role as $mydata) : ?>
                                    <option value="<?php echo $mydata->id ?>"> <?php echo $mydata->role; ?></option>
                                <?php endforeach ?>
                            </select>
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Menu</label>
                            <select class="form-control show-tick" data-style="btn bg-grey" name="menu" style="width: 100%;" required>
                                <option selected disabled>--Pilih Menu--</option>
                                <?php foreach ($menu as $mydata) : ?>
                                    <option value="<?php echo $mydata->id ?>"> <?php echo $mydata->menu; ?></option>
                                <?php endforeach ?>
                            </select>
                            <span class="help-block"></span>
                        </div>   
                        
                        <div class="form-group submenu">
                            <label class="control-label col-md-3">Sub Menu</label>
                            <select class="form-control show-tick select-submenu" data-style="btn bg-grey" style="width: 100%;">
                                <option selected disabled>--Pilih Sub Menu--</option>
                            </select>
                            <span class="help-block"></span>
                        </div>                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

</body>

</html>