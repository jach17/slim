<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = new \Slim\App;

///GET todos los materiales
$app->get('/obtener/todos', function(Request $reques, Response $response){
    $sql = "SELECT * FROM material";

    try{
        $db = new db();    
        $db = $db->connectBD();
                $resultado = $db->query($sql);
                if(($resultado->rowCount())>0){
            $materiales = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($materiales);
        }else{
            echo json_encode("No hay materiales registrados");
        }

    }catch(PDOException $e){
        echo $e->getMessage();
    }
    //echo "Aqui to bien";
});

//GET por nombre
$app->get('/obtener/{nombreMat}', function(Request $reques, Response $response){
    $nombreMaterial = $reques->getAttribute('nombreMat');
    $sql = "SELECT * FROM material WHERE nombreMat='$nombreMaterial'";

    try{
        $db = new db();    
        $db = $db->connectBD();
                $resultado = $db->query($sql);
                if(($resultado->rowCount())>0){
            $materiales = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($materiales);
        }else{
            echo json_encode("No hay materiales registrados");
        }

    }catch(PDOException $e){
        echo $e->getMessage();
    }
});


//POST Nuevo material
$app->post('/add', function(Request $request, Response $response){
    $nombreMat = $request->getParam('nombre');
    $colorMat = $request->getParam('color');
    $precioMat = $request->getParam('precio');

    $sql = "INSERT INTO material (nombreMat, colorMat, precioMat) VALUES(:nombre, :color, :precio)";

    try{
        $db = new db();    
        $db = $db->connectBD();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':nombre', $nombreMat);
        $resultado->bindParam(':color', $colorMat);
        $resultado->bindParam(':precio', $precioMat);

        $resultado->execute();
        
        echo json_encode(array("mensaje" => "Nuevo material agregado"));

    }catch(PDOException $e){
        echo $e->getMessage();
    }
});


//PUT material por id 
$app->put('/update/{id}', function(Request $request, Response $response){
    $idMaterial = $request->getAttribute('id');
    $nombreMat = $request->getParam('nombre');
    $colorMat = $request->getParam('color');
    $precioMat = $request->getParam('precio');

    $sql = "UPDATE material SET
        nombreMat=:nombre,
        colorMat=:color,
        precioMat=:precio 

        WHERE idMaterial = $idMaterial";

    try{
        $db = new db();    
        $db = $db->connectBD();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':nombre', $nombreMat);
        $resultado->bindParam(':color', $colorMat);
        $resultado->bindParam(':precio', $precioMat);

        $resultado->execute();
        
        echo json_encode(array("mensaje" => "Datos del material actualizados"));

    }catch(PDOException $e){
        echo $e->getMessage();
    }
});

$app->delete('/delete/{id}', function(Request $request, Response $response){
    $idMaterial = $request->getAttribute('id');

    $sql = "DELETE FROM material WHERE idMaterial = $idMaterial";

    try{
        $db = new db();    
        $db = $db->connectBD();
        $resultado = $db->prepare($sql);
        $resultado->execute();
        
        if($resultado->rowCount()>0){
            echo json_encode(array("mensaje" => "Material eliminado"));
        }else{
            echo json_encode(array("error"=>"NO existe un material con éste id"));
        }


    }catch(PDOException $e){
        echo $e->getMessage();
    }
});