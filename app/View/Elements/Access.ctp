<script type="text/javascript"><!--
$(function(){
	$(".oinput").click(function(){
		var oid = $(this).attr('oid');
		var pid = $(this).attr('id').replace(eval("/"+'_'+oid+"$/"),'');
		if($(this).attr('checked')=='checked'){
			$("#"+pid).attr('checked','checked');
		}
	})
})

function right_check_all(id){
	var name = $("#"+id).attr('name');
	if($("#"+id).attr('checked')=='checked'){
		$("input[name^='"+name+"']").attr("checked","checked");
	}else{
		$("input[name^='"+name+"']").attr("checked",false);
		
		
	}
}
</script>