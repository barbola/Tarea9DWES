
<!DOCTYPE HTML>
<html>
<head>
<title>Tarea 8 DWES</title>

<link rel="stylesheet" type="text/css" href="estilo.css" media="all" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>
<body>
<header>
  <h1>La Vieja Biblioteca</h1>
  <h2>“La escritura es la pintura de la voz”. Voltaire</h2>
</header>
<section>
  <h1>Disfruta de nuestra colección</h1>

  <article id="contenedorCompleto" >
      <table id="tablaCompleta" class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nombre</th>
          <th scope="col">Titulo</th>
        </tr>
      </thead>
      <tbody>
          <?php
          //controlo que si no retorna nada la bd, pinte en blanco
            $autor="";
            //$url="https://isabelcanosoriano.com/api.php?action=get_datos_libroC";
            $url="http://localhost/t9/api.php?action=get_datos_libroC";
            $rawdata=file_get_contents($url);
            $biblioteca=json_decode($rawdata,true);
            /**/
            if($biblioteca=="") 
            {
              ?>
                  <tr>
                    <th scope="row">1</th>
                    <td>""</td>
                    <td>""</td>                  
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>""</td>
                    <td>""</td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td>""</td>
                    <td>""</td>                  
                  </tr>
                  <?php
            }
            else
            {
              //retorno la informacion de las filas y las pinto en la tabla
              foreach ($biblioteca as $libro) 
              {
                  $nombreCompleto= $libro["apellidos"];
                  $pais=$libro["nacionalidad"];
                  $titulo=$libro["titulo"];
                  $fecha=$libro["f_publicacion"];
                  $id=$libro["id_libro"]+1;
                  $idAutor=$libro["id_autor"];
                  ?>
                  <tr>
                    <th scope="row"><?php echo $id ?></th>
                    <td>
                      <?php  
                      ?>
                      <?php echo $nombreCompleto ?>
                      </a>
                    </td>
                    <td><?php echo $titulo ?></td>
                  </tr>
                  <?php
              }
            }            
          ?>
      </tbody>
    </table>
  </article>
</section>
<aside>
 <div id="accion1" >
      <h1>Busqueda por letras</h1>
      <form>
          Libros: <input type="text" onkeyup="mostrar_sugerencias(this.value)">
      </form>
          <p><strong>Sugerencias:</strong> <span id="sugerencias" style="color:#0080FF;"></span></p>
  </div>

  <div id="accion5" style="display:none">
      <h1>Titulos resueltos:</h1>
      <p><strong>Sugerencias:</strong> <span id="sugerencias" style="color:#0080FF;"></span></p>
  </div>


  <div id="accion1" >
      <h1>Busqueda por apellido de Autor</h1>
      <form>
          Libros: <input type="text" onkeyup="mostrar_sugerenciasDos(this.value)">
      </form>
          <p><strong>Sugerencias:</strong> <span id="sugerenciasDos" style="color:#0080FF;"></span></p>
  </div>

  <div id="accion5" style="display:none">
      <h1>Titulos resueltos:</h1>
      <p><strong>Sugerencias:</strong> <span id="sugerenciasDos" style="color:#0080FF;"></span></p>
  </div>


 <div id="accion1" >
      <h1>Lista de libros</h1>
      <form action="index.php" method="post" >
        <select class="custom-select" name="libroSelect">
        <option selected>Libros</option>
         <?php
         //llama a la funcion para rellenar el select con los libros
            //$url="https://isabelcanosoriano.com/api.php?action=get_lista_libros";
            $url="http://localhost/t9/api.php?action=get_lista_libros";
            $rawdata=file_get_contents($url);
            $biblioteca=json_decode($rawdata,true);
        foreach ($biblioteca as $libro) 
        {
            $titulo=$libro["titulo"];
            $id=$libro["id"];
            ?>
            <option value="<?php echo $id ?>"><?php echo $titulo ?></option>
            <?php
        }
      ?>     
        </select>
        <button type="submit" class="btn btn-primary">Detalles</button>
        </form>
  </div>

  <div id="accion3" style="display:none">
      <h1>Detalles Libro</h1>
         <?php
         if (isset($_POST["libroSelect"])) 
          {
                $url = file_get_contents('https://isabelcanosoriano.com/api.php?action=get_datos_libro&id=' . $_POST["libroSelect"]);    
                $biblioteca=json_decode($url,true);
                ?>
                  <table class="table table-striped">
                <tr>
                    <td>Titulo: </td><td> <?php echo $biblioteca["titulo"] ?></td>
                </tr>
                <tr>
                    <td>F. Publicación: </td><td> <?php echo ' '.$biblioteca["f_publicacion"] ?></td>
                </tr>
                <tr>
                    <td>Autor: </td><td> <?php echo $biblioteca["nombre"].' '.$biblioteca["apellidos"] ?></td>
                </tr>
                </table>             
              <?php    
            } ?>        
  </div>

 <div id="accion2" >
      <h1>Lista de Autores</h1>
      <form action="index.php" method="post" >
        <select class="custom-select" name="autorSelect">
        <option selected>Autores</option>
         <?php
         //llama a la funcion para rellenar el select con los libros
            $url="https://isabelcanosoriano.com/api.php?action=get_lista_autores";
            $rawdata=file_get_contents($url);
            $biblioteca=json_decode($rawdata,true);
        foreach ($biblioteca as $autores) 
        {
            $nb=$autores["nombre"]; 
            $ap=$autores["apellidos"];
            $id=$autores["id"];
            ?>
            <option value="<?php echo $id ?>"><?php echo $nb.' '.$ap ?></option>
            <?php
        }
      ?>     
        </select>
        <button type="submit" class="btn btn-primary">Detalles</button>
        </form>
  </div>
 <div id="accion4" style="display:none">
      <h1>Detalles Libro</h1>
         <?php
         if (isset($_POST["autorSelect"])) 
          {
                $url = file_get_contents('https://isabelcanosoriano.com/api.php?action=get_datos_autor&id=' . $_POST["autorSelect"]);    
                $biblioteca=json_decode($url,true);
                $aux=1;
                $libreriaAutor='';
                $tamArray= (count($biblioteca));
                foreach($biblioteca as $autores)
                {
                      if($aux==1)
                      {    
                      ?>
                            <table class="table table-striped">
                                <tr>
                                    <td>Nombre: </td><td> <?php echo $autores["nombre"] ?></td>
                                </tr>
                                <tr>
                                    <td>Apellidos: </td><td> <?php echo $autores["apellidos"] ?></td>
                                </tr>
                                <tr>
                                    <td>Fecha de nacimiento: </td><td> <?php echo $autores["nacionalidad"] ?></td>
                                </tr>
                                <tr>
                                    <td>Libros: </td>
                                </tr>  
                                </table>
                                
                      <?php 
                                
                      }
                      ?>
                                     
                <?php    
                $aux++;
                }
                foreach($biblioteca as $autores)
                {
                  ?>
                  <ul class="list-group">
                       <li class="list-group-item list-group-item-secondary"><?php echo $autores["titulo"] ?></li>

                  </ul>  
         
                  <?php
                }  
                ?>
                               
      <?php    
          } 
      ?>     
 </div>
  

</aside>
<footer>
   <h1>María Isabel Cano Soriano</h1>
</footer>

<!--funcion propia de boostrap -->
<script type="text/javascript">
  $(function(){
    console.log("entraaaa");
    $('.dropdown-toggle').dropdown();
  })
  $('.dropdown-toggle').dropdown()
</script>
<script languague="javascript">
        function mostrar1() 
        {
            div = document.getElementById('accion3');
            div.style.display = '';
        }
        function cerrar1() 
        {
            div = document.getElementById('accion3');
            div.style.display = 'none';
        }

        function mostrar2() 
        {
            div = document.getElementById('accion4');
            div.style.display = '';
        }
        function cerrar2() 
        {
            div = document.getElementById('accion4');
            div.style.display = 'none';
        }
        function Valida(formulario) 
        {
            var errorUsu = document.getElementById('errorUsu');
                /* Validación de campos NO VACÍOS */
                if ((formulario.campoLibro.value.length == 0) ) 
                {
                    errorUsu.innerHTML = "Introduzca alguna letra...";
                    errorUsu.style.color = "red";
                    return false;
                }  
                /*validacion por expresion regulares
                usuario: Debe contener letras única y exclusivamente en mínusculas.
                Tendrá una longitud entre 3 y 12 caracteres.*/
                var erusu=/^[a-zA-Z]{1,12}$/;
                if (!(erusu.test(formulario.campoLibro.value)))          
                {
                    errorUsu.innerHTML = "Solo letras";
                    errorUsu.style.color = "red";
                    return false;
                } 
                //en el caso que todo sea correcto es indicado
                else
                {
                    errorUsu.innerHTML = "Los libros resultantes son:";
                    errorUsu.style.color = "green";
                    mostrarLibros();
                    return false;
                }
                /* si no hemos detectado fallo devolvemos TRUE */
                return true;
        }
        function mostrarLibros()
        {
            div = document.getElementById('accion5');
            div.style.display = '';
        }
        /*funcion que llama a la api y retorna lista de libros
        segun letra o letras que coincidan con el titulo*/
        function mostrar_sugerencias(str) 
        {
           if (str.length == 0) 
           {
             document.getElementById("sugerencias").innerHTML = "";
             return; 
           }
            else 
           {
               var asyncRequest = new XMLHttpRequest();
               asyncRequest.onreadystatechange = stateChange;
               asyncRequest.open("GET", "api.php?action=get_lista_libros_por_letra&id="+str, true);
               asyncRequest.send(null);
               function stateChange()
               {
                   if (asyncRequest.readyState == 4 && asyncRequest.status == 200) 
                   {
                     document.getElementById("sugerencias").innerHTML = asyncRequest.responseText;
                   }
               }
           }
        }

        function mostrar_sugerenciasDos(str) 
        {
           if (str.length == 0) 
           {
             document.getElementById("sugerenciasDos").innerHTML = "";
             return; 
           }
            else 
           {
               var asyncRequest = new XMLHttpRequest();
               asyncRequest.onreadystatechange = stateChange;
               asyncRequest.open("GET", "api.php?action=get_lista_libros_por_autor&id="+str, true);
               asyncRequest.send(null);
               function stateChange()
               {
                   if (asyncRequest.readyState == 4 && asyncRequest.status == 200) 
                   {
                     document.getElementById("sugerenciasDos").innerHTML = asyncRequest.responseText;
                   }
               }
           }
        }
      
</script>


</body>
</html>

<?php
 
if (isset($_POST["libroSelect"])) 
{
      $libro= $_POST["libroSelect"];
      echo '<script languague="javascript">';
      echo 'mostrar1() ';
      echo '</script>';
      
}

if (isset($_POST["autorSelect"])) 
{
      $autor= $_POST["autorSelect"];
       echo '<script languague="javascript">';
      echo 'mostrar2() ';
      echo '</script>';
}


?>