<?php
class HotelApiModel
{
  private $db;

  public function __construct()
  {
    $this->db = new PDO('mysql:host=localhost;dbname=hoteles_db;charset=utf8', 'root', '');
  }

  public function getAll($orderBy = 'id_hotel', $direction = 'ASC')
  {
    
    $allowedFields = ['id_hotel', 'nombre', 'ciudad'];
    $allowedDirections = ['ASC', 'DESC'];
    
    $orderBy = in_array($orderBy, $allowedFields) ? $orderBy : 'id_hotel';
    $direction = strtoupper($direction);
    $direction = in_array($direction, $allowedDirections) ? $direction : 'ASC';
    
    $query = $this->db->prepare("SELECT * FROM hotel ORDER BY $orderBy $direction");
    $query->execute([]);
    $hoteles = $query->fetchAll(PDO::FETCH_OBJ);

    return $hoteles;
  }

  public function get($id)
  {
    $query = $this->db->prepare('SELECT * FROM hotel WHERE id_hotel = ?');
    $query->execute([$id]);
    $hotel = $query->fetchAll(PDO::FETCH_OBJ);

    return $hotel;
  }

  public function delete($id)
  {
    $query = $this->db->prepare('DELETE FROM hotel WHERE id_hotel = ?');
    $query->execute([$id]);
  }

  public function insert($nombre, $direccion, $ciudad, $telefono, $email)
  {
    $query = $this->db->prepare("INSERT INTO hotel(nombre, direccion, ciudad, telefono, email) VALUES(?,?,?,?,?)");
    $query->execute([$nombre, $direccion, $ciudad, $telefono, $email]);

    return $this->db->lastInsertId();
  }

  public function update($id, $nombre, $direccion, $ciudad, $telefono, $email)
  {
    $query = $this->db->prepare(
      "UPDATE hotel 
       SET nombre = ?, direccion = ?, ciudad = ?, telefono = ?, email = ? 
       WHERE id_hotel = ?"
    );
    $query->execute([$nombre, $direccion, $ciudad, $telefono, $email, $id]);
  }
}
