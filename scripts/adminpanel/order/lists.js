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
					window.location.href= SITE_URL+ "adminpanel/order/delete_one/"+v;
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
					 customer_id: {
						 validators: {
							notEmpty: {
								message: '货主输入错误'
							}
						 }
					 },
					 start_place: {
						 validators: {
							notEmpty: {
								message: '出发地输入错误'
							}
						 }
					 },
					 start_place_latitude: {
						 validators: {
							notEmpty: {
								message: '起始点纬度输入错误'
							}
						 }
					 },
					 start_place_longitude: {
						 validators: {
							notEmpty: {
								message: '起始点经度输入错误'
							}
						 }
					 },
					 end_place: {
						 validators: {
							notEmpty: {
								message: '目的地输入错误'
							}
						 }
					 },
					 end_place_latitude: {
						 validators: {
							notEmpty: {
								message: '目的地纬度输入错误'
							}
						 }
					 },
					 end_place_longitude: {
						 validators: {
							notEmpty: {
								message: '目的地经度输入错误'
							}
						 }
					 },
					 start_time: {
						 validators: {
							notEmpty: {
								message: '出发时间输入错误'
							}
						 }
					 },
					 truck_type: {
						 validators: {
							notEmpty: {
								message: '车型输入错误'
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
					 charge: {
						 validators: {
							notEmpty: {
								message: '出价输入错误'
							}
						 }
					 },
					 weight: {
						 validators: {
							notEmpty: {
								message: '重量输入错误'
							}
						 }
					 },
					 infomation_charge: {
						 validators: {
							notEmpty: {
								message: '信息费输入错误'
							}
						 }
					 },
					 driver_id: {
						 validators: {
							notEmpty: {
								message: '接单司机输入错误'
							}
						 }
					 },
					 status: {
						 validators: {
							notEmpty: {
								message: '状态输入错误'
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
					url: edit?SITE_URL+"adminpanel/order/edit/"+id:SITE_URL+"adminpanel/order/add/",
					data:  $("#validateform").serialize(),
					success:function(response){
						var dataObj=jQuery.parseJSON(response);
						if(dataObj.status)
						{
							$.scojs_message('操作成功,3秒后将返回列表页...', $.scojs_message.TYPE_OK);
							aci.GoUrl(SITE_URL+'adminpanel/order/',1);
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
