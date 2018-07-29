jQuery(document).ready(function ($) {
	$.ajaxSettings.async = false;
	var weixinArr = [];
	$.getJSON("/api/weixin_code.json", function (data) {
		$.each(data, function (infoIndex, info) {
			weixinArr.push(info);
		})
	});

	var weixinArrLength = weixinArr.length;

	var randNum = Math.floor(Math.random() * weixinArrLength);
	//如果没有获取到cookie  则生成cookie
	if (getCookie('weixin')) {

	} else {
		setCookie("weixin", weixinArr[randNum], "d365");
		//$('#addWeixin').html(getCookie('weixin'));
		//$('#weixin').html(getCookie('weixin'));
	}

	//$('#addWeixin').html(getCookie('weixin'));
	$('.weixin_code').html(getCookie('weixin'));
});


jQuery(document).ready(function ($) {

	function removeQcode() {
		setTimeout(function () { $('.qcode').remove(); }, 4000)
	}
	$('.spayBtn li').each(function () {
		$(this).click(function () {
			$(this).addClass('active').siblings().removeClass('active');
			payType = $(this).attr('paytype');
			$('.spayerC').hide();
			$('.spayerC[data-pay|="' + payType + '"]').show();
			if (payType == 'zfb') {
				getQRCode('ali');
			} else if (payType == 'wx') {
				getQRCode('wx');
			}
		});
	});
	if ($('#sPay').length) {
		$('.bins_btn,#btns li').click(function () {
			$('html, body').animate({
				scrollTop: $('#sPay').offset().top
			}, 1000);
		});
	}

	//得到支付的二维码
	function getQRCode(payType) {
		//如果没有设置订单cookie 设置订单cookie 订单号、订单支付类型(V信、支付宝)、订单时间
		var order_num = $('#ordernumber').html();
		//var xing = $('.spayUserName').html();
		//var gender = $('.spayUserSex').html();
		//var birthtimeStr = $('.spayUserBirth').html();
		//var birthtimeNongliStr = $('.spayUserLunar').html();
		//var bornStatus = $('.bornStatus').html();
		var software_name = "宝宝取名 联系微信 " + getCookie('weixin');

		//设置页面订单号显示
		$.post('/api/pay/pay_pc.php', { order_num: order_num, payType: payType, software_price: 29.8, software_name: software_name }, function (re) {
			if (re == 'fail') {
				alert('数据写入失败');
				return false;
			} else {
				if (re == 'paid') {
					window.location.href = 'quming/quminglist.php?order_num=' + order_num;
				}
				setCookie('order_num', getCookie('order_num') + '-' + order_num, "d365");
				$("#" + payType).empty(); // 清空当前二维码
				var qrcode = new QRCode(document.getElementById(payType), {
					url: re,
					width: 128,
					height: 128,
					colorDark: "#000000",
					colorLight: "#ffffff",
					correctLevel: QRCode.CorrectLevel.H
				});
				qrcode.clear(); // clear the code.
				qrcode.makeCode(re); // make another code.
				//进行轮训查询支付状态 每隔3秒钟执行一次
				window.setInterval(checkOrderStatus, 5000);
			}
		})
	}

	getQRCode('wx');


	//进行轮训查询支付状态
	function checkOrderStatus() {
		//var order_num = getCookie('order_num');
		var order_num = $('#ordernumber').html();
		$.post('/api/wap_check/checkOrderStatus.php', { order_num: order_num }, function (re) {
			//判断是否已经支付
			if (re == 3) {
				//获取有没有跳转过的cookie值href_paid是否和当前的order_num相同
				if (getCookie('href_paid') == order_num) {

				} else {
					setCookie("href_paid", order_num, "d365");
					window.location.href = 'quming/quminglist.php?order_num=' + order_num;
				}
			} else if (re == 'fail') {
				//var xing = $('.spayUserName').html();
				if (getCookie('paid_alert') == 1) {

				} else {
					alert('支付已完成，请添加客服微信 ' + getCookie('weixin') + ' 获取姓名详情');
					setCookie("paid_alert", 1, "s300");
				}

			}
		})
	}
});