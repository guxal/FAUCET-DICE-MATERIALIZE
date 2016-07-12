	var form1=document.form1;
	var form2=document.form2;
  var form3=document.form3;
	var form5=document.form5;
	var form6=document.form6;


  form1.onsubmit=function(){
	  var clave=form1.clave;
    var bandera=true;
    if(clave.value.length<8||clave.value.length>16) bandera=false;
    if(!bandera) alert("longitud de contraseña incorrecto");
    return bandera;
	};
  
  form2.onsubmit=function(){
    var clave1=form2.clave;
    var clave2=form2.clave2;
    var user1=form2.usuario;
    var user2=form2.usuario2;
    var bandera=true;
    
    if(clave1.value!=clave2.value) bandera = false;
    if(user1.value!=user2.value) bandera = false;
    if(clave1.value.length<8||clave1.value.length>16) bandera = false;
    if(!bandera){
      alert("verifique sus datos la contraseña debe tener entre 8 y 16 caracteres");
    }
    return bandera;
  };
	form3.onsubmit=function(){
	
	};

	
	form6.onsubmit=function(){
		alert("enviamos la recuperacion");
		var clave1=form6.clave1;
		var clave2=form6.clave2;
		var bandera=true;
		
		if(clave1.value!=clave2.value) bandera=false;
		if(clave1.value.length<8||clave1.value.length>16) bandera=false;
		
		if(!bandera) alert("datos erroneos la contraseña debe tener entre 8 y 16 caracteres");
		return bandera;
	};
