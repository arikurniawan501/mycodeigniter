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
                                <button class="btn btn-sm bg-secondary" onclick="add()"><span class="fa fa-plus"></span> Tambah Data</button>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Parent Menu</th>
                                        <th>Url</th>
                                        <th>Icon</th>
                                        <th>No Urut</th>
                                        <!-- <th>Active</th> -->
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div><!-- Row -->



<?php $this->load->view('layout/footer') ?>
<script>
    var table;
    var save_method;
    $(document).ready(function () {
        table = $('#table').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [],

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('submenu/ajax_list') ?>",
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
    });

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }
    
    function add() {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#submenu').modal('show'); // show bootstrap modal
        $('#photo-preview').hide(); // hide photo preview modal
        $('.modal-title').text('Tambah Sub Menu'); // Set title to Bootstrap modal title

    }

    function edit(id) {  
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        $('#form').append('<input type="hidden" value="" name="id" />');

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('submenu/ajax_edit') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                $('[name="id"]').val(data.id);
                $('[name="menu"]').val(data.title);
                $('[name="url"]').val(data.url);
                $('[name="icon"]').val(data.icon);
                $('[name="urutan"]').val(data.no_urut);
                
                $('select[name="parent"]').val(data.menu_id).change();
                $('#submenu').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Sub Menu'); // Set title to Bootstrap modal title
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function remove(id) {
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
                url: "<?php echo base_url('submenu/ajax_delete') ?>/" + id,
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

    function save() {  
        const ini = $('.save');

        $(ini).text('saving...'); //change button text
        $(ini).attr('disabled', true); //set button disable 

        if (save_method == 'add') {
            url = "<?php echo site_url('submenu/ajax_add') ?>";
        } else {
            url = "<?php echo site_url('submenu/ajax_update') ?>";
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
                    $('#submenu').modal('hide');
                    reload_table();
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $(ini).text('save'); //change button text
                $(ini).attr('disabled', false); //set button enable 


            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $(ini).text('save'); //change button text
                $(ini).attr('disabled', false); //set button enable 

            }
        });
    }
</script>
<script>
</script>
<!-- Bootstrap modal -->
<div class="modal fade" id="submenu" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <form id="form" class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-md-3">Sub Menu</label>
                        <input type="text" class="form-control" id="title" name="menu" placeholder="Submenu title">
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Parent Menu</label>
                        <select name="parent" id="menu_id" class="form-control">
                            <option value="">Pilih Menu</option>
                            <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m->id; ?>"><?= $m->menu; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Url</label>
                        <input type="text" class="form-control" id="url" name="url" placeholder="Url">
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Icon</label>
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Icon">
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                            <label class="control-label col-md-3">No Urut</label>
                            <input name="urutan" placeholder="No Urut" class="form-control" type="number" min="1" required>
                            <span class="help-block"></span>
                    </div>
                    <!-- <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active" checked>
                            <label class="form-check-label" for="is_active">
                                Active?
                            </label>
                        </div>
                    </div> -->


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary save" onclick="save()">Add</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

</body>

</html>