	define(function (require) {
	    var $ = require('jquery');
	    var aci = require('aci');
	    require('bootstrap');
	    require('bootstrapValidator');

		$(function () {
			$("#reverseBtn").click(function(){
				aci.ReverseChecked('pid[]')
			});

			$("#deleteBtn").click(function(){
				var _arr = aci.GetCheckboxValue("pid[]");
				if(_arr.length==0)
				{
					alert("请先勾选明细");
					return false;
				}
				if(confirm('确定要删除吗?'))
				{
					$("#form_list").submit();
				}
			});
        
			 $(".delete-btn").click(function(){
				var v = $(this).val();
				if(confirm('确定要删除吗?'))
				{
					window.location.href= SITE_URL+ "adminpanel/driver/delete_one/"+v;
				}
			});
            
		$(".datetimepicker").datetimepicker({lang:'ch'});
		$(".datetimepicker").datepicker();
            $('#validateform').bootstrapValidator({
				message: '输入框不能为空',
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					 telephone: {
						 validators: {
							notEmpty: {
								message: '手机号码输入错误'
							}
						 }
					 },
					 truck_type: {
						 validators: {
							notEmpty: {
								message: '货车类型输入错误'
							}
						 }
					 },
					 truck_size: {
						 validators: {
							notEmpty: {
								message: '车长/车重输入错误'
							}
						 }
					 },
					 password: {
						 validators: {
							notEmpty: {
								message: '密码输入错误'
							}
						 }
					 },
					 truck_head_photo: {
						 validators: {
							notEmpty: {
								message: '车头照输入错误'
							}
						 }
					 },
					 drive_license: {
						 validators: {
							notEmpty: {
								message: '车辆驾驶证输入错误'
							}
						 }
					 },
					 truck_full_photo: {
						 validators: {
							notEmpty: {
								message: '全车照输入错误'
							}
						 }
					 },
					 last_login: {
						 validators: {
							notEmpty: {
								message: '最后一次登陆输入错误'
							}
						 }
					 },
					 status: {
						 validators: {
							notEmpty: {
								message: '用户状态输入错误'
							}
						 }
					 },
					 online_status: {
						 validators: {
							notEmpty: {
								message: '在线状态输入错误'
							}
						 }
					 },
					 latitude: {
						 validators: {
							notEmpty: {
								message: '纬度输入错误'
							}
						 }
					 },
					 longitude: {
						 validators: {
							notEmpty: {
								message: '经度输入错误'
							}
						 }
					 },
				}
			}).on('success.form.bv', function(e) {
				
				e.preventDefault();
				$("#dosubmit").attr("disabled","disabled");
				
				$.scojs_message("正在保存，请稍等...", $.scojs_message.TYPE_ERROR);
				$.ajax({
					type: "POST",
					url: edit?SITE_URL+"adminpanel/driver/edit/"+id:SITE_URL+"adminpanel/driver/add/",
					data:  $("#validateform").serialize(),
					success:function(response){
						var dataObj=jQuery.parseJSON(response);
						if(dataObj.status)
						{
							$.scojs_message('操作成功,3秒后将返回列表页...', $.scojs_message.TYPE_OK);
							aci.GoUrl(SITE_URL+'adminpanel/driver/',1);
						}else
						{
							$.scojs_message(dataObj.tips, $.scojs_message.TYPE_ERROR);
							$("#dosubmit").removeAttr("disabled");
						}
					},
					error: function (request, status, error) {
						$.scojs_message(request.responseText, $.scojs_message.TYPE_ERROR);
						$("#dosubmit").removeAttr("disabled");
					}                  
				});
			
			}).on('error.form.bv',function(e){ $.scojs_message('带*号不能为空', $.scojs_message.TYPE_ERROR);$("#dosubmit").removeAttr("disabled");});
            
        });
});
