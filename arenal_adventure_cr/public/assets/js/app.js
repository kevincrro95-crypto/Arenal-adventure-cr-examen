document.querySelectorAll('input[type=date]').forEach(function(input){ input.min=new Date().toISOString().split('T')[0]; });
setTimeout(function(){document.querySelectorAll('.alert').forEach(function(a){a.style.display='none';});},5000);
