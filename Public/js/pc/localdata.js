(function(){ 
	var dataread={};
	var init=function(){
		if(localStorage['orders']!==undefined && localStorage['orders']!==""){
			dataread=JSON.parse(localStorage['orders']);
		}
	}
	var set_data=function(key,val,fullname){
		if(dataread[key]===undefined){
			dataread[key]={};
		}
		dataread[key][val]=fullname;
	}
	var save_data=function(){
		localStorage['orders']=JSON.stringify(dataread);
	}

	init();

	set_data($('#ordernumber').attr('types'),$('#ordernumber').text(),$('#fullname').text());

	save_data();
	
})()