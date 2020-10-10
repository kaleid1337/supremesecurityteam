function login() {
	logins = 1;
	$('#loginsub').button('loading');
	u = $('#loginUser').val();
	p = $('#loginPass').val();
	$.post('js_handler.php', {logins:logins, u:u, p:p}, function(data) {
		if(data == 'empty-field') {
			$('#loginOutput').show();
			$('#loginOutput').html('<div class="alert alert-important"><i class="icon-warning-sign"></i> <span style="color: red;">Please fill in all fields!</span></div>');
			$('#loginsub').button('reset');
			ofade_time($('#loginOutput'), 3000);
		} else if(data == 'invalid-info') {
			$('#loginOutput').show();
			$('#loginOutput').html('<div class="alert alert-important"><i class="icon-warning-sign"></i> <span style="color: red;">Invalid Login!</span></div>');
			$('#loginsub').button('reset');
			ofade_time($('#loginOutput'), 3000);
		} else if(data == 'user-auth-success') {
			$('#loginOutput').show();
			$('#loginOutput').html('<div class="alert alert-success"><i class="icon-ok-sign"></i> <span style="color: green;">Login success! Redirecting...</span></div>');
			$('#loginsub').hide();
			setTimeout(function() {
				location.replace('index.php');
			}, 1500);
		}
	});
}


function ofade_time(item, time) {
	setTimeout(function() {
		item.fadeOut();
	}, time)
}

function verify_pay(item) {
	$(item).button('loading');
	user = $('#uname').val();
	pass = $('#pass').val();
	if(user == '') {
		$('#regOutput').show();
		$('#regOutput').html('<div class="alert alert-important"><i class="icon-warning-sign"></i> <span style="color: red;">Please fill in all fields!</span></div>');
		$(item).button('reset');
	}
	if(pass == '') {
		$('#regOutput').show();
		$('#regOutput').html('<div class="alert alert-important"><i class="icon-warning-sign"></i> <span style="color: red;">Please fill in all fields!</span></div>');
		$(item).button('reset');
	}
	rver = 1;
	$.post('js_handler.php', {user:user, pass:pass, rver:rver}, function(data) {
		alert(data);
		if(data == 'user-exists') {
			$('#regOutput').show();
			$('#regOutput').html('<div class="alert alert-important"><i class="icon-warning-sign"></i> <span style="color: red;">User Exists with that info!</span></div>');
			$(item).button('reset');
		} else {
			$('#regOutput').show();
			$('#regOutput').html('<div class="alert alert-success"><i class="icon-done"></i> <span style="color: red;">Continue to PayPal...</span></div>');
			$(item).hide();
			$('#ppbtn').show();
		}
	});
}
function send_attack() {
	$('#hosterror').fadeOut();
	$('#finalout').fadeOut();
	host = $('#hubIP').val();
	port = $('#hubPort').val();
	meth = $('#hubMethod').val();
	attack = 1;
	time = $('#amount').html(); // will output NUMBER sec... We will be stripping that later.
	// ALL NULL VALS:
	if(host == '') {
		$('#hosterror').fadeIn();
	} else {
		$.post('js_handler.php', {attack:attack, host:host, port:port, meth:meth, time:time}, function(data) {
			alert(data);
			switch(data) {
				case 'host-ip-error':
					$('#hosterror').fadeIn();
					break;
				case 'too-many-attacks':
					$('#finalout').fadeIn();
					$('#finalout').html('You already have an attack running!');
					break;
			}
		});
	}
}

function register() {
	$('#uerror').html('<i class="icon-exclamation-sign"></i>');
	$('#perror').html('<i class="icon-exclamation-sign"></i>');
	$('#p2error').html('<i class="icon-exclamation-sign"></i>');
	$('#eerror').html('<i class="icon-exclamation-sign"></i>');
	$('#e2error').html('<i class="icon-exclamation-sign"></i>');
	user = $('#newacct_uname').val();
	pass1 = $('#newacct_pass').val();
	pass2 = $('#newacct_pass2').val();
	email1 = $('#newacct_email').val();
	email2 = $('#newacct_email2').val();
	$('#newacct_submit').button('loading');
	regsub = 1;
	
	if(pass1 != pass2 || pass1 == '' || pass2 == '') {
		$('#perror').fadeIn();
		$('#p2error').fadeIn();
		setTimeout(function() {
			$('#perror').fadeOut();
			$('#p2error').fadeOut();
		}, 3000);
		$('#newacct_submit').button('reset');
	}
	if(user == '') {
		$('#uerror').fadeIn();
		setTimeout(function() {
			$('#uerror').fadeOut();
		}, 3000);
		$('#newacct_submit').button('reset');
	}
	if(email1 != email2 || email1 == '' || pass2 == '') {
		$('#eerror').fadeIn();
		$('#e2error').fadeIn();
		setTimeout(function() {
			$('#eerror').fadeOut();
			$('#e2error').fadeOut();
		}, 3000);
		$('#newacct_submit').button('reset');
	}
	
	if(user != '' && pass1 == pass2 && pass1 != '' && email1 == email2 && email1 != '') {
		$.post('js_handler.php', {regsub:regsub, user:user, pass1:pass1, pass2:pass2, email1:email1, email2:email2}, function(data) {
			alert(data);
			switch(data) {
				case 'user-exists':
					$('#uerror').fadeIn();
					$('#uerror').html('<i class="icon-exclamation-sign"></i> Username taken!');
					$('#newacct_submit').button('reset');
					break;
				case 'reg-success':
					$('#show_reg_success').slideDown();
					$('#newacct_submit').hide();
					setTimeout(function() {
						location.replace('index.php?p=account&a=login');
					}, 3000);
					break;
			}
			$('#newacct_submit').button('reset');
		});
	}
}

function h2ip(input, item, item2) {
	$(item2).button('loading');
	sh2ip = 1;
	$.post('js_handler.php', {sh2ip:sh2ip, input:input}, function(data) {
		$(item).val(data);
		$(item2).button('reset');
	})
}
function skype2ip(input, item, item2) {
	$(item2).button('loading');
	sk2ip = 1;
	$.post('js_handler.php', {sk2ip:sk2ip, input:input}, function(data) {
		$(item).val(data);
		$(item2).button('reset');
	})
}
function cf2ip(input, item, item2) {
	$(item2).button('loading');
	c2ip = 1;
	$.post('js_handler.php', {c2ip:c2ip, input:input}, function(data) {
		$(item).val(data);
		$(item2).button('reset');
	})
}
function xblcheck(input, item, item2) {
	$(item2).button('loading');
	xcheck = 1;
	$.post('js_handler.php', {xcheck:xcheck, input:input}, function(data) {
		$(item).val(data);
		$(item2).button('reset');
	})
}

function run_live_chat(time) {
	runlivechat = 1;
	$.post('../js_handler.php', {runlivechat:runlivechat}, function(data) {
		$('#live_chat_area').html(data);
	});
	if(time == 0) {
		setTimeout(function() {
			run_live_chat(0);
		}, 1000);
	}
}
function post_live_chat() {
	msg = $('#live_chat_msg').val();
	if(msg == '') {
		alert('Message may not be empty!');
	}
	$('#live_chat_msg').val('');
	postlivechat = 1;
	$.post('js_handler.php', {postlivechat:postlivechat, msg:msg}, function(data) {
		run_live_chat(1);
	});
}
$("#live_chat_msg").keyup(function(event){
    if(event.keyCode == 13){
        post_live_chat();
    }
});
function chpass(item) {
	$(item).button('loading');
	chpass = 1;
	cp1 = $('#chpass_1').val();
	cp2 = $('#chpass_2').val();
	if($('#chpass_1').val() == $('#chpass_2').val()) {
		if($('#chpass_1').val() == '' || $('#chpass_2').val() == '') {
			alert('Passwords may not be empty!');
			$(item).button('reset');
		} else {
			$.post('js_handler.php', {chpass:chpass, cp1:cp1, cp2:cp2}, function(data) {
				if(data == 'success') {
					alert('Password changed successfully! Logging out...');
					location.replace('index.php?page=logout');
				}
			});
		}
	} else {
		alert('Passwords do not match!');
		$(item).button('reset');
	}
}
function submitTicket() {
	
}
function updateTicket() {
	
}