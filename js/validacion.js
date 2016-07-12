
	window.onload = function() {
  	var multiIn = document.getElementById('multiplier');
  	btcConvert(multiIn);
//
};
function btcConvert(input){
 if (isNaN(input.value)){
 input.value = 0;
 }
 var multi = document.getElementById('multiplier').value;
 var multi2 = 100 / multi;
 var multi3 = multi2 - 0.02; 
 var betAmount = document.getElementById('bet').value;
 var grossProfit = multi3 * betAmount;
 var profit2 = grossProfit - betAmount;
 document.getElementById('profit').value = profit2.toFixed(0);
 document.getElementById('btmLblL').innerHTML = "Roll under " + multi;
 var rollHiC = 100 - multi;
 document.getElementById('btmLblR').innerHTML = "Roll over " + rollHiC;
}


function double(){
 var oba = document.getElementById('bet').value;
 var dbl = 2 * oba;
 document.getElementById('bet').value = dbl.toFixed(0);
 var multi = document.getElementById('multiplier').value;
 var multi2 = 100 / multi;
 var multi3 = multi2 - 0.02; 
 var betAmount = document.getElementById('bet').value;
 var grossProfit = multi3 * betAmount;
 var profit2 = grossProfit - betAmount;
 document.getElementById('profit').value = profit2.toFixed(0);
}

function half(){
 var oba = document.getElementById('bet').value;
 var dbl = oba / 2;
 document.getElementById('bet').value = dbl.toFixed(0);
 var multi = document.getElementById('multiplier').value;
 var multi2 = 100 / multi;
 var multi3 = multi2 - 0.02; 
 var betAmount = document.getElementById('bet').value;
 var grossProfit = multi3 * betAmount;
 var profit2 = grossProfit - betAmount;
 document.getElementById('profit').value = profit2.toFixed(0);
}

function noteLimit(element, stopAt){
    var max_chars = stopAt;
    if(element.value.length > max_chars) {
        element.value = element.value.substr(0, max_chars);
    }
}

