function setDefaultInput(id,msg){
    var txtObj = $("#"+ id);

    var defObj;
    if($.trim(txtObj.attr("type")).toUpperCase() =="PASSWORD"){
        txtObj.after('<input type="text" id="def_'+id+'" />');
        defObj = $("#def_"+id);
        defObj.val(msg);
        defObj.attr("style", txtObj.attr("style") );
        defObj.attr("name", "def_" + txtObj.attr("name") );
        defObj.attr("class", txtObj.attr("class") );
        defObj.attr("size", txtObj.attr("size") );
        defObj.css("color","#BEBEBE");
    }else{
        defObj = txtObj.clone();
        defObj.attr("name","def_" + txtObj.attr("name"));
        defObj.attr("id","def_" + id);
        defObj.val(msg);
        defObj.css("color", "#BEBEBE");
        txtObj.after(defObj);
    }

    txtObj.hide();
    defObj.show();

    var removeDefObj = function(){
        defObj.remove();
        txtObj.show();
        txtObj.focus();
    };

    defObj.focus(removeDefObj);

    txtObj.blur(function(){
        if(txtObj.val()==""){
            txtObj.hide();
            txtObj.after(defObj);
            defObj.focus(removeDefObj);
            defObj.show();
        }
    });

    if(txtObj.val() !=""){
        defObj.remove();
        txtObj.show();
    };
}