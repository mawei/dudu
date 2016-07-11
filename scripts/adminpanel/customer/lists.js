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
					window.location.href= SITE_URL+ "adminpanel/customer/delete_one/"+v;
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
					 customer_type: {
						 validators: {
							notEmpty: {
								message: '货主类型输入错误'
							}
						 }
					 },
					 telephone: {
						 validators: {
							notEmpty: {
								message: '手机号码输入错误'
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
					 name: {
						 validators: {
							notEmpty: {
								message: '姓名输入错误'
							}
						 }
					 },
					 identity: {
						 validators: {
							notEmpty: {
								message: '身份证号输入错误'
							}
						 }
					 },
					 wuliu_name: {
						 validators: {
							notEmpty: {
								message: '物流公司名称输入错误'
							}
						 }
					 },
					 wuliu_license: {
						 validators: {
							notEmpty: {
								message: '物流公司营业执照输入错误'
							}
						 }
					 },
					 company_name: {
						 validators: {
							notEmpty: {
								message: '企业名称输入错误'
							}
						 }
					 },
					 company_license: {
						 validators: {
							notEmpty: {
								message: '营业执照输入错误'
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
					 last_login: {
						 validators: {
							notEmpty: {
								message: '最后登陆输入错误'
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
					url: edit?SITE_URL+"adminpanel/customer/edit/"+id:SITE_URL+"adminpanel/customer/add/",
					data:  $("#validateform").serialize(),
					success:function(response){
						var dataObj=jQuery.parseJSON(response);
						if(dataObj.status)
						{
							$.scojs_message('操作成功,3秒后将返回列表页...', $.scojs_message.TYPE_OK);
							aci.GoUrl(SITE_URL+'adminpanel/customer/',1);
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
