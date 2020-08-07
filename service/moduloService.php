<?php
//CONEXION
include 'mainService.php';

class ModuloService extends MainService {

    function findAll(){
        return $this->conex->query("SELECT COD_MODULO, NOMBRE, ESTADO FROM SEG_MODULO WHERE ESTADO LIKE '%ACT%'");
    }

    function findByPK($codModulo) {
        $result = $this->conex->query("SELECT * FROM seg_modulo WHERE COD_MODULO=".$codModulo);
        if ($result->num_rows > 0) {
            $row1 = $result->fetch_assoc();
            return $row1;
        }else{
            return null;
        }
    }

    function update($nombre, $estado, $codModulo) {
        $stmt = $this->conex->prepare("UPDATE seg_modulo set NOMBRE=?, ESTADO=? WHERE COD_MODULO= ?");
        $stmt->bind_param("sss", $nombre, $estado, $codModulo);
        $stmt->execute();
        $stmt->close();
    }

    function insert($codModulo, $nombre, $estado){
        $stmt = $this->conex->prepare("INSERT INTO SEG_MODULO (cod_modulo, nombre, estado) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $codModulo, $nombre, $estado);
        $stmt->execute();
        $stmt->close();
    }

    function delete($codModulo){
        $stmt = $this->conex->prepare("UPDATE SEG_MODULO SET ESTADO = 'INA' WHERE cod_modulo = ?");
        $stmt->bind_param("s", $codModulo);
        $stmt->execute();
        $stmt->close();
    }

    function findAllFun($codModulo){
        return $this->conex->query("SELECT f.NOMBRE, f.URL_PRINCIPAL, f.DESCRIPCION, f.COD_FUNCIONALIDAD 
        FROM SEG_FUNCIONALIDAD f, SEG_MODULO m 
        WHERE m.ESTADO = 'ACT' AND f.COD_MODULO=m.COD_MODULO AND f.COD_MODULO=".$codModulo);
    }

    function findByPKFun2($codFuncionalidad) {
        return $this->conex->query("SELECT NOMBRE, URL_PRINCIPAL, DESCRIPCION FROM SEG_FUNCIONALIDAD WHERE COD_FUNCIONALIDAD=".$codFuncionalidad);
    }  

    function findByPKFun($codFuncionalidad) {
        $result = $this->conex->query("SELECT * FROM SEG_FUNCIONALIDAD WHERE COD_FUNCIONALIDAD=".$codFuncionalidad);
        if ($result->num_rows > 0) {
            $row1 = $result->fetch_assoc();
            return $row1;
        }else{
            return null;
        }
    }

    function insertFun($codModulo, $url, $nombre, $descripcion){
        $stmt = $this->conex->prepare("INSERT INTO SEG_FUNCIONALIDAD (cod_modulo, url_principal, nombre, descripcion) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $codModulo, $url, $nombre, $descripcion);
        $stmt->execute();
        $stmt->close();
    }

    function updateFun($nombre, $url, $descripcion, $codFuncionalidad) {
        $stmt = $this->conex->prepare("UPDATE SEG_FUNCIONALIDAD  set NOMBRE=?, URL_PRINCIPAL=?, DESCRIPCION=? WHERE COD_FUNCIONALIDAD= ?");
        $stmt->bind_param("sssi", $nombre, $url, $descripcion, $codFuncionalidad);
        $stmt->execute();
        $stmt->close();
    }

    function deleteFun($codFuncionalidad){
        //$conex = getConection();
        $stmt = $this->conex->prepare("DELETE FROM SEG_FUNCIONALIDAD WHERE COD_FUNCIONALIDAD = ?");
        $stmt->bind_param("i", $codFuncionalidad);
        $stmt->execute();
        $stmt->close();
    }
    function findAllRol(){
        return $this->conex->query("SELECT COD_ROL, NOMBRE FROM SEG_ROL");
    }

    function findAllModRol($codRol){
        return $this->conex->query("SELECT r.COD_ROL, s.NOMBRE, s.COD_MODULO FROM SEG_ROL r, ROL_MODULO m, SEG_MODULO s
        WHERE r.COD_ROL = m.COD_ROL AND s.ESTADO = 'ACT' AND m.COD_MODULO = s.COD_MODULO AND r.COD_ROL ='$codRol'");
    }

    function insertModRol($codRol, $codModulo){
        $stmt = $this->conex->prepare("INSERT INTO ROL_MODULO (cod_rol, cod_modulo) VALUES (?, ?)");
        $stmt->bind_param("ss", $codRol, $codModulo);
        $stmt->execute();
        $stmt->close();
    }

    function deleteModRol($codModulo, $cod_rol){
        //$conex = getConection();
        $stmt = $this->conex->prepare("DELETE FROM ROL_MODULO WHERE COD_MODULO = ? AND COD_ROL = ?");
        $stmt->bind_param("ss", $codModulo, $cod_rol);
        $stmt->execute();
        $stmt->close();
    }

}
?>