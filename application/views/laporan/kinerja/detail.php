<?php if($hasil->num_rows() > 0){ ?>
    <table class="display nowrap" id="tableKinerja">
        <thead>
            <tr>
                <th rowspan="2" style="vertical-align:midle;"><center>Nama Guru</center></th>
                <th colspan="<?= count($kriteria); ?>"><center>Kriteria</center></th>
                <th rowspan="2" style="vertical-align:midle;"><center>Nilai Akhir</center></th>
                <th rowspan="2" style="vertical-align:midle;"><center>Status</center></th>
            </tr>
            <tr>
                <?php foreach($kriteria AS $row){ ?>
                <th><center><?= $row->nama_kriteria; ?></center></th>
                <?php } ?>
            </tr>
        </thead>
    </table>
    <?php 
    $tambahan = '';
    $tambahan .= "<a href='".site_url('laporan/cetakKinerja/'.$periode)."' style='margin-left:10px' class='btn btn-primary' target='_blank'><i class='fa fa-print'></i> Print</a>";
    ?>
    <script>
        $(document).ready(function() {
            var periode = "<?= $periode; ?>";
            var dataTable = $('#tableKinerja').DataTable({
                serverSide: true,
                stateSave : false,
                bAutoWidth: true,
                oLanguage: {
                    sSearch: "<i class='fa fa-search fa-fw'></i> Pencarian : ",
                    sLengthMenu: "_MENU_ &nbsp;&nbsp;Data Per Halaman <?php echo $tambahan; ?>",
                    sInfo: "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
                    sInfoFiltered: "(difilter dari _MAX_ total data)", 
                    sZeroRecords: "Pencarian tidak ditemukan", 
                    sEmptyTable: "Tidak ada Data di dalam Database", 
                    sLoadingRecords: "Harap Tunggu...", 
                    oPaginate: {
                        sPrevious: "Prev",
                        sNext: "Next"
                    }
                },
                columnDefs: [ 
                    {
                        targets: 'no-sort',
                        orderable: false,
                    }
                ],
                sPaginationType: "simple_numbers", 
                iDisplayLength: 10,
                aLengthMenu: [[10, 20, 50, 100, 150], [10, 20, 50, 100, 150]],
                ajax:{
                    url :"<?php echo site_url('laporan/showKinerja'); ?>/"+periode,
                    type: "post",
                    error: function(){ 
                        $("#tableKinerja").append('<tbody><tr><th colspan="7"><center>Tidak menemukan data di Server</center></th></tr></tbody>');
                    }
                }
            });
        });
    </script>
<?php }else{ ?>
    <h2 class="text-center text-danger">Tidak ada data.</h2>
<?php } ?>