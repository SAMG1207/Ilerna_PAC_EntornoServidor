<?php
include_once 'consultas.php';

function pintaCategoria():void{
$categorias = getCategorias();
 $lista="";
foreach($categorias as $categoria){
    $lista .= "<option value='".$categoria["id"]."'>".$categoria["name"]."</option>";
}
    echo ($lista);
}

function pintaTablaUsuarios(){
    
    $usuarios = getListaUsuarios();
    $tabla = "<table>";
    $tabla .="<tr>";
    $tabla .="<th>Nombre</th>";
    $tabla .="<th>Email</th>";
    $tabla .="<th>Autorizado</th>";
    $tabla .="</tr>";
    foreach($usuarios as $usuario){
    $tabla.="<tr>";
    if($usuario["enabled"]==1){
        $tabla.="<td><b>".$usuario["full_name"]."</b></td>";
        $tabla.="<td><b>".$usuario["email"]."</b></td>";
        $tabla.="<td><b>".$usuario["enabled"]."</b></td>";
    }else{
        $tabla.="<td>".$usuario["full_name"]."</td>";
        $tabla.="<td>".$usuario["email"]."</td>";
        $tabla.="<td>".$usuario["enabled"]."</td>";
    }
    $tabla.="</tr>";
    }
    $tabla.="</table>";
    echo $tabla;
}

function pintaProductos($orden){
    $datos = getProductos($orden);
    if(!is_string($datos)){
        $tabla = "<table>";
        $tabla .="<tr>";
        $tabla .="<th><a href='articulos.php?orden=id'>ID</a></th>";
        $tabla .="<th><a href='articulos.php?orden=name'>Name</a></th>";
        $tabla .="<th><a href = 'articulos.php?orden=cost'> Coste </a></th>";
        $tabla .="<th><a href = 'articulos.php?orden=category_id'> Categoria </a></th>";
        $tabla .="<th>Acciones</th>";
        $tabla .="</tr>";
        foreach($datos as $dato){
            $tabla.="<tr>";
            $tabla.="<td>".$dato["id"]." </td>";
            $tabla.="<td>".$dato["name"]." </td>";
            $tabla.="<td>".$dato["cost"]." </td>";
            $tabla.="<td>".$dato["category"]." </td>";
            $tabla.="<td><a href ='formArticulos.php?Editar=".$dato['id']."'>Editar</a>
            <a href ='formArticulos.php?Borrar=".$dato['id']."'>Borrar</a></td>";
            $tabla.="</tr>";
        }
        echo($tabla);
    }else{
        echo("no se ha podido imprimir la tabla");
    }
}