/**
 * @Project NUKEVIET 4.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2015 PCD-GROUP. All rights reserved
 * @Update to 4.x webvang (hoang.nguyen@webvang.vn)
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 29 May 2015 07:49:53 GMT
 */
 
 
// function checkall end uncheckall
function clickcheckall(){
	$('#checkall').click(function(){
		if ( $(this).attr('checked') ){
			$('input:checkbox').each(function(){
				$(this).attr('checked','checked');
			});
		}else {
			$('input:checkbox').each(function(){
			$(this).removeAttr('checked');
			});
		}
	});
}

//change active
function ChangeActiveCat(idobject,catid,action){
	var value = $(idobject).val();
	$(idobject).attr('disabled', 'disabled');
	$.ajax({	
		type: 'POST',
		url: script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cat_action&ac='+action,
		data:'catid='+catid + '&value='+value,
		success: function(data){
			$(idobject).removeAttr('disabled');
			if (data!='')
			{
				window.location = script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cat&parentid='+data
			}
		}
	});
}
//change active room
function ChangeActiveRoom(idobject,roomid,action){
	var value = $(idobject).val();
	$(idobject).attr('disabled', 'disabled');
	$.ajax({	
		type: 'POST',
		url: script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=room_action&ac='+action,
		data:'roomid='+roomid + '&value='+value,
		success: function(data){
			$(idobject).removeAttr('disabled');
			if (data!='')
			{
				window.location = script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=room&parentid='+data
			}
		}
	});
}
//change active field
function ChangeActiveField(idobject,roomid,action){
	var value = $(idobject).val();
	$(idobject).attr('disabled', 'disabled');
	$.ajax({	
		type: 'POST',
		url: script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=field_action&ac='+action,
		data:'fieldid='+roomid + '&value='+value,
		success: function(data){
			$(idobject).removeAttr('disabled');
			if (data!='')
			{
				window.location = script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=field&parentid='+data
			}
		}
	});
}
//change active Organ
function ChangeActiveOrgan(idobject,organid,action){
	var value = $(idobject).val();
	$(idobject).attr('disabled', 'disabled');
	$.ajax({	
		type: 'POST',
		url: script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=organ_action&ac='+action,
		data:'organid='+organid + '&value='+value,
		success: function(data){
			$(idobject).removeAttr('disabled');
			if (data!='')
			{
				window.location = script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=organ&parentid='+data
			}
		}
	});
}
function get_alias() {
	var title = strip_tags(document.getElementById('idtitle').value);
	if (title != '') {
		$.ajax({	
			type: 'POST',
			url: script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=alias&title=' + encodeURIComponent(title),
			data:'',
			success: function(data){
				if (data != "") {
					document.getElementById('idalias').value = data;
				} else {
					document.getElementById('idalias').value = '';
				}
			}
		});
	}
	return false;
}
function search_rows()
{
	var catid = $('#catid').val();
	var per_page = $('#idper_page').val();
	var q = $('#idq').val();
	window.location = script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=main&per_page='+per_page+'&catid='+catid+'&q='+encodeURIComponent(q);
}
function delete_one(class_name,lang_confirm,url_back){
	$('a.'+class_name).click(function(event){
		event.preventDefault();
		if (confirm(lang_confirm))
		{
			var href= $(this).attr('href');
			$.ajax({	
				type: 'POST',
				url: href,
				data:'',
				success: function(data){				
					alert(data);
					if (url_back !='') {
						window.location=url_back;
					}
				}
			});
		}
	});
}

// delete all items select checkbox
function delete_all(filelist,class_name,lang_confirm,lang_error,url_del,url_back){
	$('a.'+class_name).click(function(event){
		event.preventDefault();
		var listall = [];
		$('input.'+filelist+':checked').each(function(){
			listall.push($(this).val());
		});
		if (listall.length<1){
			alert(lang_error);
			return false;
		}
		if (confirm(lang_confirm))
		{
			$.ajax({	
				type: 'POST',
				url: url_del,
				data:'listall='+listall,
				success: function(data){	
					window.location=url_back;
				}
			});
		}
	});
}
function content_submit(status)
{
	$('#idstatus').val(status);
	$('#idcontent').submit();
}
//autocomplete function

function findValue(li) {
	if (li == null)
		return alert("No match!");

	if (!!li.extra)
		var sValue = li.extra[0];

	else
		var sValue = li.selectValue;
	return sValue;
}

// ---------------------------------------

function selectItem(li) {
	sValue = findValue(li);
}

// ---------------------------------------

function formatItem(row) {
	return row[0] + " (" + row[1] + ")";
}

//////
 
 $(document).ready(function(){
	// Laws content
	$("#select-file-post").click(function() {
		var area = "filepath";
		var alt = "doc_name";
		var path = CFG.uploads_dir_user;
		var currentpath = CFG.upload_current;
		var type = "file";
		nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&alt=" + alt + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
		return false;
	});
});
 