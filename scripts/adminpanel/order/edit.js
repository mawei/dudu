
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
		var i = 2;
		$("#add_place").click(function(){
			if(i >= 5){
				alert("最多只能添加4个卸货地址");
			}
			$("#end_place"+i+"_div").show();
			$("#end_place"+i+"_list").show();
			$("#detail_"+i).show();
			i++;

		});

		var getHandler = function(j) {
		  return function(){
		  	var name = $("#detail_name_" + j).val();
				var unit = $("#detail_unit_" + j).val();
				var number = $("#detail_number_" + j).val();
				var model = $("#detail_model_" + j).val();
				var val = $("#end_place"+j+"_detail_list").val();
				if (val != "")
				{
					val = val + ";";
				}
				if(name == "" || unit == "" || number == "")
				{
					alert("请输入完整");
					return false;
				}
				$("#end_place"+j+"_detail_list").val(val + name + "," + unit + "," + number + "," + model);
		  };
		};

		 for (var j = 1; j <=4 ; j++) {

			//var j = 1;
			$("#add_list_" + j).click(getHandler(j));	
		 }

		

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

					 end_place: {
						 validators: {
							notEmpty: {
								message: '目的地输入错误'
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

				}
			}).on('success.form.bv', function(e) {

				e.preventDefault();
				$("#dosubmit").attr("disabled","disabled");

				$.scojs_message("正在保存，请稍等...", $.scojs_message.TYPE_ERROR);
				$.ajax({
					type: "POST",
					url: is_edit?SITE_URL+"adminpanel/order/edit/"+id:SITE_URL+"adminpanel/order/add/",
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
