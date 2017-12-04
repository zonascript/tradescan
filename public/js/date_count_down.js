
var monthNames = [Jan, Feb, Mar, Apr, May,
	June, July, Aug, Sept, Oct, Nov, Dec];
var obj = {
	starts: $('.starts'),
	round: $('.round'),
	ico_starts:$('.ico-starts'),
	ico_ends:$('.ico-ends'),
	pre_ico_starts:$('.pre-ico-starts'),
	pre_ico_ends:$('.pre-ico-ends'),
	date: document.getElementsByClassName('date-box'),
	singleDigitCheck: function (num){
		return num > 9 ? num : '0' + num;
	},
	ordinal_suffix: function(i){
			var j = i % 10,
				k = i % 100;
			if (j == 1 && k != 11) {
				return  "st";
			}
			if (j == 2 && k != 12) {
				return  "nd";
			}
			if (j == 3 && k != 13) {
				return  "rd";
			}
			return  "th";
	},
	getFullDate: function(param){
		var o = new Date(parseInt(param,10)).getTimezoneOffset();
		var d = new Date(parseInt(param,10)+o*60000);
		return monthNames[d.getMonth()] + ' ' + d.getDate()  + '; ' + obj.singleDigitCheck(d.getHours())  + ":" + obj.singleDigitCheck(d.getMinutes());
	}
};

[].forEach.call(obj.date, function(v,i,a) {
	var dateX = obj.getFullDate(v.innerHTML*1000);
	obj.date[i].innerHTML = dateX;
});

var diff;
function updateTime() {
	function pad(num) {
		return num > 9 ? num : '0' + num;
	};
	days = Math.floor( diff / (1000*60*60*24) ),
		hours = Math.floor( diff / (1000*60*60) ),
		mins = Math.floor( diff / (1000*60) ),
		secs = Math.floor( diff / 1000 ),
		dd = days,
		hh = hours - days * 24,
		mm = mins - hours * 60,
		ss = secs - mins * 60;
	translated_day = '';

	switch (dd){
		case 0 : translated_day = day_0;
			break;
		case 1 : translated_day = day_1;
			break;
		case 2 :
		case 3 :
		case 4 : translated_day = day_234;
		default : translated_day = day_default;
		break
	}
	var count_down = document.getElementById("countdown_time");
	if(count_down){
		count_down.innerHTML =
			dd + ' ' + translated_day +
			pad(hh) + ':' + //' hours ' +
			pad(mm) + ':' + //' minutes ' +
			pad(ss) ; //+ ' seconds' ;
		diff -= 1000;
	}

}

