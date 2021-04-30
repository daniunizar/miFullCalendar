<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8' />
    <!--Links full calendar-->
    <link href='assets/fullcalendar/lib/main.css' rel='stylesheet' />
    <script src='assets/fullcalendar/lib/main.js'></script>
    <!--Fin Links full calendar-->
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            height: 650,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay',
            },
            events:'axis.php?instruccion=listar_eventos'
            
        });
        calendar.render();
      });

    </script>
  </head>
  <body>
    <div id='calendar'></div>
  </body>
</html>