@extends('layouts.app')
@section('title', "KEYPASS")
@push('head')
<style>
.event {
	float: left;
	width: 65%;
	clear: left;
}
#target {
	float: right;
	width: 125px;
	padding: 0px 10px 10px;
	background: #E6E2AE;
	border: 1px solid #333;
}
#monitor {
	height: 350px;
	overflow: hidden;
	padding: 10px 10px 10px 10px;
	position: absolute;
	font-size: 1em;
	width: 180px;
	background-color: rgba(255,211,224,.5);
	-webkit-box-shadow: 1px 1px 2px rgba(0,0,0,.75);
	-moz-box-shadow: 1px 1px 2px rgba(0,0,0,.75);
	box-shadow: 1px 1px 2px rgba(0,0,0,.75);
	left: 0px;
	top: 110px;
        float: left;
}
#monitor h2 {
    font-size: 80%;
}
#monitor h2 small {
	font-size: 50%;
	display: inline-block;
	padding: 5px;
}
#monitor h2 small:hover {
	background-color: rgb(255,255,204);
	color: black;
	text-shadow: 1px 1px 2px rgba(255,255,255,.75);
}
#monitor p {
	font-size: 60%;
	margin: 0;
	padding: 0;
}
#monitorResults {
	margin-top:5px;
}
</style>
<script src="jquery-ui.js"></script>
<script>
$(document).ready(function () {
var eventsBound=false;
var mouseMoveBound=true;												 

$('#monitor h2 small').wrap('<a href="#"></a>');
$('#monitor h2').click(function(evt) {
	$('#monitorResults').html('');
	evt.stopPropagation();												
});
var events=['click',
			'dblclick',
			'mouseover',
			'mouseout',
			'mousemove',
			'mousedown',
			'mouseup',
			'keyup',
			'keydown',
			'keypress',
			'focus',
			'blur'
			];

var winEvents=['load',
			   'resize',
			   'scroll'
			 	];

$('#framei').click(function() {
	if ($(this).val()=='start') {
		$(this).val('stop');		
		bindEvents();
		$('#eventState').text('(active)');
	} else {
		$(this).val('start');		
		unBindEvents();
		$('#eventState').text('(disabled)');
	}
});
		
var unBindEvents = function() {
	for (var i=0;i<events.length; i++) {
	$(document).off(events[i]);
	$('*:not("#monitor h2, #button")').off(events[i]);
	}
	for (var j=0;j<winEvents.length; j++) {
	$(window).off(winEvents[j]);
	}
	eventsBound=false;
}


var bindEvents= function() {

	eventsBound = true; 
	
	
	$('#prop, #noProp').on('click',function(evt) {
		var idName = $(this).attr('id');
		$('#' + idName + 'Elems').text('1');
		$('#' + idName + 'Tags').text(this.tagName);
		handle($('#click'),evt,this);
		if (idName == 'noProp') evt.stopPropagation();
	});

	$(':text').on('focus',function(evt) {
		handle($('#focus'),evt,this);
		evt.stopPropagation();
	});

	$(':text').on('blur',function(evt) {
		handle($('#blur'),evt,this);
		evt.stopPropagation();
	});

	$('*:has(#prop)').on('click',function(evt) {
			if ($(evt.target).attr('ID')!='prop') return;
			$('#propTags').append(", " + this.tagName);
			var currentClicks = parseInt($('#propElems').text());
			$('#propElems').text(currentClicks + 1);
			handle($('#click'),evt,this);
	});



	for (i=0;i<events.length;i++) {
	$(document).on(events[i],function(evt) {
		handle($('#'+evt.type),evt,this);
	});
	}


    $('#framei').load(function() {
        for (i=0;i<events.length;i++) {
       $(this).contents().on(events[i],function(evt) {
		handle($('#'+evt.type),evt,this);
	});
    }
	});
    
console.log($src);

	for (var j=0;j<winEvents.length;j++) {
	$(window).on(winEvents[j],function(evt) {
		handle($('#'+evt.type),evt,this);
	});
	}

	$(document).on('keydown',function(evt) {
					updateKey('#keydown',evt);
	});
	$(document).on('keyup',function(evt) {
					updateKey('#keyup',evt);
	});
	$(document).on('keypress',function(evt) {
					updateKey('#keypress',evt);
	});

};

bindEvents();
			
function handle(elem,evt,targElem) {
	if (eventsBound) {
		if (evt.type=='mousemove' && ! mouseMoveBound) {
			return;	
		}
		highlight(elem);
		updateMonitor(evt);
		updateMouse(evt);
	}
}
	
function highlight(elem) {
	if (elem.is(':animated')) return;
	//var colorStart = jQuery.Color( "rgb(214,223,226);" );
	colorStart="red";
	elem.animate({ backgroundColor: colorStart },250).animate({ backgroundColor: "transparent" }, 1000);
}

function updateMouse(evt) {
	$('#x').text(evt.pageX);
	$('#y').text(evt.pageY);
}

function updateMonitor(evt) {
	var results = $('#monitorResults');
	var currHTML = results.html();
	currHTML = currHTML.length > 1200 ? currHTML.slice(0,1200) : currHTML;
	var eventMessage = '<p class="event">' + evt.type + '</p>';
	var target = evt.target.tagName ? evt.target.tagName : '';
	var targetMessage = '<p class="target">' + target + '</p>';
	results.html(eventMessage+targetMessage+currHTML );
}

function updateKey(elem, evt) {
	$('.which',elem).text(evt.which);
	$('.shiftkey',elem).text(evt.shiftKey);
	$('.metakey',elem).text(evt.metaKey);
	$('.keycode',elem).text(evt.keyCode);
	$('.altkey',elem).text(evt.altKey);
	$('.ctrlkey',elem).text(evt.ctrlKey);
	var key = (evt.type=='keypress') ? evt.which : evt.keyCode;
	var letter = String.fromCharCode(key);
	$('.letter',elem).text(letter);
}	
}); //ready
</script>
@endpush
@section('content')
<article class="container-fluid main_page top-110x">
    <div id="monitor">
      <h2>Отслеживание событий <small>(clear)</small></h2>
      <p class="event"><strong>Событие</strong></p>
      <p class="target"><strong>Цель</strong></p>
      <div id="monitorResults"></div>
    </div>
    <br/>
    <div style="margin-top: 180px;" class="row events">
        <iframe id="framei" src="https://arm4web.rgs.ru/armweb/" height="700px" class="col" frameborder="1" seamless>
        Ваш браузер не поддерживает технлоогию IFRAME
        </iframe>
    </div>
</article>
@endsection

