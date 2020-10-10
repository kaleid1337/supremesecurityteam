function run_admin_panel(time) {
  runadminpanel = 1;
  $.post('js_handler.php', {
    runadminpanel: runadminpanel
  }, function(data) {
    $('#live_admin_panel').html(data);
  });
  if (time == 0) {
    setTimeout(function() {
      run_admin_panel(0);
    }, 1000);
  }
}

function run_page(time) {
  runpage = 1;
  $.post('js_handler1.php', {
    runpage: runpage
  }, function(data) {
    $('#live_page').html(data);
  });
  if (time == 0) {
    setTimeout(function() {
      run_page(0);
    }, 1000);
  }
}

function run_members(time) {
  runmembers = 1;
  $.post('https://omegastresser.com/Administrator/js_handler3.php', {
    runmembers: runmembers
  }, function(data) {
    $('#live_members').html(data);
  });
  if (time == 0) {
    setTimeout(function() {
      run_members(0);
    }, 1000);
  }
}

function run_servers(time) {
  runservers = 1;
  $.post('js_handler.php', {
    runservers: runservers
  }, function(data) {
    $('#live_servers').html(data);
  });
  if (time == 0) {
    setTimeout(function() {
      run_servers(0);
    }, 1000);
  }
}

function run_attacks(time) {
  runattacks = 1;
  $.post('js_handler-2.php', {
    runattacks: runattacks
  }, function(data) {
    $('#live_attacks').html(data);
  });
  if (time == 0) {
    setTimeout(function() {
      run_attacks(0);
      $('#startbutton').html(data);
    }, 1000);
  }
}
