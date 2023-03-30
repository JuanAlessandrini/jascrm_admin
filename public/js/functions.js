

function showForm(name){
  console.log('dispara ajax');
  getHtmlContent(name, function(res){
      $("#modalContent").html(res);
      // $("#modalLg").modal();
      options = {};
      var myModal = new bootstrap.Modal(document.getElementById('modalLg'), options)
      // var modal = new bootstrap.Modal(document.getElementById('modalLg'));
      myModal.show();
  });
    
}

function getHtmlContent(name, callback){
    $.ajax({
        url: name,
        method: "POST",
        success: function(res) {
          callback(res);
        },
        error: function(err){
          console.log(err);
          new Swal('Error',  err.statusText, 'error');
        }
      });
}
function showFormLg(name){
  //console.log('dispara ajax');
  getHtmlContent(name, function(res){
      $("#modalContentLg").html(res);
      // $("#modalLg").modal();
      options = {};
      var myModal = new bootstrap.Modal(document.getElementById('modalLg'), options)
      // var modal = new bootstrap.Modal(document.getElementById('modalLg'));
      myModal.show();
  });

  
}

function showFormFullScreen(name){
  //console.log('dispara ajax');
  getHtmlContent(name, function(res){
      $("#modalContentLg").html(res);
      let w = ($(window).width() * 0.8) + "px";
      let h = ($(window).height() * 0.7)  + "px";
      //console.log("size: " + w + " x " + h);
      $(".modal-dialog").css({'margin-top': '0px', 'margin': '0px', 'max-width': 'none'});
      $(".modal-dialog").width(w);
      $(".modal-dialog").height(h);
      $(".modal-dialog").css('top',($(window).height() * 0.05)  + "px");
      $(".modal-dialog").css('margin', 'auto auto');
      options = {};
      var myModal = new bootstrap.Modal(document.getElementById('modalLg'), options)
      // var modal = new bootstrap.Modal(document.getElementById('modalLg'));
      myModal.show();
  });

  
}

function validaDni(dni, callback){
  $.ajax({
      url: "/portal/alumno/valida_dni_alumno",
      data: {'dni': dni},
      method: "POST"
    }).done(function(res) {
      console.log(res);
      callback(res);
    });
}

function requestPost(post_url, data_array, callback, callbackError){
  $.ajax({
      url: post_url,
      data: data_array,
      method: "POST"
    }).done(function(res) {
      console.log(res);
      callback(res);
    }).fail(function( jqXHR, textStatus, errorThrown ){
      callbackError(textStatus);
    });
}

function customSort(sortName, sortOrder, data) {
  console.log(sortName);
   var order = sortOrder === 'desc' ? -1 : 1
   data.sort(function (a, b) {
    var col = sortName;
   switch(col.toLowerCase()){
       case 'fecha':
           return datesSorter(a[sortName], b[sortName], order);
           break;
       case 'vigencia':
           return datesSorter(a[sortName], b[sortName], order);
           break;
       case 'cant alumnos':
           var aa = +((a[sortName] + '').replace(/[^\d]/g, ''));
           var bb = +((b[sortName] + '').replace(/[^\d]/g, ''));
           return normalSort(aa,bb, order);
       default:
           return normalSort(a[sortName],b[sortName], order);
   }
   
   });
}
function normalSort(a,b, order){
  if (a < b) {
    return order * -1;
  }
  if (a > b) {
    return order;
  }
  return 0;
}
function datesSorter(a, b, order) {
  const [day, month, year] = a.split('/');
  console.log(day + " " + (+month) + " " + year);
  var l_a =  year + month + day;
  const [dayb, monthb, yearb] = b.split('/');
  var l_b =  yearb + monthb + dayb;
  console.log(l_a);
  
  return normalSort(l_a, l_b, order);
}

$("body").on("submit", ".ajax-form", function (e) {
  e.preventDefault();
  $("#alert").remove();
  var f = document.getElementById('form-edit');
  var fields = $('#form-edit')
         .find("select, input").filter('[required]');

     var label = '';
     $.each(fields, function (ob, i) {
         if ($(i).val() == "") {
             label += $(i).attr("data-error")+"<br>";
         }
     });
     if(label !== ''){
        $("#btnSubmit").after("<div id='alert' class='alert alert-warning'>"+label+"</div>");
        throw new Error("Faltan completar campos!");
     }

  
  // if (f.valid()) {
     var form = $('#form-edit');
     var extra = form.serializeJSON();
     var url = $(form).attr('data-url-post');
    console.log(extra);
     $.ajax({
             type: "POST",
             url: url,
             async:true,
             dataType: 'json',
            data: {'data': extra},
             success: function (data) {
              console.log(data);
                Swal({title:'OK', html: data.message, type:'success'});
                 $("#modalLong").modal('hide');
                 location.reload();
            }, 
            error: function (err) {
              // if(err.statusText!=="OK"){
                console.log(err);
                Swal({title:'Error', html: err.responseText, type:'error'});
              // }
          }
             });
             
//   }else{
     
//  }
});


function readURL(input) {
  var url = input.value;
  var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
  if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
      var reader = new FileReader();

      reader.onload = function (e) {
          $('#imgLogo').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
  }
  
}
$(document).on("change", "#clienteSelect", function(){
  var valor = $(this).val();
  var data = {'value': valor};
$.ajax({
    type: "POST",
    url: "/portal/customer/change-client",
    async:true,
    data: data,
    
    success: function (data) {
    //  console.log(data);
     
       swal({title:'OK', html: 'Cliente seleccionado', type:'success'});
   }, 
   error: function (err) {
      
        swal({title:'Error', html: err.responseText, type:'error'});
      
  }
    });
});

$(document).on("change", ".upload-file", function(event){
  var formData = new FormData();
  var documento = $(this).attr("data-documento");
  var tramite = $(this).attr("data-tramite");
  $("#lblUpload"+documento).fadeOut();
  formData.append("file", this.files[0],this.files[0].name);
  formData.append("fileName", this.files[0].name);
  formData.append ("tramite", tramite);
  formData.append( "documento" , documento);
  
  $.ajax({
    type: "POST",
    url: "/portal/tramite/uploads/add/"+tramite+"/"+documento,
    async:true,
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
    //  console.log(data);
      $("#trDocument"+documento).replaceWith(data);
       swal({title:'OK', html: 'Documento subido', type:'success'});
   }, 
   error: function (err) {
     // if(err.statusText!=="OK"){
       console.log(err);
       swal({title:'Error', html: err.responseText, type:'error'});
       $("#lblUpload"+documento).fadeIn();
     // }
 }
    });
});


$(document).on("change", ".cmb-status", function(event){
  var formData = new FormData();
  var tramite = $(this).attr("data-tramite");
  var valor = $(this).val();
  $(".cmb-status[data-tramite='"+tramite+"']").fadeOut();
 
  formData.append ("tramite", tramite);
  formData.append ("status", valor);
  
  
  $.ajax({
    type: "POST",
    url: "/portal/tramite/status/change/"+tramite,
    async:true,
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
    //  console.log(data);
       swal({title:'OK', html: data.message, type:'success'});
        // $("#modalLong").modal('hide');
        // location.reload();
        $(".cmb-status[data-tramite='"+tramite+"']").fadeIn();
   }, 
   error: function (err) {
     // if(err.statusText!=="OK"){
       console.log(err);
       swal({title:'Error', html: err.responseText, type:'error'});
       $(".cmb-status[data-tramite='"+tramite+"']").fadeIn();
     // }
 }
    });
});

$(document).on("change", ".cmb-status-item", function(event){
  var formData = new FormData();
  var item = $(this).attr("data-tramite-item");
  var tramite = $(this).attr("data-tramite");
  var valor = $(this).val();
  $(".cmb-status-item[data-tramite-item='"+tramite+"']").fadeOut();
 
  formData.append ("tramite", tramite);
  formData.append ("status", valor);
  
  
  $.ajax({
    type: "POST",
    url: "/portal/tramite/item/status/change/"+tramite+"/"+item,
    async:true,
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
    //  console.log(data);
       Swal({title:'OK', html: data.message, type:'success'});
        // $("#modalLong").modal('hide');
        // location.reload();
        $(".cmb-status-item[data-tramite-item='"+tramite+"']").fadeIn();
   }, 
   error: function (err) {
     // if(err.statusText!=="OK"){
       console.log(err);
       Swal({title:'Error', html: err.responseText, type:'error'});
       $(".cmb-status-item[data-tramite-item='"+tramite+"']").fadeIn();
     // }
 }
    });
});


$(document).on("click", "#navbarDropdownMenuLink", function(event){
 
  
  $.ajax({
    type: "POST",
    url: "/portal/user/read-messages/",
    async:true,
    data: {},
    contentType: false,
    processData: false,
    success: function (data) {
    //  console.log(data);
      
   }, 
   error: function (err) {
     // if(err.statusText!=="OK"){
      
     // }
 }
    });
});