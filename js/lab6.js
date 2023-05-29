var countDownDateTime = 0;
var sBtn_state = 0;
var manual_state = 0;
var snooze_state = 0; 
var x, now, days, hours, minutes, seconds, mseconds; // Global scope vars 
$(document).ready(function() {
	var audioElement = document.createElement('audio');
    audioElement.setAttribute('src', 'sounds/Rooster-Crow-A-www.fesliyanstudios.com.mp3');
	var now = new Date();
	var month = now.getMonth()+1;
	var day = now.getDate();
	var output = now.getFullYear() + '-' + 
			(month<10 ? '0' : '') + month + '-' +
			(day<10 ? '0' : '') + day;
	seconds = now.getSeconds();
	minutes = now.getMinutes();
	hours = now.getHours();
	var time = (hours==0? '00':'') + (hours<10? '0':'') + hours + ":" + 
				(minutes==0? '00':'') + (minutes<10? '0': '') + minutes + ":" + 
				(seconds==0? '00':'') + (seconds < 10? '0' : '') + seconds;
	//alert("output = ["+output+"]"); 
	//alert("time = ["+time+"]");
	$("#EventDate").val(output);
	$("#EventTime").val(time); 
	
	$(".manual").focusin(function(){
		if (manual_state == 0) {
			$(".manual").css("background-color", "#FFFFCC");
			manual_state = 1;
			$("#Days").val(0);
			$("#Hours").val(0);
			$("Minutes").val(0);
			$("#Seconds").val(0);
			$("#mSeconds").val(0);
		} else {
			manual_state = 0;
			$(".manual").css("background-color", "#FFFFFF");
		}
		return;
	});
	$("#Snooze").click(function() {
		snooze_state = 1;
		// Inject 10 seconds to display
		$("#Days").val(0);
		$("#Hours").val(0);
		$("#Minutes").val(5);
		$("#Seconds").val(0);
		$("#mSeconds").val(0);
		// call countdownMs(10000)
		countDownNow(300000); // How many msec in 5 min? = 5*60*1000
		$("#Start").html("Pause");
		sBtn_state = 1; // To make Pause button work 
		return;
	})
	$("#setEventDate").click(function() { 
		var countDownDate = $("#EventDate").val();
		var countDownTime = $("#EventTime").val();
		alert("countDownDate: ["+countDownDate+"]");
		alert("countDownTime: ["+countDownTime+"]");
		/*var: making it global */
		countDownDateTime = new Date(countDownDate+" "+countDownTime);
		alert("countDownDateTime=["+countDownDateTime+"]");
		var now = new Date();
		var diff = (countDownDateTime - now); // In milliseconds for show only
		alert("now = ["+now+"]");
		alert("Diff = ["+diff+"]");
		if (diff <= 0) {
			$("#Days").val(0);
			$("#Hours").val(0);
			$("#Minutes").val(0);
			$("#Seconds").val(0);
			$("#mSeconds").val(0);
			return;
		}
		$("#Days").val(Math.floor(diff / (1000 * 60 * 60 * 24)));
		$("#Hours").val(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
		$("#Minutes").val(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)));
		$("#Seconds").val(Math.floor((diff % (1000 * 60)) / 1000));
	})
	$("#Start").click(function() {
		if (sBtn_state == 0) {
			sBtn_state = 1;
			// 1. Change button display the next state
			$("#Start").html("Pause");
			// 2. Perform the required function: start to count down
			// 2.1 calculate the difference between the target data/time and now
			// 2.2 call the countdown function to display the elapsing time
			if (manual_state == 0) {
				now = new Date();
				countDownMSeconds = countDownDateTime - now;
				alert("countDownMSeconds = ["+countDownMSeconds+"]");
				if (countDownMSeconds <= 0) { // Guarding the termination condition
					$("#Start").html("Start*"); // Add logics to zero out all displays
					sBtn_state = 0;
					return; // Do nothing 
				}
				// Update the count down every 10 msecond
				countDownNow(countDownMSeconds);
				return;
			} // Manual state reset
			manual_state = 0;
			// calculate mseconds
			countDownMSeconds = $("#Days").val()*24*60*60*1000 +
				$("#Hours").val()*60*60*1000 +
				$("#Minutes").val()*60*1000 +
				$("#Seconds").val()*1000;
			alert("Manual state countDownMSeconds("+countDownMSeconds+")");
			countDownNow(countDownMSeconds); 
		}
		if (sBtn_state == 1) {  // After "pause" click
			sBtn_state = 2;
			// 1. Change button display the next state
			$("#Start").html("Resume");
			// 2. Perform the required function
			clearInterval(x); // Stop counting down without changing "countdownMSeconds"
			$("#Start").html("Resume");
			return;
		} 
		if (sBtn_state == 2) { // After "Resume" click
			sBtn_state = 1;
			// 1. Change button display the next state
			$("#Start").html("Pause2");
			// 2. Perform the required function
			if (snooze_state != 1) {
				now = new Date();
				countDownMSeconds = countDownDateTime - now;
				if (countDownMSeconds <= 0) { // Guarding the termination condition
					$("#Start").html("Start**"); // Add logics to zero out all displays
					sBtn_state = 0;
					$("#Days").val(0);
					$("#Hours").val(0);
					$("#Minutes").val(0);
					$("#Seconds").val(0);
					$("#mSeconds").val(0);
					return; // Do nothing 
				}
			} else {
				countDownMSeconds = $("#Days").val()*24*60*60*1000 +
				$("#Hours").val()*60*60*1000 +
				$("#Minutes").val()*60*1000 +
				$("#Seconds").val()*1000;
			}
			// Update the count down every 10 msecond
			countDownNow(countDownMSeconds);
			return;
		} 
		//Any other numbers come here "3" generated by the end of elapsed time.
		sBtn_state = 0;
		// 1. Change button display the next state
		$("#Start").html("Start***");
		// 2. Perform the required functions: stop counting, zero out display, reset sBtn_state, 
		//    set $("#Start") show "Start(3)", stop the alarm(sound), return
		audioElement.pause();
		return;
	})
	function countDownNow(MSeconds) {
		countDownMSeconds = MSeconds;
		x = setInterval(function() {
			countDownMSeconds -= 10; // in miliseconds = 1/1000 second

			// Time calculations for days, hours, minutes and seconds
			var days = Math.floor(countDownMSeconds / (1000 * 60 * 60 * 24));
			var hours = Math.floor((countDownMSeconds % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((countDownMSeconds % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((countDownMSeconds % (1000 * 60)) / 1000);
			var mseconds = countDownMSeconds % (1000);
			//alert("msec=["+mseconds+"]");

			// Output the result in an element with id="demo"
			$("#Days").val(days);
			$("#Hours").val(hours);
			$("#Minutes").val(minutes);
			$("#Seconds").val(seconds);
			$("#mSeconds").val(mseconds);
			// If the count down is over, report and ring
			if (countDownMSeconds < 0) {
				$("#Days").val(0);
				$("#Hours").val(0);
				$("#Minutes").val(0);
				$("#Seconds").val(0);
				$("#mSeconds").val(0);
				clearInterval(x); // Stop animation
				$("#Start").html("Quiet");
				audioElement.play(); 
				sBtn_state = 3;
				return;
			}
		}, 10);
	}
}) 

