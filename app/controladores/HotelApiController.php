<?php
require_once 'app/modelos/HotelApiModel.php';

class HotelApiController
{
  private $modelo;
  private $nombreRecurso;
  private $nombreId;

  public function __construct()
  {
    $this->modelo = new HotelApiModel();
    $this->nombreRecurso = 'hotel';
    $this->nombreId = 'id_hotel';
  }

  protected function getDefaultSortField()
  {
    return 'id_hotel';
  }

  public function getHoteles($req, $res)
  {
    $orderBy = $req->query->sort ?? $this->getDefaultSortField();
    $direction = $req->query->order ?? 'ASC';

    $hoteles = $this->modelo->getAll($orderBy, $direction);
    return $res->json($hoteles, 200);
  }

  public function getHotel($req, $res)
  {
    $id = $req->params->id;

    if (empty($id)) {
      $hoteles = $this->modelo->getAll();
      return $res->json($hoteles);
    } else {
      $hotel = $this->modelo->get($id);

      if (!empty($hotel)) {
        return $res->json($hotel);
      } else {
        return $res->json("El {$this->nombreRecurso} con el {$this->nombreId}=$id no existe", 404);
      }
    }
  }

  public function deleteHotel($req, $res)
  {
    $hotel_id = $req->params->id;
    $hotel = $this->modelo->get($hotel_id);

    if (!$hotel) {
      return $res->json("El {$this->nombreRecurso} con el {$this->nombreId}=$hotel_id no existe", 404);
    }

    $this->modelo->delete($hotel_id);
    $res->json("El {$this->nombreRecurso} con el {$this->nombreId}=$hotel_id se eliminó con éxito", 204);
  }

  public function insert($req, $res)
  {
    $nombre = $req->body->nombre;
    $direccion = $req->body->direccion;
    $ciudad = $req->body->ciudad;
    $telefono = $req->body->telefono;
    $email = $req->body->email;

    if (empty($nombre) || empty($ciudad)) {
      return $res->json('Faltan datos requeridos: nombre, ciudad', 400);
    }

    $hotel_id = $this->modelo->insert($nombre, $direccion, $ciudad, $telefono, $email);
    $res->json($hotel_id, 201);
  }

 
  public function update($req, $res)
  {
    $hotel_id = $req->params->id;
    $hotel = $this->modelo->get($hotel_id);

    if (!$hotel) {
      return $res->json("El hotel con el id=$hotel_id no existe", 404);
    }

    if (empty($req->body->nombre) || empty($req->body->ciudad)) {
      return $res->json('Faltan datos requeridos: nombre, ciudad', 400);
    }

    $nombre = $req->body->nombre;
    $direccion = $req->body->direccion;
    $ciudad = $req->body->ciudad;
    $telefono = $req->body->telefono;
    $email = $req->body->email;

    $this->modelo->update($hotel_id, $nombre, $direccion, $ciudad, $telefono, $email);

    $updatedHotel = $this->modelo->get($hotel_id);
    return $res->json($updatedHotel, 200);
  }
}
