<?php $this->load->view('admin/header');
//print_r($user_det);
?>

<!-- Theme JS files -->
<script type="text/javascript" src="<?php echo BASE; ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?php echo BASE; ?>assets/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="<?php echo BASE; ?>assets/js/plugins/ui/moment/moment.min.js"></script>
<script type="text/javascript" src="<?php echo BASE; ?>assets/js/plugins/pickers/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo BASE; ?>assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
<script type="text/javascript" src="<?php echo BASE; ?>assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo BASE; ?>assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo BASE; ?>assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>

<script type="text/javascript" src="<?php echo BASE; ?>assets/js/core/app.js"></script>
<!--<script type="text/javascript" src="--><?php //echo BASE; ?><!--assets/js/pages/components_page_header.js"></script>-->
<script type="text/javascript" src="<?php echo BASE; ?>assets/js/pages/datatables_extension_buttons_html5.js"></script>
<!--<script type="text/javascript" src="--><?php //echo BASE; ?><!--assets/js/pages/datatables_basic.js"></script>-->
<!-- /theme JS files -->

<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-xs">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-user-plus position-left"></i> <span class="text-semibold"> Reports</span> - Winnings</h4>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <button type="button" class="btn btn-info daterange-ranges heading-btn">
                        <i class="icon-calendar5 position-left"></i>
                        <span></span>
                        <b class="caret"></b>
                    </button>
<!--                    <a href="--><?php //echo ADMIN_URL; ?><!--products/add" class="btn btn-success"><i class="icon-user-plus"></i> Add Product</a>-->
                </div>
            </div>
        </div>

        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="<?php echo ADMIN_URL; ?>"><i class="icon-home2 position-left"></i> Home</a></li>
                <li class="active">Reports - Winnings</li>
            </ul>

        </div>
    </div>
    <!-- /page header -->


    <!-- Content area -->
    <div class="content">


        <div class="panel panel-flat">
            <div id="TableContent" class="content">
                <table class="table datatable-button-html5-basic2 table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Base Price</th>
                        <th>Winner</th>
                        <th>Close Price</th>
                        <th>Closed Date</th>
                        <th>Start Datetime</th>
                        <th>End Datetime</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php GLOBAL $USER_ROLES; if(!empty($winnings)){ foreach ($winnings as $product){ ?>
                        <tr>
                            <td><?php echo $product->product_id; ?></td>
                            <td><?php echo $product->title; ?></td>
                            <td><?php echo $product->base_price; ?><small> <?php echo PRICE_PRE; ?></small></td>
                            <td><?php echo $product->first_name.' '.$product->last_name.' (#'.$product->user_id.')'; ?></td>
                            <td><?php echo $product->bid_close_price; ?><small> <?php echo PRICE_PRE; ?></small></td>
                            <td><?php echo date('d M, Y h:i A',strtotime($product->bid_close_date)); ?></td>
                            <td><?php echo date('d M, Y h:i A',strtotime($product->start_datetime)); ?></td>
                            <td><?php echo date('d M, Y h:i A',strtotime($product->end_datetime)); ?></td>
                        </tr>
                    <?php } } ?>
                    </tbody>
                </table>
            </div>
        </div>


        <?php $this->load->view('admin/footer'); ?>
        <script>
            var base_url = '<?php echo BASE; ?>';
            $(document).ready(function(){

                $('.daterange-ranges').daterangepicker(
                    {
                        startDate: moment().subtract('days', 1),
                        endDate: moment(),
//                        dateLimit: { days: 60 },
//                        ranges: {
//                            'Today': [moment(), moment()],
//                            'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
//                            'Last 7 Days': [moment().subtract('days', 6), moment()],
//                            'Last 30 Days': [moment().subtract('days', 29), moment()],
//                            'This Month': [moment().startOf('month'), moment().endOf('month')],
//                            'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
//                        },
                        opens: 'right',
                        applyClass: 'btn-small btn-primary btn-block',
                        cancelClass: 'btn-small btn-default btn-block',
                        format: 'MM/DD/YYYY'
                    },
                    function(start, end) {

                        // Format date
                        $('.daterange-ranges span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
//                        alert('ajax call');
                        $.ajax({
                            'url' : base_url+'admin/reports/winnings_ajax',
                            'type': 'POST',
                            'data': {start:start.format('MMM D, YYYY'),end:end.format('MMM D, YYYY')},
                            beforeSend: function(){
                                swal({title:"Loading ...",imageUrl: "<?php echo BASE; ?>assets/images/loader.gif",showConfirmButton: false});
                            },
                            success: function (data) {
//                                console.log(data);
                                swal.close();
                                $('#TableContent').html(data);
                            }
                        });
                    }
                );

                // Format date
                $('.daterange-ranges span').html(moment().subtract('days', 1).format('MMM D, YYYY') + ' - ' + moment().format('MMM D, YYYY'));




            });
        </script>