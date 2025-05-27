<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $title;?></title>


    <link rel="icon" href="../../resources/images/gg-removebg-preview.png">


    <!-- Custom fonts for this template-->
    <link href="..\..\startbootstrap-sb-admin-2-gh-pages\vendor\fontawesome-free\css\all.min.css" rel="stylesheet" type="text/css">
    
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="..\..\startbootstrap-sb-admin-2-gh-pages\css\sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for the tables page -->
    <link href="..\..\startbootstrap-sb-admin-2-gh-pages\vendor\datatables\dataTables.bootstrap4.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />


        <style>
            /* Completely remove DataTables sorting arrows */
            table.dataTable thead th.sorting,
            table.dataTable thead th.sorting_asc,
            table.dataTable thead th.sorting_desc,
            table.dataTable thead td.sorting,
            table.dataTable thead td.sorting_asc,
            table.dataTable thead td.sorting_desc {
                background-image: none !important;
                background: none !important;
                position: relative;
                padding-right: 10px !important;
            }
        </style>





</head>
<body id="page-top">


    <?php  echo $content;?>






    <!-- Bootstrap core JavaScript-->
    <script src="..\..\startbootstrap-sb-admin-2-gh-pages\vendor\jquery\jquery.min.js"></script>
    <script src="..\..\startbootstrap-sb-admin-2-gh-pages\vendor\bootstrap\js\bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="..\..\startbootstrap-sb-admin-2-gh-pages\vendor\jquery-easing\jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="..\..\startbootstrap-sb-admin-2-gh-pages\js\sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="..\..\startbootstrap-sb-admin-2-gh-pages\vendor\datatables\jquery.dataTables.min.js"></script>
    <script src="..\..\startbootstrap-sb-admin-2-gh-pages\vendor\datatables\dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <!-- <script src="..\..\startbootstrap-sb-admin-2-gh-pages\js\demo\datatables-demo.js"></script> -->

        <!-- Page level plugins -->
    <script src="..\..\startbootstrap-sb-admin-2-gh-pages\vendor\chart.js\Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="..\..\startbootstrap-sb-admin-2-gh-pages\js\demo\chart-area-demo.js"></script>
    <script src="..\..\startbootstrap-sb-admin-2-gh-pages\js\demo\chart-pie-demo.js"></script>


<script>
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().destroy(); 
        }

        $('#dataTable').DataTable({
            ordering: false
        });
    });
</script>



</body>

</html>
