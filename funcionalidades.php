<?php
include './service/moduloService.php';
session_start();

//INICIALIZACIÓN
$nombre = "";
$url = "";
$modulo="";
$codModulo = "";
$codFuncionalidad ="";
$descripcion = "";
$accion = "Agregar";
$eliminarMod = "Eliminar";
$moduloService = new ModuloService();

//CRUD
//AGREGAR
if (isset($_POST["accion"]) && ($_POST["accion"] == "Agregar")) {
    $moduloService->insertFun($_POST['modulo'], $_POST["url"], $_POST["nombre"], $_POST["descripcion"]);
} 

//MODIFICAR
else if (isset($_POST["accion"]) && ($_POST["accion"] == "Modificar")) {
    $moduloService->updateFun($_POST["nombre"],$_POST["url"], $_POST["descripcion"], $_POST["codFuncionalidad"]);
} 
//SELECCIONAR ID A MODIFICAR
else if (isset($_GET["update"])) {
    $modulo = $moduloService->findByPKFun($_GET["update"]);
    if ($modulo!=null){
        $codFuncionalidad =$modulo["COD_FUNCIONALIDAD"];
        $nombre = $modulo["NOMBRE"];
        $url = $modulo["URL_PRINCIPAL"];
        $descripcion = $modulo["DESCRIPCION"];
        $accion = "Modificar";
    }
} 
//ELIMINAR
else if (isset($_POST["eliminarMod"])) {
    $moduloService->deleteFun($_POST["eliminarMod"]);
}
$result = $moduloService->findAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Examen Segundo Parcial</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/ayc.css" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-text mx-3"> Módulos</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="funcionalidades.php">
                <div class="sidebar-brand-text mx-3"> Funcionalidades</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="moduloXrol.php">
                <div class="sidebar-brand-text mx-3"> Módulo X rol</div>
            </a>
            <hr class="sidebar-divider my-0">
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div class="card-body">
              
                <div class="card-header py-3">
                 
                </div>
                <div class="table-responsive">
                    <form name="forma" id="forma" method="post" action="funcionalidades.php">
                        <table>
                            <tr>
                                <td><label id="lblCategoria" for="categoria">Módulo: </label></td>
                            </tr>
                            <tr>
                                <td>
                                <select  class="custom-select" id="modulo" name="modulo">
                                    <?php
                                    if($result->num_rows>0){
                                        while($row = $result->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo $row["COD_MODULO"]?>">
                                            <?php echo $row["NOMBRE"]?></option>
                                        <?php if(isset($_POST["aceptar"])){?>
                                            <option hidden selected>
                                                <?php echo $_POST['modulo']?></option>
                                            <?php }} }?>
                                </select>
                                </td>
                            </tr>
                            <tr>
                                <td><input class="btn btn-primary btn-user btn-block" name="aceptar" type="submit" value="Aceptar" ></td>
                            </tr>
                        </table><br>
                        <!-- BOTÓN ELIMINAR -->
                        <table border=0>
                            <tr>
                                <td colspan="3" style="width: 1080px;">&nbsp;</td>
                                <td>
                                <button type="button" class="btn btn-warning" 
                                name="eliminar" onclick="eliminacionModulo()" >
                                <span class="icon text-white-50">
                                
                                </span><span class="text"><?php echo $eliminarMod?></span></button>
                                </td>
                            </tr>
                        </table>
                        <!-- TABLA CLIENTE -->
                        <table border="1" id="t01" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <!-- TÍTULOS -->
                            <tr>
                                <th class="text-center">CÓDIGO</th>
                                <th class="text-center">NOMBRE</th>
                                <th class="text-center">URL</th>
                                <th class="text-center">DESCRIPCION</th>
                                <th class="text-center">ELIM</th>
                            </tr>
                            <?php
                            if(isset($_POST["aceptar"])){
                                $res = $moduloService->findAllFun($_POST['modulo']);                           
                                if($res->num_rows>0){
                                    while($row1 = $res->fetch_assoc()) {
                            ?>                            
                            <!-- IMPRESIÓN DE LA TABLA CON LOS DATOS DESDE LA BASE -->
                                    <tr>
                                        <td class="text-center"><a href="modFun.php?update=<?php echo $row1["COD_FUNCIONALIDAD"]; ?>" class="btn btn-info btn-icon-split">
                                        
                                          <span class="text">Modificar</span>
                                        </a>
                                        </td>
                                        <td class="text-center"><?php echo $row1["NOMBRE"]; ?></td>
                                        <td class="text-center"><?php echo $row1["URL_PRINCIPAL"]; ?></td>
                                        <td class="text-center"><?php echo $row1["DESCRIPCION"]; ?></td>
                                        <td class="text-center"><input type="radio" name="eliminarMod" value="<?php echo $row1["COD_FUNCIONALIDAD"]; ?>">
                                        </td>
                                    </tr>
                                <?php
                                } ?>
                                <input type="hidden" name="codFuncionalidad" value="<?php echo $codFuncionalidad ?>">
                                    <!-- CAMPOS PARA NUEVO MODULO -->
                                    <table border="0">
                                        <tr>
                                            <td colspan=2 class="text-primary"><h5>Nueva Funcionalidad</h5></td>
                                        </tr>
                                        <tr>
                                            <td><label id="lblModulo" for="nombre">Nombre: </label></td>
                                            <td><input type="text" name="nombre" id="nombre" value="<?php echo $nombre ?>" size="25" ></td>
                                        </tr>
                                        <tr>
                                            <td><label id="lblNombre" for="url">URL: </label></td>
                                            <td><input type="text" name="url" id="url" value="<?php echo $url ?>" maxlength="100" size="25" ></td>
                                        </tr>
                                        <tr>
                                            <td><label id="lblEstado" for="descripcion">DESCRIPCION: </label></td>
                                            <td><input type="text" name="descripcion" id="descripcion" value="<?php echo $descripcion ?>" size="25" ></td>
                                        </tr>
                                        <tr>
                                            <td colspan=2><input type="submit" name="accion" value="<?php echo $accion ?>"></td>
                                        </tr>
                                    </table> 
                            <?php }else { ?>
                                <tr>
                                    <td class="text-center" colspan="5">NO HAY FUNCIONALIDAD REGISTRADA</td>
                                </tr>
                                <input type="hidden" name="codFuncionalidad" value="<?php echo $codFuncionalidad ?>">
                                    <!-- CAMPOS PARA NUEVO MODULO -->
                                    <table border="0">
                                        <tr>
                                            <td colspan=2><strong>Nueva Funcionalidad</strong></td>
                                        </tr>
                                        <tr>
                                            <td><label id="lblModulo" for="nombre">Nombre: </label></td>
                                            <td><input type="text" name="nombre" id="nombre" value="<?php echo $nombre ?>" size="25" ></td>
                                        </tr>
                                        <tr>
                                            <td><label id="lblNombre" for="url">URL: </label></td>
                                            <td><input type="text" name="url" id="url" value="<?php echo $url ?>" maxlength="100" size="25" ></td>
                                        </tr>
                                        <tr>
                                            <td><label id="lblEstado" for="descripcion">DESCRIPCION: </label></td>
                                            <td><input type="text" name="descripcion" id="descripcion" value="<?php echo $descripcion ?>" size="25" ></td>
                                        </tr>
                                        <tr>
                                            <td colspan=2><input type="submit" name="accion" value="<?php echo $accion ?>"></td>
                                        </tr>
                                    </table>
                            <?php }  
                            /* EN CASO DE NO EXISTIR DATOS EN LA TABLA */
                        }else { ?>
                                <tr>
                                    <td class="text-center" colspan="5">SELECCIONE UN MÓDULO</td>
                                </tr>
                            <?php } ?>
                        </table>
                        <!-- hidden ES PARA QUE LOS USUARIOS NO PUEDAN VER NI MODIFICAR DATOS CUANDO SE ENVÍA EN UN FORMULARIO, ESPECIALMENTE ID -->
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- CODIGO JAVA SCRIPT PARA HACER UN TYPE BUTTON EN SUBMIT -->
<script>
    function eliminacionModulo() {
        document.getElementById("forma").submit();
    }
    function agregarModulo() {
        document.getSelection("forma").submit();
    }
</script>

</html>