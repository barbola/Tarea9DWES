<?php
// Esta API tiene dos posibilidades; Mostrar una lista de autores o mostrar la información de un autor específico.

/*funcion que hace una consulta a la tabla autor
	y retorna todas sus filas.
	@return $lista_autores array con todas las filas
	*/
function get_lista_autores()
{
    //Esta información se cargará de la base de datos
    /*$lista_autores = array(
        array("id" => 0, "nombre" => "J. R. R.", "apellidos" => "Tolkien" ),
        array("id" => 1, "nombre" => "Isaac", "apellidos" => "Asimov")
    );*/
    $lista_autores;
    $bd=conexion();
    $consulta=$bd->query("select * from Autor;");
          while($filas=$consulta->fetch_assoc())
          {
            $lista_autores[]=$filas;
          }
    
    return $lista_autores;
}

/*funcion que hace una consulta a la tabla libros
	y retorna todas sus filas
	@return $lista_libros array con todas las filas
	*/
function get_lista_libros()
{
    $lista_libros;
    $bd=conexion();
    $consulta=$bd->query("select id,titulo from Libro order by id;");
          while($filas=$consulta->fetch_assoc())
          {
            $lista_libros[]=$filas;
          }
    
    return $lista_libros;
}
/*funcion que hace una consulta a la tabla libro
	y retorna todas sus filas resultantes.
	Controla que sino tiene resultado, envia frase
	indicandolo.
	
	@param $id letra o conjunto de letras por la que se
	busca un titulo que las contenga.
	@return $sugerencias array con todas las filas
	*/
function get_lista_libros_por_letra($id)
{
	$sugerencias = "";

	if ($id !== "")
	{
		 $lista_libros;
    		$bd=conexion();
    		$aux=1;
    		$consulta=$bd->query("select id,titulo from Libro where titulo like '%$id%' order by id");
          while($filas=$consulta->fetch_assoc())
          {
            $lista_libros[]=$filas;
            $aux++;
          }
          if($aux>1)
          {
	          foreach ($lista_libros as $libro) 
	          {
	          	$sugerencias .= "<br>".$libro["titulo"];
	          }
          }
	}
	echo $sugerencias === "" ? "no se encuentran sugerencias" : $sugerencias;
}

/**
funcion que hace una consulta a la tabla libro
  y retorna todas sus filas resultantes.
  Controla que sino tiene resultado, envia frase
  indicandolo.
  
  @param $id letra o conjunto de letras por la que se
  busca un autor y retorna sus libros.
  @return $sugerencias array con todas las filas
*/

function get_lista_libros_por_autor($id)
{
  $sugerencias = "";

  if ($id !== "")
  {
     $lista_libros;
        $bd=conexion();
        $aux=1;
        $consulta=$bd->query("select titulo, nombre, apellidos
                              from Libro, Autor
                              where Libro.id_autor = Autor.id
                              AND
                              Autor.apellidos like '%$id%' 
                              order by titulo");
          while($filas=$consulta->fetch_assoc())
          {
            $lista_libros[]=$filas;
            $aux++;
          }
          if($aux>1)
          {
            foreach ($lista_libros as $libro) 
            {
              $sugerencias .= "<br>".$libro["titulo"]." - ".$libro["nombre"]." ".$libro["apellidos"];
            }
          }
  }
  echo $sugerencias === "" ? "no se encuentran sugerencias" : $sugerencias;
}

/*funcion que hace una consulta a la tabla autor
	y retorna todas sus filas
	
	@param $autor id del autor
	@return $info_libro array con todas las filas
	*/
function get_datos_autor($id)
{
    $info_autor = array();
    //Esta información se cargará de la base de datos
    /*switch ($id){
        case 0:
          $info_autor = array("nombre" => "J. R. R.", "apellidos" => "Tolkien", "nacionalidad" => "Inglaterra"); 
          break;
        case 1:
          $info_autor = array("nombre" => "Isaac", "apellidos" => "Asimov", "nacionalidad" => "Rusia"); 
          break;
    }*/

    $bd=conexion();
    //$consulta=$bd->query("select * from Autor where id =  '$id';");
    $consulta=$bd->query("select Autor.*, Libro.titulo, Libro.id AS idLibro 
      from Autor,Libro where Autor.id=Libro.id_autor and Autor.id = '$id';");
          while($filas=$consulta->fetch_assoc())
          {
            //$info_autor=$filas;
            $info_autor[]=$filas;
          }
    
    return $info_autor;
}
/*funcion que hace una consulta a la tabla libros
	y retorna todas sus filas
	
	@param $autor id del libro
	@return $info_libro array con todas las filas
	*/
function get_datos_libro($id)
{
    $info_libro = array();
    $bd=conexion();
    $consulta=$bd->query("SELECT titulo,f_publicacion,Autor.nombre,Autor.apellidos, Autor.id as idAutor
      FROM Autor,Libro WHERE Autor.id = Libro.id_autor and Libro.id =  '$id';");
          while($filas=$consulta->fetch_assoc())
          {
            $info_libro=$filas;
          }
    return $info_libro;
}

/*funcion que hace una consulta a la tabla autor y libro
	y retorna todas sus filas
	
	@return $info_libro array con todas las filas, null en caso de error
	*/
function get_datos_libroC()
{
    $info_libro = array();
    $bd=conexion();
    $consulta=$bd->query("SELECT Autor.nombre, Autor.apellidos, Autor.nacionalidad,
							Libro.id as id_libro, Libro.titulo, Libro.f_publicacion, 
							Libro.id_autor
							FROM Autor,Libro WHERE Autor.id = Libro.id_autor;");
          while($filas=$consulta->fetch_assoc())
          {
            $info_libro[]=$filas;
          }
    
    return $info_libro;
}
/*funcion que conecta con la bd remota 
	y retorna la conexion
	
	@return $conexion conexion a la bd libros
	*/
function conexion()
{
    $conexion=new mysqli("PMYSQL141.dns-servicio.com:3306", "barbola2", "javier@2019Mw", "8181927_Libros");

      $conexion->query("SET NAMES 'utf8'");
      if (!$conexion)
        {
          return null;
        }
      else
        return $conexion; 
}

$posibles_URL = array("get_lista_autores", "get_datos_autor","get_lista_libros","get_datos_libro","get_datos_libroC","get_lista_libros_por_letra","get_lista_libros_por_autor");
$valor = "Ha ocurrido un error";

if (isset($_GET["action"]) && in_array($_GET["action"], $posibles_URL))
{
  switch ($_GET["action"])
    {
      case "get_lista_autores":
        $valor = get_lista_autores();
        break;
      case "get_lista_libros":
        $valor = get_lista_libros();
        break; 
      case "get_datos_libroC":
        $valor = get_datos_libroC();
        break;  
      case "get_datos_autor":
        if (isset($_GET["id"]))
            $valor = get_datos_autor($_GET["id"]);
        else
            $valor = "Argumento no encontrado";
        break;
      case "get_lista_libros_por_letra":
        if (isset($_GET["id"]))
            $valor = get_lista_libros_por_letra($_GET["id"]);
        else
            $valor = "Argumento no encontrado";
        break; 
      case "get_lista_libros_por_autor":
        if (isset($_GET["id"]))
            $valor = get_lista_libros_por_autor($_GET["id"]);
        else
            $valor = "Argumento no encontrado";
        break;    
      case "get_datos_libro":
        if (isset($_GET["id"]))
            $valor = get_datos_libro($_GET["id"]);
        else
            $valor = "Argumento no encontrado";
        break;  
    }
}

//devolvemos los datos serializados en JSON
exit(json_encode($valor));
?>