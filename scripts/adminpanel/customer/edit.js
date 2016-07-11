	function uploadOneFile(inputId,w,h,iscallback){
		if(!w) w=screen.width-4;
		if(!h) h=screen.height-95;
		if(!iscallback)iscallback=0;
		var window_url = SITE_URL+'adminpanel//customer/upload/';
		$.extDialogFrame(window_url+'1/company_license/'+inputId+'/'+iscallback,{model:true,width:w,height:h,title:'请上传...',buttons:null});
	}
	function getWuliu_license(v,s,w,h){
		$("#wuliu_license").val(v);
		$("#wuliu_license_SRC").attr("src",SITE_URL+"upload/"+v);
		$("#dialog" ).dialog();$("#dialog" ).dialog("close");
	}
	function getCompany_license(v,s,w,h){
		$("#company_license").val(v);
		$("#company_license_SRC").attr("src",SITE_URL+"upload/"+v);
		$("#dialog" ).dialog();$("#dialog" ).dialog("close");
	}

	define(function (require) {
	var $ = require('jquery');
	var aci = require('aci');
	require('bootstrap');
	require('bootstrapValidator');
	require('message');
	require('jquery-ui');
	require('jquery-ui-dialog-extend');
	require('datetimepicker');

		$(function () {
	    $.datepicker.regional['zh-CN'] = {
                closeText: '关闭',
                prevText: '<上月',
                nextText: '下月>',
                currentText: '今天',
                monthNames: ['一月','二月','三月','四月','五月','六月',
                '七月','八月','九月','十月','十一月','十二月'],
                monthNamesShort: ['一','二','三','四','五','六',
                '七','八','九','十','十一','十二'],
                dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
                dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
                dayNamesMin: ['日','一','二','三','四','五','六'],
                weekHeader: '周',
                dateFormat: 'yy-mm-dd',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: true,
                yearSuffix: '年'};
     $.datepicker.setDefaults($.datepicker.regional['zh-CN']);

	$(".datepicker").datepicker();
	$(".datetimepicker").datetimepicker({lang:'ch'});

		$("#wuliu_license_a").click(function(){
			uploadOneFile('wuliu_license',550,350,1)
		});
		$("#wuliu_license_b").click(function(){
			uploadOneFile('wuliu_license',550,350,1)
		});
		$("#company_license_a").click(function(){
			uploadOneFile('company_license',550,350,1)
		});
		$("#company_license_b").click(function(){
			uploadOneFile('company_license',550,350,1)
		});
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

					o_password: {
		                validators: {
		                    notEmpty: {
		                        message: '密码输入错误'
		                    },
		                    identical: {
		                        field: 'password',
		                        message: '两次密码不相符'
		                    }
		                }
		            },
		            password: {
		                validators: {
		                    notEmpty: {
		                        message: '确认密码不能为空'
		                    },
		                    identical: {
		                        field: 'o_password',
		                        message: '两次密码不相符'
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
					url: is_edit?SITE_URL+"adminpanel/customer/edit/"+id:SITE_URL+"adminpanel/customer/add/",
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
