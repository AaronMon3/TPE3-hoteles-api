<?php
require_once 'app/modelos/TipoHabitacionApiModel.php';

class TipoHabitacionApiController
{
  private $modelo;
  private $nombreRecurso;
  private $nombreId;

  public function __construct()
  {
    $this->modelo = new TipoHabitacionApiModel();
    $this->nombreRecurso = 'tipo de habitación';
    $this->nombreId = 'id_tipo';
  }

  protected function getDefaultSortField()
  {
    return 'id_tipo';
  }

  public function getTipos($req, $res)
  {
    $orderBy = $req->query->sort ?? $this->getDefaultSortField();
    $direction = $req->query->order ?? 'ASC';

    $tipos = $this->modelo->getAll($orderBy, $direction);
    return $res->json($tipos, 200);
  }

  public function getTipo($req, $res)
  {
    $id = $req->params->id;

    if (empty($id)) {
      $tipos = $this->modelo->getAll();
      return $res->json($tipos);
    } else {
      $tipo = $this->modelo->get($id);

      if (!empty($tipo)) {
        return $res->json($tipo);
      } else {
        return $res->json("El {$this->nombreRecurso} con el {$this->nombreId}=$id no existe", 404);
      }
    }
  }

  public function deleteTipo($req, $res)
  {
    $tipo_id = $req->params->id;
    $tipo = $this->modelo->get($tipo_id);

    if (!$tipo) {
      return $res->json("El {$this->nombreRecurso} con el {$this->nombreId}=$tipo_id no existe", 404);
    }

    $this->modelo->delete($tipo_id);
    $res->json("El {$this->nombreRecurso} con el {$this->nombreId}=$tipo_id se eliminó con éxito", 204);
  }

  public function insert($req, $res)
  {
    $nombre = $req->body->nombre;
    $descripcion = $req->body->descripcion;
    $imagen_url = $req->body->imagen_url ?? null;

    if (empty($nombre)) {
      return $res->json('Faltan datos requeridos: nombre', 400);
    }

    $tipo_id = $this->modelo->insert($nombre, $descripcion, $imagen_url);
    $res->json($tipo_id, 201);
  }

 
  public function update($req, $res)
  {
    $tipo_id = $req->params->id;
    $tipo = $this->modelo->get($tipo_id);

    if (!$tipo) {
      return $res->json("El tipo con el id=$tipo_id no existe", 404);
    }

    if (empty($req->body->nombre)) {
      return $res->json('Faltan datos requeridos: nombre', 400);
    }

    $nombre = $req->body->nombre;
    $descripcion = $req->body->descripcion;
    $imagen_url = $req->body->imagen_url ?? null;

    $this->modelo->update($tipo_id, $nombre, $descripcion, $imagen_url);

    $updatedTipo = $this->modelo->get($tipo_id);
    return $res->json($updatedTipo, 200);
  }
}
