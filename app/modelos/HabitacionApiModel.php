<?php
class HabitacionApiModel
{
  private $db;

  public function __construct()
  {
    $this->db = new PDO('mysql:host=localhost;dbname=hoteles_db;charset=utf8', 'root', '');
  }

  public function getAll($orderBy = 'id_habitacion', $direction = 'ASC')
  {
    
    $allowedFields = ['id_habitacion', 'numero', 'precio', 'id_hotel', 'id_tipo'];
    $allowedDirections = ['ASC', 'DESC']; 
    
    $orderBy = in_array($orderBy, $allowedFields) ? $orderBy : 'id_habitacion';
    $direction = strtoupper($direction);
    $direction = in_array($direction, $allowedDirections) ? $direction : 'ASC';
    
    $query = $this->db->prepare("SELECT * FROM habitacion ORDER BY $orderBy $direction");
    $query->execute([]);
    $habitaciones = $query->fetchAll(PDO::FETCH_OBJ);

    return $habitaciones;
  }

  public function get($id)
  {
    $query = $this->db->prepare('SELECT * FROM habitacion WHERE id_habitacion = ?');
    $query->execute([$id]);
    $habitacion = $query->fetchAll(PDO::FETCH_OBJ);

    return $habitacion;
  }

  public function delete($id)
  {
    $query = $this->db->prepare('DELETE FROM habitacion WHERE id_habitacion = ?');
    $query->execute([$id]);
  }

  public function insert($numero, $precio, $id_hotel, $id_tipo, $imagen_url = null)
  {
    $query = $this->db->prepare("INSERT INTO habitacion(numero, precio, id_hotel, id_tipo, imagen_url) VALUES(?,?,?,?,?)");
    $query->execute([$numero, $precio, $id_hotel, $id_tipo, $imagen_url]);

    return $this->db->lastInsertId();
  }

  public function update($id, $numero, $precio, $id_hotel, $id_tipo, $imagen_url = null)
  {
    $query = $this->db->prepare(
      "UPDATE habitacion 
       SET numero = ?, precio = ?, id_hotel = ?, id_tipo = ?, imagen_url = ? 
       WHERE id_habitacion = ?"
    );
    $query->execute([$numero, $precio, $id_hotel, $id_tipo, $imagen_url, $id]);
  }
}
