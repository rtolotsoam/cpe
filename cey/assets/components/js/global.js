function click_tab(tab, btn_id){
	var tb =  "lien" + tab;

	$('.close').trigger('click');

	if (!(typeof(click_tab_supplement) =="undefined")) {
			click_tab_supplement(tab, btn_id);
	}
	try {
		document.getElementById(tb).click();
	}
	catch(e) {}
		
	//add_activity(tp[tab],1,tab);
	his(tab);
}	

function his(itab) {

	var tb = "lien"+itab;

	console.log(tb);	
	
	sUrlSav = s_url_acc + "/hstaj/"+itab;
	$.ajax({
		url: sUrlSav                
	});
}

function abhis() {	

	if ($('#fin_session_prcs49').hasClass('hidden')){
        fin_session_prcs49.classList.remove('hidden');
		fin_session_prcs49.classList.add("btn");
		fin_session_prcs49.classList.add("btn-info");
		fin_session_prcs49.classList.add("pull-right");
    }

    if ($('#suite_session_prcs49').hasClass('hidden')){
        suite_session_prcs49.classList.remove('hidden');
		suite_session_prcs49.classList.add("btn");
		suite_session_prcs49.classList.add("btn-info");
		suite_session_prcs49.classList.add("pull-right");
    }

    if ($('#suite_session_prcs8').hasClass('hidden')){
        suite_session_prcs8.classList.remove('hidden');
		suite_session_prcs8.classList.add("btn");
		suite_session_prcs8.classList.add("btn-info");
		suite_session_prcs8.classList.add("pull-right");
    }

    if ($('#fin_session_prcs8').hasClass('hidden')){
        fin_session_prcs8.classList.remove('hidden');
		fin_session_prcs8.classList.add("btn");
		fin_session_prcs8.classList.add("btn-info");
		fin_session_prcs8.classList.add("pull-right");
    }

	sUrlSav = s_url_acc + "/hstab";
	$.ajax({
		url: sUrlSav
		,"dataType" : "json"
		,success : function (data) {
			if (data.last_process>0) {
				id_tab = "lien" + data.last_process;
				try {
					document.getElementById(id_tab).click();
					abort_activity();
				}
				catch(e) {}
			}
			else {
				id_tab = "lien" + first_proc;
				try {
					document.getElementById(id_tab).click();
					abort_activity();
				}
				catch(e) {}
			}
		}
	});
}
	

function debut_load() {	

	sUrlDeb = s_url_acc + "/last_action";

	$.ajax({
		url: sUrlDeb
		,"dataType" : "json"
		,success : function (data) {
			id_tab = "lien" + data.last_id;
			enchainement = data.enchainement;
			statut = data.etat;
			tbe = enchainement.split(";");
			tbs = statut.split(";");
			document.getElementById(id_tab).click();

			for (var i=0;i<tbe.length -1;i++) {
				add_activity(tp[tbe[i]], tbs[i], data.last_id);
			}
		}
	});
	

}

/*
function add_activity(activity_text,stat, tab) {	
	default_stat = "action-ok";
	default_style = "";

	lien = "#tab"+tab;
	lien2 = "lien"+tab;
	
	if (stat==0) {default_stat = "action-ab"; default_style=" style=\"color:red;\"";}
	s_pattern = "<li class=\"" + default_stat + "\"><a href=\""+lien+"\" data-toggle=\"tab\" id=\""+lien2+"\"><i class=\" fa fa-caret-square-o-right\"></i><span "+ default_style + ">" + activity_text + "</span></a></li>";
	$("#activities").append(s_pattern);
}*/

function abort_activity () {
	lst = document.querySelectorAll("ul#activities li.action-ok");
	if (lst.length>0) {
		lst[lst.length-1].querySelector("a span").style.color = "#FF0000";
		lst[lst.length-1].className =  "action-ab";
	}
}


function charge_entres(){

	var entre = document.getElementById("entre").value;
	var canal = document.getElementById("canal").value;


	var btn_data = {
		id_entre : entre,
		canal : canal,
		ajax : '1'
	};
	
    $("#spin").show();
	$.ajax({
		url: acc_cat,
		type: 'POST',
		data: btn_data,
		success: function(data) {
			$("#spin").hide();
			window.location.href = data;	
		}
	});
	
	return true;
}


function supprimer_procs(id, type_cat){

	var obj = 'cat_'+id;
	var obj1 = 'trait_'+id;
	var obj2 = 'op_'+id;

	if(type_cat == 'trait'){
		
		if(document.getElementById(obj).checked){

			var id_cat = document.getElementById(obj).value;

			var pont_suppr = {
				id_cat : id_cat,
				id_proc : id,
				ajax : 'traitement'
			};

			console.log(id_cat);

		}

	}else if(type_cat == 'op'){

		if(document.getElementById(obj).checked && document.getElementById(obj1).checked){

			var id_cat = document.getElementById(obj).value;
			var id_trait = document.getElementById(obj1).value;

			var pont_suppr = {
				id_cat : id_cat,
				id_trait : id_trait,
				id_proc : id,
				ajax : 'operation'
			};

			console.log(id_cat);
			console.log(id_trait);

		}else if(document.getElementById(obj).checked){
			var id_cat = document.getElementById(obj).value;

			var pont_suppr = {
				id_cat : id_cat,
				id_proc : id,
				ajax : 'operation'
			};

			console.log(id_cat);

		}else if(document.getElementById(obj1).checked){

			var id_trait = document.getElementById(obj1).value;

			var pont_suppr = {
				id_trait : id_trait,
				id_proc : id,
				ajax : 'operation'
			};

			console.log(id_trait);
		}

	}else if(type_cat == 'act'){

		if(document.getElementById(obj).checked && document.getElementById(obj1).checked && document.getElementById(obj2).checked){

			var id_cat = document.getElementById(obj).value;
			var id_trait = document.getElementById(obj1).value;
			var id_op = document.getElementById(obj2).value;

			var pont_suppr = {
				id_cat : id_cat,
				id_trait : id_trait,
				id_op : id_op,
				id_proc : id,
				ajax : 'action'
			};

			console.log(id_cat);
			console.log(id_trait);
			console.log(id_op);
		
		}else if(document.getElementById(obj).checked && document.getElementById(obj1).checked){

			var id_cat = document.getElementById(obj).value;
			var id_trait = document.getElementById(obj1).value;


			var pont_suppr = {
				id_cat : id_cat,
				id_trait : id_trait,
				id_proc : id,
				ajax : 'action'
			};

			console.log(id_cat);
			console.log(id_trait);

		}else if(document.getElementById(obj).checked && document.getElementById(obj2).checked){

			var id_cat = document.getElementById(obj).value;
			var id_op = document.getElementById(obj2).value;

			var pont_suppr = {
				id_cat : id_cat,
				id_op : id_op,
				id_proc : id,
				ajax : 'action'
			};

			console.log(id_cat);
			console.log(id_op);

		}else if(document.getElementById(obj1).checked && document.getElementById(obj2).checked){

			var id_trait = document.getElementById(obj1).value;
			var id_op = document.getElementById(obj2).value;

			var pont_suppr = {
				id_trait : id_trait,
				id_op : id_op,
				id_proc : id,
				ajax : 'action'
			};

			console.log(id_trait);
			console.log(id_op);

		}else if(document.getElementById(obj2).checked){
			
			var id_op = document.getElementById(obj2).value;

			var pont_suppr = {
				id_op : id_op,
				id_proc : id,
				ajax : 'action'
			};

			console.log(id_op);

		}else if(document.getElementById(obj1).checked){
			
			var id_trait = document.getElementById(obj1).value;

			var pont_suppr = {
				id_trait : id_trait,
				id_proc : id,
				ajax : 'action'
			};
			
			console.log(id_trait);

		}else if(document.getElementById(obj).checked){

			var id_cat = document.getElementById(obj).value;

			var pont_suppr = {
				id_cat : id_cat,
				id_proc : id,
				ajax : 'action'
			};

			console.log(id_cat);
		}

	}

		$.ajax({
			url: url_suppr_proc,
			type: 'POST',
			data: pont_suppr,
			success: function(data) {
				window.location.href = data;
			}
		});

		return true;


}


function charge_popup_direct(id_proc){

	var obj = 'popup_'+id_proc;
	var obj2 = '.popup_foot_'+id_proc;

	console.log(id_proc);


	$(obj2).hide();

	document.getElementById(obj).click();


}