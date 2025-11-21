<?php


class BaseApiController
{
  protected $modelo;
  protected $nombreRecurso;
  protected $nombreId;

  
   /** Obtener todos los recursos con ordenamiento*/
   
  public function getAll($req, $res)
  {
    $orderBy = $req->query->sort ?? $this->getDefaultSortField();
    $direction = $req->query->order ?? 'ASC';
    
    $recursos = $this->modelo->getAll($orderBy, $direction);
    return $res->json($recursos, 200);
  }

  
  /** Obtener un recurso por ID*/
   
  public function getById($req, $res)
  {
    $id = $req->params->id;

    if (empty($id)) {
      $recursos = $this->modelo->getAll();
      return $res->json($recursos);
    } else {
      $recurso = $this->modelo->get($id);

      if (!empty($recurso)) {
        return $res->json($recurso);
      } else {
        return $res->json("El {$this->nombreRecurso} con el {$this->nombreId}=$id no existe", 404);
      }
    }
  }

  
  /** Eliminar un recurso*/
   
  public function delete($req, $res)
  {
    $recurso_id = $req->params->id;
    $recurso = $this->modelo->get($recurso_id);

    if (!$recurso) {
      return $res->json("El {$this->nombreRecurso} con el {$this->nombreId}=$recurso_id no existe", 404);
    }

    $this->modelo->delete($recurso_id);
    $res->json("El {$this->nombreRecurso} con el {$this->nombreId}=$recurso_id se eliminó con éxito", 204);
  }

  
  /** Métodos por defecto (pueden ser sobrescritos por subclases) */

  protected function getDefaultSortField()
  {
    // Valor por defecto genérico; las subclases pueden sobrescribirlo
    return 'id';
  }

  public function insert($req, $res)
  {
    // Implementación por defecto: indicar que no está implementado
    return $res->json(['error' => 'Not Implemented', 'message' => 'Insert not implemented in BaseApiController'], 501);
  }

  public function update($req, $res)
  {
    // Implementación por defecto: indicar que no está implementado
    return $res->json(['error' => 'Not Implemented', 'message' => 'Update not implemented in BaseApiController'], 501);
  }
}

?>
