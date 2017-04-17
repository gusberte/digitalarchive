var App = (function(){
  var BASE_URL="";

  var initEvents= function(){

    $(".archivo li").click(function(e){
      if( $(this).hasClass("selected")){
        $(this).height("60px");
        $(this).find(".actions").remove();
        $(this).removeClass("selected");
      }else{
        $("li.selected").height("60px");
        $("li.selected").find(".actions").remove();
        $("li.selected").removeClass("selected");

        $(this).addClass("selected"); 
        $(this).height("120px");
        if($(this).find(".actions").length==0){
          $(this).append('<div class="actions"><a href="#permisosmodal" data-toggle="modal" class="permisosbtn" data-dir="'+$(this).data("dir")+'" data-itemid="'+$(this).data("itemid")+'"><i class="glyphicon glyphicon-ban-circle"></i></a><a hred="#" class="borrarbtn" data-dir="'+$(this).data("dir")+'"><i class="glyphicon glyphicon-trash"></i></a></div>');
        }
      }
    });

    $(document).on("click","a.borrarbtn",function(){
      var dir=$(this).data("dir");
      window.location=BASE_URL+"/archivo/borrar?dir="+encodeURI(dir);
    });

    $(document).on("click","a.permisosbtn",function(){
      $("#item_id").val($(this).data("itemid"));
      //Configurando los permisos
      $.ajax({
        url: 'http://localhost/archivodigital/navegador/getRoles',
        data: {item_id: $(this).data("itemid")},
        success: function(data){
          alert(data);
        }
      });
    });
  }

  var folderstree= function(){
    $(".openfolder").click(function(){
      var icon= $(this).find("i");
      if(icon.hasClass("glyphicon-folder-close")){
        icon.removeClass("glyphicon-folder-close");
        icon.addClass("glyphicon-folder-open");
      }else{
        icon.removeClass("glyphicon-folder-open");
        icon.addClass("glyphicon-folder-close");
      }
    });
  }

  var initDropzone= function(){
    $(".uploadfile").dropzone({
        success : function(file, response){
            location.reload();
        }
    });
  }

  return {
    init: function(baseurl){
      BASE_URL = baseurl;
      initEvents();
      folderstree();
      initDropzone();
    }
  }

})();


