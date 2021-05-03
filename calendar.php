<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8' />
    <!--Links full calendar-->
    <link href='assets/fullcalendar/lib/main.css' rel='stylesheet' />
    <script src='assets/fullcalendar/lib/main.js'></script>
    <!--Fin Links full calendar-->
    <!--Links Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!--Links Bootstrap-->
  </head>
  <body>
    <div id='calendar'>
    </div>
  <!--MODAL NUEVO EVENTO-->
  <div class="modal" tabindex="-1" id="modal_evento">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Nuevo Evento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <input type="hidden" id="id">
              <label for="concepto_evento">Nombre del Evento</label>
              <input type="text" class="form-control" id="title">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Fecha inicio</label>
              <input type="date" class="form-control" id="date_start">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Hora inicio</label>
              <input type="time" class="form-control" id="hour_start">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Fecha finalización</label>
              <input type="date" class="form-control" id="date_end">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Hora de finalización</label>
              <input type="time" class="form-control" id="hour_end">
            </div>
            
            <!-- <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1">
              <label class="form-check-label" for="exampleCheck1">Todo el día</label>
            </div> -->
            <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id="editEv">Editar Evento</button>
          <button type="button" class="btn btn-primary" id="delEv">Eliminar Evento</button>
          <button type="button" class="btn btn-primary" id="addEv">Registrar Evento</button>
        </div>
      </div>
    </div>
  </div>
  <!--FIN MODAL NUEVO EVENTO-->

  <!--Links JS Y JQ de Bootstrap-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
  <!--Links JS Y JQ de Bootstrap-->
<!-- moment lib -->
<script src='https://cdn.jsdelivr.net/npm/moment@2.27.0/min/moment.min.js'></script>

<!-- fullcalendar bundle -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.js'></script>

<!-- the moment-to-fullcalendar connector. must go AFTER the moment lib -->
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/moment@5.6.0/main.global.min.js'></script>
  

  <script>
  //inicio full calendar
    $(document).ready(function(){
        var calendarEl = document.getElementById('calendar'); //declaración global
        var calendar = new FullCalendar.Calendar(calendarEl, { //conversión a fullcalendar
            initialView: 'dayGridMonth',
            eventTimeFormat: { // like '14:30:00'
              hour: '2-digit',
              minute: '2-digit',
              // second: '2-digit',
              hour12: false
            },
            selectable: true,
            editable: true,
            height: 750,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay',
            },
            dateClick: function(info) {//Al seleccionar un día del calendario...
              // alert('Clicked on: ' + info.dateStr);
              // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
              // alert('Current view: ' + info.view.type);
              // change the day's background color just for fun
              limpiarFormulario_modal_evento();
              $('#title').val('Nuevo Evento');
              $('#date_start').val(moment(info.date).format('YYYY-MM-DD'));
              $('#hour_start').val('10:00:00');
              $('#date_end').val(moment(info.date).format('YYYY-MM-DD'));
              $('#hour_end').val('21:00:00');
              $("#modal_evento").modal("show");//jquery: buscamos el elemento con id modal_evento y lo ejecutamos. Es la ventana modal de cuando pinchas en el calendario
              $("#addEv").show();
              $("#editEv").hide();
              $("#delEv").hide();
              // info.dayEl.style.backgroundColor = 'red';
              //función que llame a ventana modal con formulario de nuevo evento
            },
            eventClick: function(info) {//Al seleccionar un evento del calendario...
              // alert('Event: ' + info.event.title);
              // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
              // alert('View: ' + info.view.type);
              // change the border color just for fun
              // info.el.style.borderColor = 'red';
              // console.log(moment(info.event.start).format('L'));//ME FORMATEA LA FECHA DEL EVENTO A DD-MM-YYYY
              // console.log(moment(info.event.start).format('YYYY-MM-DD'));//ME FORMATEA LA FECHA DEL EVENTO A YYYY-M-D
              // console.log(moment(info.event.start).format('hh:mm:ss'));//ME FORMATEA LA FECHA DEL EVENTO A hh:mm:ss pero las 20 son las 08
              // console.log(moment(info.event.start).format('H:mm:ss'));//ME FORMATEA LA FECHA DEL EVENTO A H:mm:ss y las 20 son las 20
              $("#title").val(info.event.title);
              $("#date_start").val(moment(info.event.start).format('YYYY-MM-DD'));
              $("#hour_start").val(moment(info.event.start).format('H:mm:ss'));
              $("#date_end").val(moment(info.event.end).format('YYYY-MM-DD'));
              $("#hour_end").val(moment(info.event.end).format('H:mm:ss'));
              $("#modal_evento").modal("show");
              $("#addEv").hide();
              $("#editEv").show();
              $("#delEv").show();
              // console.log(info.event.id);
              $('#id').val(info.event.id);//Le damos al campo id de tipo hidden de la ventana modal la id del último seleccionado. Para si pulsamos eliminar, que se elimine 
              // console.log(info.event.title);
            },
            eventDrop: function(info) {
              //recuperamos el ID del evento y todos sus campos
              // console.log(info);
              // console.log(info.event);
              // console.log(info.event.title);
              // console.log(info.event.start);
              // console.log(info.event.end);
              actualizar_elemento_dropeado(info);

              //Cambiamos la fecha original por la extraída de info.event.start
              //Contactamos con bbdd para actualizar


              // alert(info.event.title + " was dropped on " + info.event.start.toISOString());

              // if (!confirm("Are you sure about this change?")) {
              //   info.revert();
              // }
            },
            eventResize: function(info) {
              actualizar_elemento_dropeado(info);
              // alert(info.event.title + " end is now " + info.event.end.toISOString());

              // if (!confirm("is this okay?")) {
              //   info.revert();
              // }
            },

            events:'axis.php?instruccion=listar_eventos'
        });
        //fin full calendar
        calendar.render(); //lo renderizamos

        function anadirEvento(){
          //recuperamos los valores de los campos del formulario modal de nuevo evento
          var title = $('#title').val();
          var date_start = $('#date_start').val();
          var hour_start = $('#hour_start').val();
          var date_end = $('#date_end').val();
          var hour_end = $('#hour_end').val();
          var start = date_start + " " + hour_start;
          var end = date_end + " " + hour_end;
          // console.log (id + " - " + title + " - " + start + " - " + end + " - ");//Lo muestro por consola para comprobaciones y debugs
          $('#modal_evento').modal("hide");
          //Los enviamos a axis.db como parámetros con la ?instrucción=insertar_evento ==> axis.db?instruccion=insertar_evento&id=$id&title=$title...etc
          //mediante un ajax... supongo
          var url="axis.php?instruccion=insertar_evento&title="+title+"&start="+start+"&end="+end;
          const xhttp = new XMLHttpRequest(); //Creamos el objeto ajax
                  xhttp.onreadystatechange = function(){//Cuando ese objeto cambie de estado, haremos lo que introduzcamos en esta función anónima
                      //Como el cambio no tiene por qué ser a nuestro favor, debemos comprobar que recuperamos un 4 y un 200
                      if(this.readyState == 4 && this.status ==200){ //Si la conexión ha sido un éxito...
                          // calendar.render();
                          calendar.refetchEvents();
                      }else{//Si hemos fallado en la conexión y recuperación de esa información
                          //document.getElementById("contenedor").innerHTML="<p>Ha habido un error, esperábamos respuesta 4-200 y hemos recibido "+this.readyState+" - "+this.status+"</p>";
                      }
                  };
                  xhttp.open("GET", url, true); //Recibe el método (post o get), la url del fichero a recuperar y true o false a la pregunta de si queremos que sea asínscrono. Si no es asíncrono no es AJAX
                  xhttp.send(null);
          //fin del ajax
        }
        function editarEvento(){
          //recuperamos los valores de los campos del formulario modal de nuevo evento
          var id = $('#id').val();
          var title = $('#title').val();
          var date_start = $('#date_start').val();
          var hour_start = $('#hour_start').val();
          var date_end = $('#date_end').val();
          var hour_end = $('#hour_end').val();
          var start = date_start + " " + hour_start;
          var end = date_end + " " + hour_end;
          // console.log (id + " - " + title + " - " + start + " - " + end + " - ");//Lo muestro por consola para comprobaciones y debugs
          $('#modal_evento').modal("hide");
          //Los enviamos a axis.db como parámetros con la ?instrucción=insertar_evento ==> axis.db?instruccion=insertar_evento&id=$id&title=$title...etc
          //mediante un ajax... supongo
          var url="axis.php?instruccion=editar_evento&id="+id+"&title="+title+"&start="+start+"&end="+end;
          const xhttp = new XMLHttpRequest(); //Creamos el objeto ajax
                  xhttp.onreadystatechange = function(){//Cuando ese objeto cambie de estado, haremos lo que introduzcamos en esta función anónima
                      //Como el cambio no tiene por qué ser a nuestro favor, debemos comprobar que recuperamos un 4 y un 200
                      if(this.readyState == 4 && this.status ==200){ //Si la conexión ha sido un éxito...
                          // calendar.render();
                          calendar.refetchEvents();
                      }else{//Si hemos fallado en la conexión y recuperación de esa información
                          //document.getElementById("contenedor").innerHTML="<p>Ha habido un error, esperábamos respuesta 4-200 y hemos recibido "+this.readyState+" - "+this.status+"</p>";
                      }
                  };
                  xhttp.open("GET", url, true); //Recibe el método (post o get), la url del fichero a recuperar y true o false a la pregunta de si queremos que sea asínscrono. Si no es asíncrono no es AJAX
                  xhttp.send(null);
          //fin del ajax
        }
        function eliminarEvento(){
          //recuperamos los valores de los campos del formulario modal de nuevo evento
          var id = $('#id').val();
          $('#modal_evento').modal("hide");
          //Los enviamos a axis.db como parámetros con la ?instrucción=eliminar_evento
          //mediante un ajax... supongo
          var url="axis.php?instruccion=eliminar_evento&id="+id;
          const xhttp = new XMLHttpRequest(); //Creamos el objeto ajax
                  xhttp.onreadystatechange = function(){//Cuando ese objeto cambie de estado, haremos lo que introduzcamos en esta función anónima
                      //Como el cambio no tiene por qué ser a nuestro favor, debemos comprobar que recuperamos un 4 y un 200
                      if(this.readyState == 4 && this.status ==200){ //Si la conexión ha sido un éxito...
                          // calendar.render();
                          calendar.refetchEvents();
                      }else{//Si hemos fallado en la conexión y recuperación de esa información
                          //document.getElementById("contenedor").innerHTML="<p>Ha habido un error, esperábamos respuesta 4-200 y hemos recibido "+this.readyState+" - "+this.status+"</p>";
                      }
                  };
                  xhttp.open("GET", url, true); //Recibe el método (post o get), la url del fichero a recuperar y true o false a la pregunta de si queremos que sea asínscrono. Si no es asíncrono no es AJAX
                  xhttp.send(null);
          //fin del ajax
        }
        function actualizar_elemento_dropeado(info){
          //recuperamos los valores de los campos del formulario modal de nuevo evento
          var id = info.event.id;
          var title = info.event.title;
          var start = moment(info.event.start).format('YYYY-MM-DD H:mm:ss');
          var end = moment(info.event.end).format('YYYY-MM-DD H:mm:ss');
          console.log(id);
          console.log(title);
          console.log(start);
          console.log(end);
          
          //Los enviamos a axis.db como parámetros con la ?instrucción=editar_evento
          //mediante un ajax... supongo
          var url="axis.php?instruccion=editar_evento&id="+id+"&title="+title+"&start="+start+"&end="+end;
          const xhttp = new XMLHttpRequest(); //Creamos el objeto ajax
                  xhttp.onreadystatechange = function(){//Cuando ese objeto cambie de estado, haremos lo que introduzcamos en esta función anónima
                      //Como el cambio no tiene por qué ser a nuestro favor, debemos comprobar que recuperamos un 4 y un 200
                      if(this.readyState == 4 && this.status ==200){ //Si la conexión ha sido un éxito...
                          // calendar.render();
                          calendar.refetchEvents();
                      }else{//Si hemos fallado en la conexión y recuperación de esa información
                          //document.getElementById("contenedor").innerHTML="<p>Ha habido un error, esperábamos respuesta 4-200 y hemos recibido "+this.readyState+" - "+this.status+"</p>";
                      }
                  };
                  xhttp.open("GET", url, true); //Recibe el método (post o get), la url del fichero a recuperar y true o false a la pregunta de si queremos que sea asínscrono. Si no es asíncrono no es AJAX
                  xhttp.send(null);
          //fin del ajax
        }
        function limpiarFormulario_modal_evento(){
          $('#title').val("");
          $('#date_start').val("");
          $('#hour_start').val("");
          $('#date_end').val("");
          $('#hour_end').val("");
        }
        $('#addEv').on('click', anadirEvento); //al botón de la ventana modal que permite registrar nuevo evento cuando ya hemos rellenado los campos del formulariio, le metemos un listener evento de acción onclick ue lleva a anadir evento
        $('#delEv').on('click', eliminarEvento); //al botón de la ventana modal que permite eliminar un evento cuando lo hemos seleccionado le metemos un lístener que lleva a la función que gestiona su eliminado
        $('#editEv').on('click', editarEvento); //al botón de la ventana modal que permite eliminar un evento cuando lo hemos seleccionado le metemos un lístener que lleva a la función que gestiona su eliminado
    });

  </script>
  </body>
</html>




