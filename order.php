<?php
    include_once'db/connect_db.php';
    session_start();
    if($_SESSION['username']==""){
        header('location:index.php');
    }else{
        if($_SESSION['role']=="Admin"){
          include_once'inc/header_all.php';
        }else{
            include_once'inc/header_all_operator.php';
        }
    }

    error_reporting(0);

    $id = $_GET['id'];

    $delete_query = "UPDATE tbl_invoice SET deleteI=1 WHERE invoice_id=$id";
    $delete = $pdo->prepare($delete_query);
    if($delete->execute()){
        echo'<script type="text/javascript">
            jQuery(function validation(){
            swal("Info", "Transacción eliminada", "info", {
            button: "Continuar",
                });
            });
            </script>';
    }
?>

<html>
<head>
<meta http-equiv="refresh" content="60">
</head>
</html>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Transacción
      </h1>
      <hr>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Lista de transacciones</h3>
                <a style="margin-left: 4%;" href="misc/pdftransacciones.php" target="_blank" class="btn btn-primary btn-sm">Imprimir Tabla</a>
                <a href="create_order.php" class="btn btn-success btn-sm pull-right">Agregar transacción</a>
            </div>
            <div class="box-body">

                <div style="overflow-x:auto;">
                    <table class="table table-striped" id="myOrder">
                        <thead>
                            <tr>
                                <th style="width:20px;">Nº</th>
                                <th style="width:100px;">Usuario</th>
                                <th style="width:100px;">Fecha</th>
                                <th style="width:100px;">Dinero</th>
                                <th style="width:50px;">Opción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $select = $pdo->prepare("SELECT * FROM tbl_invoice ORDER BY invoice_id DESC");
                            $select->execute();
                            while($row=$select->fetch(PDO::FETCH_OBJ)){
                              if ($row->deleteI==0) {
                                
                            ?>
                                <tr>
                                <td><?php echo $no++ ; ?></td>
                                <td class="text-uppercase"><?php echo $row->cashier_name; ?></td>
                                <td><?php echo $row->order_date; ?></td>
                                <td>COP. <?php echo number_format($row->total); ?></td>
                                <td>
                                    <?php if($_SESSION['role']=="Admin"){ ?>
                                    <a href="order.php?id=<?php echo $row->invoice_id; ?>" onclick="return confirm('¿Realmente desea eliminar la transacción?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    <?php } ?>
                                    <a href="misc/nota.php?id=<?php echo $row->invoice_id; ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
                                </td>
                                </tr>
                            <?php
                            }}
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
  $(document).ready( function () {
      $('#myOrder').DataTable({"language": {
           "sProcessing":    "Procesando...",
           "sLengthMenu":    "Mostrar _MENU_ registros",
           "sZeroRecords":   "No se encontraron resultados",
           "sEmptyTable":    "Ningún dato disponible en esta tabla",
           "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
           "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
           "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
           "sInfoPostFix":   "",
           "sSearch":        "Buscar:",
           "sUrl":           "",
           "sInfoThousands":  ",",
           "sLoadingRecords": "Cargando...",
           "oPaginate": {
               "sFirst":    "Primero",
               "sLast":    "Último",
               "sNext":    "Siguiente",
               "sPrevious": "Anterior"
           },
           "oAria": {
               "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
               "sSortDescending": ": Activar para ordenar la columna de manera descendente"
           }
       }});
  } );
  </script>

 <?php
    include_once'inc/footer_all.php';
 ?>