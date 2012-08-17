$(function() {
	$("#person, #with").autocomplete({
		source: function(request, response) {
			var term = request.term.toLowerCase();
			var hits = [];
			$(persons).each(function(index, p) {
				console.log(p.toLowerCase().substring(0, term.length));
				if(p.toLowerCase().substring(0, term.length) == term) {
					hits.push(p);
				}
			});
			response(hits);
		},
		autoFocus: true,
		delay: 0
	});

	$("#store").autocomplete({
		source: "backend.php?action=stores",
		minLength: 1,
		autoFocus: true,
		delay: 100

	});

	$(".two_input").keyup(function() {
		var items = $("#add input");
		var index = items.index(this);
		var next = items[index+1];
		var prev_val = $(this).attr("data-prev");
		$(this).attr("data-prev",$(this).val());
		if(prev_val != $(this).val() && $(this).val().length == 2) {
			next.focus();
			next.select();
		}
	})

	$("#year").keyup(function() {
		var items = $("#add input");
		var index = items.index(this);
		var next = items[index+1];
		var prev_val = $(this).attr("data-prev");
		$(this).attr("data-prev",$(this).val());
		if(prev_val != $(this).val() && $(this).val().length == 4) {
			next.focus();
			next.select();
		}
	})

	$("#add").submit(function(event) {
		$("#error").fadeOut();
		$.post("backend.php", {
			action: 'add', 
			data: {
				person: $("#person").val(),
				store: $("#store").val(),
				date: $("#year").val()+"-"+$("#month").val()+"-"+$("#day").val(),
				sum: $("#sum").val(),
				with: $("#with").val()
			}
		}, function(data) {
			if($.isPlainObject(data) && data.status == 1) {
				$("#error").html(data.msg);
				$("#error").fadeIn('slow').delay(5000).fadeOut('slow');
			} else {
				$("#purchases").prepend(data);
				$("#purchases tr:first").fadeIn('slow');
				$("#person").focus();
				$("#person").select();
			}
		});
		return false
	});

	$(".delete_row").live('click',function(event) {
		if(!confirm("Radera inköpet?"))
			return false;
		var row = $(this).closest('.purchase_row');
		$.post("backend.php", {
			action: 'delete', 
			id: $(this).attr("data-id")
		}, function(data) {
			if(data.status == 1) {
				$("#error").html(data.msg);
				$("#error").fadeIn('slow').delay(5000).fadeOut('slow');
			} else {
				$("#msg").html(data.msg);
				$("#msg").fadeIn('slow').delay(5000).fadeOut('slow');
				row.fadeOut();
			}
		});
		return false
	});
});
