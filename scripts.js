function checkInputClosure(){
    timeoutId = null;

    function checkInput(event){
        if(timeoutId !== null){
            clearTimeout(timeoutId);
        }
        timeoutId = $('input[name=q]').val().length > 1 ? 
                    setTimeout(getActivities,300) : null;
    }
    return checkInput;
}

function getActivities(){
    var name = $('form.search input[name=q]').val();
    var type = $('form.search option:selected').val();
    var startDate = $('form.search input[name=sd]').val();
    var endDate = $('form.search input[name=ed]').val();
    var queryString = "q="+name+"&t="+type+"&sd="+startDate+"&ed="+endDate;
    $.ajax({
       url: "get_activities.php?"+queryString,
       type: "GET",
       dataType: "json",
       success: updateActivities,
       error: function(res){ 
          error('Error:'+res);
       }
    });
}

function updateActivities(activities){
    $('tr td').parent().remove();
    var table = $('table');
    for(var index in activities){
        var activity = activities[index];
        var tr = $('<tr>');
        var enlace = $('<a>').text(activity['nombre']);
        enlace.attr('href',"activity.php?id="+activity['id']);
        tr.append($('<td>').append(enlace));
        tr.append($('<td>').text(activity['tipo']));
        tr.append($('<td>').text(convertDate(activity['inicio'])));
        tr.append($('<td>').text(activity['precio'] + ' €'));
        tr.hide();
        table.append(tr);
        tr.fadeIn();
    }
}

function convertDate(epoch_seconds) {
  function pad(s) { return (s < 10) ? '0' + s : s; }
  var d = new Date(epoch_seconds*1000)
  return [pad(d.getDate()), pad(d.getMonth()+1), d.getFullYear()].join('/')
}


function deleteActivity(id,name){
    function deleteAjax(){
        $.ajax({
            url: "delete_activity.php",
            type: "POST",
            data: {"id": id},
            dataType: "json",
            success: function(res){
                if(res.deleted){
                    $('#fila'+id).remove();
                }else {
                    error("Se produjo un error");
                }
            },
            error: function(res){
                error('Error:'+JSON.stringify(res));
            }
        });
    }
    askDelete(name,deleteAjax)
}

function askDelete(name,hacer){
    dialogo=$('<div></div>');
    dialogo.text("¿Desea borrar la actividad '"+name+"'?");
    dialogo.dialog({
        title:'Borrar Actividad',
        width:250,
        modal: true,
        buttons:{
            'Sí':function(){dialogo.dialog('close');hacer();},
            'No':function(){dialogo.dialog('close');}
        }
    });
}

function validationActivity(){
    var name=$("#nombre").val();
    var type=$("#tipo").val();
    var descrip=$("#descripcion").val();
    var price=$("#precio").val();
    var aforo=$("#aforo").val();
    var start=$("#fecha").val();
    var duration=$("#duracion").val();
    $('span').text("");
    if(name.length < 2 || name.length > 32){
        $('#spannombre').text("El nombre debe tener mínimo 2 y máximo 32 caracteres.");
        return false;
    }
    if(type.length < 1 || type.length > 16){
        $('#spantipo').text("El tipo debe tener mínimo 1 y máximo 16 caracteres.");
        return false;
    }
    if(descrip.length < 12 || descrip.length > 1024){
        $('#spandescripcion').text("La descripcion debe tener mínimo 12 y máximo 1024 caracteres.");
        return false;
    }
    if(price.length < 0 || price < 0){
        $('#spanprecio').text("El precio debe ser mayor o igual que cero.");
        return false;
    }
    if(aforo.length < 0 || aforo <= 0){
        $('#spanaforo').text("El aforo deber ser mayor que cero.");
        return false;
    }
    if(start.length < 0 || Date.parse(start) < 0){
        $('#spaninicio').text("El inicio no puede ser negativo.");
        return false;
    }
    
    if(duration.length < 0 || duration < 0){
        $('#spanduracion').text("La duracion no puede ser negativo.");
        return false;
    }
    
    return true;
}


function error(texto){
   $dialogo=$('<div></div>');
   $dialogo.text(texto);
   $dialogo.dialog({
      title:'Error',
      width:300,
      modal: true
   });
}