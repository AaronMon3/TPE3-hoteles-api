<?php
class TipoHabitacionApiModel
{
  private $db;

  public function __construct()
  {
    $this->db = new PDO('mysql:host=localhost;dbname=hoteles_db;charset=utf8', 'root', '');
  }

  public function getAll($orderBy = 'id_tipo', $direction = 'ASC')
  {
    
    $allowedFields = ['id_tipo', 'nombre'];
    $allowedDirections = ['ASC', 'DESC'];
    
    $orderBy = in_array($orderBy, $allowedFields) ? $orderBy : 'id_tipo';
    $direction = strtoupper($direction);
    $direction = in_array($direction, $allowedDirections) ? $direction : 'ASC';
    
    $query = $this->db->prepare("SELECT * FROM tipohabitacion ORDER BY $orderBy $direction");
    $query->execute([]);
    $tipos = $query->fetchAll(PDO::FETCH_OBJ);

    return $tipos;
  }

  public function get($id)
  {
    $query = $this->db->prepare('SELECT * FROM tipohabitacion WHERE id_tipo = ?');
    $query->execute([$id]);
    $tipo = $query->fetchAll(PDO::FETCH_OBJ);

    return $tipo;
  }

  public function delete($id)
  {
    $query = $this->db->prepare('DELETE FROM tipohabitacion WHERE id_tipo = ?');
    $query->execute([$id]);
  }

  public function insert($nombre, $descripcion, $imagen_url = null)
  {
    $query = $this->db->prepare("INSERT INTO tipohabitacion(nombre, descripcion, imagen_url) VALUES(?,?,?)");
    $query->execute([$nombre, $descripcion, $imagen_url]);

    return $this->db->lastInsertId();
  }

  public function update($id, $nombre, $descripcion, $imagen_url = null)
  {
    $query = $this->db->prepare(
      "UPDATE tipohabitacion 
       SET nombre = ?, descripcion = ?, imagen_url = ? 
       WHERE id_tipo = ?"
    );
    $query->execute([$nombre, $descripcion, $imagen_url, $id]);
  }
}
