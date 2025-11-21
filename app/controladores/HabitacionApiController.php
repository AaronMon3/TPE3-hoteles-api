<?php
require_once 'app/modelos/HabitacionApiModel.php';

class HabitacionApiController
{
  private $modelo;
  private $nombreRecurso;
  private $nombreId;

  public function __construct()
  {
    $this->modelo = new HabitacionApiModel();
    $this->nombreRecurso = 'habitación';
    $this->nombreId = 'id_habitacion';
  }

  protected function getDefaultSortField()
  {
    return 'id_habitacion';
  }

  public function getHabitaciones($req, $res)
  {
    $orderBy = $req->query->sort ?? $this->getDefaultSortField();
    $direction = $req->query->order ?? 'ASC';

    $habitaciones = $this->modelo->getAll($orderBy, $direction);
    return $res->json($habitaciones, 200);
  }

  public function getHabitacion($req, $res)
  {
    $id = $req->params->id;

    if (empty($id)) {
      $habitaciones = $this->modelo->getAll();
      return $res->json($habitaciones);
    } else {
      $habitacion = $this->modelo->get($id);

      if (!empty($habitacion)) {
        return $res->json($habitacion);
      } else {
        return $res->json("La {$this->nombreRecurso} con el {$this->nombreId}=$id no existe", 404);
      }
    }
  }

  public function deleteHabitacion($req, $res)
  {
    $habitacion_id = $req->params->id;
    $habitacion = $this->modelo->get($habitacion_id);

    if (!$habitacion) {
      return $res->json("La {$this->nombreRecurso} con el {$this->nombreId}=$habitacion_id no existe", 404);
    }

    $this->modelo->delete($habitacion_id);
    $res->json("La {$this->nombreRecurso} con el {$this->nombreId}=$habitacion_id se eliminó con éxito", 204);
  }

  
  public function insert($req, $res)
  {
    $numero = $req->body->numero;
    $precio = $req->body->precio;
    $id_hotel = $req->body->id_hotel;
    $id_tipo = $req->body->id_tipo;
    $imagen_url = $req->body->imagen_url ?? null;

    if (empty($numero) || empty($precio) || empty($id_hotel) || empty($id_tipo)) {
      return $res->json('Faltan datos requeridos: numero, precio, id_hotel, id_tipo', 400);
    }

    $habitacion_id = $this->modelo->insert($numero, $precio, $id_hotel, $id_tipo, $imagen_url);
    $res->json($habitacion_id, 201);
  }

  public function update($req, $res)
  {
    $habitacion_id = $req->params->id;
    $habitacion = $this->modelo->get($habitacion_id);

    if (!$habitacion) {
      return $res->json("La habitación con el id=$habitacion_id no existe", 404);
    }

    if (
      empty($req->body->numero) ||
      empty($req->body->precio) ||
      empty($req->body->id_hotel) ||
      empty($req->body->id_tipo)
    ) {
      return $res->json('Faltan datos requeridos: numero, precio, id_hotel, id_tipo', 400);
    }

    $numero = $req->body->numero;
    $precio = $req->body->precio;
    $id_hotel = $req->body->id_hotel;
    $id_tipo = $req->body->id_tipo;
    $imagen_url = $req->body->imagen_url ?? null;

    $this->modelo->update($habitacion_id, $numero, $precio, $id_hotel, $id_tipo, $imagen_url);

    $updatedHabitacion = $this->modelo->get($habitacion_id);
    return $res->json($updatedHabitacion, 200);
  }
}
