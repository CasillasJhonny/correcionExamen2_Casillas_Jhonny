<?php
include './service/moduloService.php';
session_start();

//INICIALIZACIÓN

$codModulo="";
$codRol = "";
$accion = "Agregar";
$eliminarMod = "Eliminar";
$moduloService = new ModuloService();

//CRUD
//AGREGAR
if (isset($_POST["accion"]) && ($_POST["accion"] == "Agregar")) {
    $moduloService->insertModRol($_POST["rol"],$_POST["modulo"]);
} 

//ELIMINAR
else if (isset($_POST["eliminarMod"])) {
    $moduloService->deleteModRol($_POST["eliminarMod"], $_POST['rol']);
}
$result = $moduloService->findAllRol();
$result2 = $moduloService->findAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Examen</title>
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
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div class="card-body">
            
                <div class="card-header py-3">
                
                </div>
                <div class="table-responsive">
                    <form name="forma" id="forma" method="post" action="moduloXrol.php">
                    <table>
                            <tr>
                                <td><label id="lblCategoria" for="categoria">Rol: </label></td>
                            </tr>
                            <tr>
                                <td>
                                <select  class="custom-select" id="rol" name="rol">
                                    <?php
                                    if($result->num_rows>0){
                                        while($row = $result->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo $row["COD_ROL"]?>">
                                            <?php echo $row["NOMBRE"]?></option>
                                        <?php if(isset($_POST["aceptar"])){?>
                                            <option hidden selected>
                                                <?php echo $_POST['rol']?></option>
                                            <?php }} }?>
                                </select>
                                </td>
                            </tr>
                            <tr>
                                <td><input class="btn btn-primary btn-user btn-block" name="aceptar" type="submit" value="Aceptar" ></td>
                            </tr>
                        </table>
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
                                <th class="text-center">MODULO</th>
                                <th class="text-center">ELIM</th>
                            </tr>
                            <?php
                            if(isset($_POST["aceptar"])){
                                $respuesta = $moduloService->findAllModRol($_POST['rol']);                           
                                if($respuesta->num_rows>0){
                                    while($row1 = $respuesta->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $row1["NOMBRE"]; ?></td>
                                    <td class="text-center"><input type="radio" name="eliminarMod" value="<?php echo $row1["COD_MODULO"]; ?>">
                                    </td>
                                </tr>
                            <?php
                                } ?>
                                <h5 class="text-primary">Nuevo Módulo</h5>
                                <input type="hidden" name="codRol" value="<?php echo $codRol ?>">
                                <table>
                                    <tr>
                                        <td><label id="lblCategoria" for="categoria">Modulo: </label></td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <select  class="custom-select" id="modulo" name="modulo">
                                            <?php
                                            if($result2->num_rows>0){
                                                while($row = $result2->fetch_assoc()) {
                                            ?>
                                                <option value="<?php echo $row["COD_MODULO"]?>">
                                                    <?php echo $row["NOMBRE"]?></option>
                                                <?php if(isset($_POST["agregar"])){?>
                                                    <option hidden selected>
                                                        <?php echo $_POST['modulo']?></option>
                                                    <?php }} }?>
                                        </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input class="btn btn-primary btn-user btn-block" name="accion" type="submit" value="Agregar" ></td>
                                    </tr>
                                </table>
                            <?php }else { ?>
                                <tr>
                                    <td class="text-center" colspan="5">NO HAY MÓDULO REGISTRADO</td>
                                </tr>
                                <h5 class="text-primary">Nuevo Módulo</5>
                                <input type="hidden" name="codRol" value="<?php echo $codRol ?>">
                                <table>
                                    <tr>
                                        <td><label id="lblCategoria" for="categoria">Modulo: </label></td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <select  class="custom-select" id="modulo" name="modulo">
                                            <?php
                                            if($result2->num_rows>0){
                                                while($row = $result2->fetch_assoc()) {
                                            ?>
                                                <option value="<?php echo $row["COD_MODULO"]?>">
                                                    <?php echo $row["NOMBRE"]?></option>
                                                <?php if(isset($_POST["agregar"])){?>
                                                    <option hidden selected>
                                                        <?php echo $_POST['modulo']?></option>
                                                    <?php }} }?>
                                        </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input class="btn btn-primary btn-user btn-block" name="accion" type="submit" value="Agregar" ></td>
                                    </tr>
                                </table>
                            <?php }  
                        }else { ?>
                                <tr>
                                    <td class="text-center" colspan="5">SELECCIONE UN ROL</td>
                                </tr>
                            <?php } ?>
                        </table>
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
    function seleccionarRol() {
        document.getElementById("forma").submit();
    }
</script>

</html>