var $ = require('jquery');
require('bootstrap');
require('../css/app.scss');

// song viewer

var AmLoaded = false,
	input = $('input'),
	store = "BSPSettings";
var w, h, ht,hm,wav,score, ctxW, ctxT, ctxS, ctxM
var PW = [], PN = [], PL = [], PS = [] //Word, Number, Line, Stanza
var SB = [], SE = [], SD = [], SW = [], SN = []

$(document).ready(function () {

	//$("#SlidePos").slider()

	//setupInput(store, input);
	//$("input").change(function () {
	
	theCanvast = document.getElementById('canvast');

	if (theCanvast != null) {

		var songid = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);

		if (/^[0-9]{1,5}$/.test(songid)) {
			
			$("input").on('input', function () {

				CalcIt()
			});

			ctxT = canvast.getContext("2d")
			theCanvasw = document.getElementById('canvasw');
			ctxW = canvasw.getContext("2d")
			ctxS = canvass.getContext("2d")
			ctxM = canvasm.getContext("2d")
			theCanvasm = document.getElementById('canvasm');
			//$("#canvasw").clearCanvas()

			w = theCanvasw.width;
			w = 1120;

			h = theCanvasw.height;
			//h = 80;

			ht=theCanvast.height;
			//ht = 80;

			hm=theCanvasm.height;
			//hm = 80;

			//jQuery.get('../viewerdata/chant/chant.txt', function (data) {
			jQuery.get('../viewerdata/' + songid + '/urtext.txt', function (data) {
				var D = data.replace(/\r\n/g, '\n')
				$('#Urtext').val(D)
				;
				CalcIt();
			});
			//jQuery.get('../viewerdata/chant/chantt.txt', function (data) {
			jQuery.get('../viewerdata/' + songid + '/translation.txt', function (data) {

				var D = data.replace(/\r\n/g, '\n')
				$('#Urtextt').val(D)
				;
				CalcIt();
			});
			//jQuery.get('../viewerdata/chant/chanturdata.txt', function (data) {
			jQuery.get('../viewerdata/' + songid + '/urdata.txt', function (data) {
				var D = data.replace(/\r\n/g, '\n')
				var tmp = D.split('\n')
				for (i = 1; i < tmp.length; i++) //First line is a header
				{
					s = tmp[i].split('\t')
					if (s.length > 2) {
						PW.push(s[0])
						PN.push(parseInt(s[1]))
						PL.push(parseInt(s[2]))
						PS.push(parseInt(s[3]))
					}
				}
				;
				CalcIt();
			});
			//jQuery.get('../viewerdata/chant/chanttimings.txt', function (data) {
			jQuery.get('../viewerdata/' + songid + '/timings.txt', function (data) {
				var D = data.replace(/\r\n/g, '\n')
				var tmp = D.split('\n')
				for (i = 1; i < tmp.length; i++) //First line is a header
				{
					s = tmp[i].split('\t')
					if (s.length > 2) {
						SB.push(parseFloat(s[0]))
						SE.push(parseFloat(s[1]))
						SD.push(parseFloat(s[2]))
						SW.push(s[3])
						SN.push(parseInt(s[4]))
					}
				}
				CalcIt();
				;
			});

			wav = new Image();
			wavloaded = false;
			wav.onload = function () { wavloaded = true; draww(0, 0); }
			//wav.src = "../viewerdata/chant/chant.png";
			wav.src = "../viewerdata/" + songid + "/waveform.png";
			score=new Image()
			scoreloaded = false;
			//score.src="../viewerdata/chant/chantscore.jpg"
			score.src="../viewerdata/" + songid + "/score.jpg"
			score.onload = function () { scoreloaded = true; draww(0, 0); }
			AmLoaded = true
			//CalcIt();
		
		}
	
	}
});

function CalcIt() {
	//console.log('CalcIt');
	if (!AmLoaded) return

	var ThemAll = setupCheckRadio(input);
	if (localStorage) {
		localStorage.setItem(store, ThemAll);
	}

	//    var z = parseFloat($('#SlideZoom').val())
	var p = parseFloat($('#SlidePos').val())
	draww(p)

}
function draww(p) {
	//console.log('draww');
	//Draw the wav
	if (wavloaded) {
		ctxW.clearRect(0, 0, w, h);
		ctxW.drawImage(wav, 0, 0, w, h);
	}
	//Show the position
	pc = w * p / 100
	ctxW.lineWidth = 1
	ctxW.strokeStyle = 'rgba(0,0,0,0.2)'
	ctxW.translate(0.5,0)
	ctxW.strokeRect(Math.round(pc), 0, 0, h)
	ctxW.translate(-0.5,0)

	//Draw the Urtext
	ctxT.clearRect(0, 0, w, ht);		
	ctxT.lineWidth = 2
	hL = ht / 3
	Lmax = PL[PL.length - 1]
	NL = PL.length
	Lc = PL[0]
	ctxT.moveTo(0, hL)
	ctxT.beginPath()
	ctxT.strokeStyle = Rainbow(PL[0] / Lmax)
	for (i = 1; i < NL; i++) {
		if (PL[i] > Lc) {
			Lc = PL[i]
			ctxT.stroke()
			ctxT.beginPath()
			ctxT.strokeStyle = Rainbow(PL[i] / Lmax)
			noMatch = true
			for (j = 0; j < SN.length; j++) {
				if (SN[j] == PN[i]) { noMatch = false; break }
			}
			if (noMatch) ctxT.strokeStyle = "gray"
			ctxT.moveTo(i / NL * w, hL)
		}
		else { ctxT.lineTo(i / NL * w, hL) }
	}
	ctxT.stroke()
	//Now the stanzas
	hS = 2 * ht / 3
	Smax = PS[PS.length - 1]
	NS = PS.length
	Sc = parseInt(PS[0])
	ctxT.moveTo(0, hS)
	ctxT.beginPath()
	ctxT.strokeStyle = Rainbow(PS[0] / Smax)
	for (i = 1; i < NL; i++) {
		if (PS[i] > Sc) {
			Sc = PS[i]
			ctxT.stroke()
			ctxT.beginPath()
			ctxT.strokeStyle = Rainbow(PS[i] / Smax)
			ctxT.moveTo(i / NS * w, hS)
		}
		else { ctxT.lineTo(i / NS * w, hS) }
	}
	ctxT.stroke()
	
	//Draw the Song
	ctxS.clearRect(0, 0, w, ht);
	ctxS.lineWidth = 1
	ctxS.strokeStyle = 'rgba(0,0,0,0.2)'
	ctxS.translate(0.5,0)
	ctxS.strokeRect(Math.round(pc), 0, 0, ht)
	ctxS.translate(-0.5,0)
	var Abst = SB[SB.length - 1] / w
	ctxS.lineWidth = 1
	for (i = 0; i < SB.length; i++) {
		b = SB[i] / Abst; d = SD[i] / Abst
		if (SW[i] == "R") SW[i]="|"
		ctxS.beginPath()
		ctxS.strokeStyle = Rainbow(PL[SN[i]] / Lmax)
		ctxS.translate(0.5,0)
		bh=3*d
		if (SW[i] == "|") {ctxS.strokeStyle = 'rgba(0,0,0,0.2)';bh=ht/4}
		ctxS.moveTo(Math.round(b + d/2), ht-bh)
		ctxS.lineTo(Math.round(b + d/2), ht)
		ctxS.stroke()
		ctxS.translate(-0.5,0)

	}
	//Which word etc. are we on
	for (i=0;i<SB.length;i++)
	{
		if (SB[i]/Abst>=pc)
		{
			i-=1
			s=(p/100*SB[SB.length - 1]).toFixed(1)+"s"
			$('#Time').val(s)
			for (j=0;j<PN.length;j++)
			{
				if (SN[i]==PN[j])
				{
					s="Stanza:" + PS[j] + ", Line: "+PL[j]
					$('#Stanza').val(s)
					ctxT.beginPath()
					ctxT.fillStyle='rgba(255,165,0,0.4)'
					ctxT.ellipse(j/NS*w,ht/2,5,5,0,0,2*Math.PI)
					ctxT.fill()
					Jump("Urtext",PL[j]+PS[j]-2,NS) //Add PS[j] for spaces between stanzas
					Jump("Urtextt",PL[j]+PS[j]-2,NS) //Add PS[j] for spaces between stanzas
					break
				}
			}
			s=""
			for (j=i-6;j<i+6;j++)
			{
				if (j>=0 && j<SB.length) s+=SW[j]+" "
				if (j==i-1) {ss=s.length}
				if (j==i) {sf=s.length}
			}
			if (i>=0) {$('#Word').val(1+i)} else {$('#Word').val("")}
			$('#Info').val(s)
			$('#Info').selectRange(ss,sf)
			break
		}
	}
	//Now the score
	if (scoreloaded) {
		//ctxM.drawImage(score, score.width/10, p/103*score.height, 0.9*score.width, score.height/33, 0, 0, w, hm);
		ctxM.drawImage(score, 0, p/103*score.height, score.width, score.height/33, 0, 0, w, hm);

		// img	Specifies the image, canvas, or video element to use	 
		// sx	Optional. The x coordinate where to start clipping	
		// sy	Optional. The y coordinate where to start clipping	
		// swidth	Optional. The width of the clipped image	
		// sheight	Optional. The height of the clipped image	
		// x	The x coordinate where to place the image on the canvas	
		// y	The y coordinate where to place the image on the canvas	
		// width	Optional. The width of the image to use (stretch or reduce the image)	
		// height	Optional. The height of the image to use (stretch or reduce the image)

	}

	//Tidy everything up with nice boxes
	ctxM.lineWidth=ctxT.lineWidth=ctxT.lineWidth=ctxT.lineWidth=1
	ctxM.strokeStyle=ctxS.strokeStyle =ctxT.strokeStyle =ctxW.strokeStyle = "gray"

	ctxS.strokeRect(0, 0, w, ht)
	ctxT.strokeRect(0, 0, w, ht)
	ctxW.strokeRect(0, 0, w, h)
	if (scoreloaded) { ctxM.strokeRect(0, 0, w, hm) }
}
//Data for the rainbow
var RB = [[0, 48, 245], [0, 52, 242], [0, 55, 238], [0, 59, 235], [3, 62, 231], [9, 66, 228], [14, 69, 225], [18, 72, 221], [20, 74, 218], [22, 77, 214], [23, 80, 211], [24, 82, 207], [25, 85, 204], [25, 87, 200], [25, 90, 197], [25, 92, 193], [25, 94, 190], [25, 96, 187], [24, 99, 183], [24, 101, 180], [24, 103, 177], [23, 105, 173], [23, 106, 170], [24, 108, 167], [24, 110, 164], [25, 112, 160], [27, 113, 157], [28, 115, 154], [30, 117, 151], [32, 118, 148], [34, 120, 145], [36, 121, 142], [39, 122, 139], [41, 124, 136], [43, 125, 133], [45, 126, 130], [47, 128, 127], [49, 129, 124], [51, 130, 121], [53, 132, 118], [54, 133, 115], [56, 134, 112], [57, 136, 109], [58, 137, 106], [59, 138, 103], [60, 139, 99], [61, 141, 96], [62, 142, 93], [62, 143, 90], [63, 145, 87], [63, 146, 83], [64, 147, 80], [64, 149, 77], [64, 150, 74], [65, 151, 70], [65, 153, 67], [65, 154, 63], [65, 155, 60], [66, 156, 56], [66, 158, 53], [67, 159, 50], [68, 160, 46], [69, 161, 43], [70, 162, 40], [71, 163, 37], [73, 164, 34], [75, 165, 31], [77, 166, 28], [79, 167, 26], [82, 168, 24], [84, 169, 22], [87, 170, 20], [90, 171, 19], [93, 172, 18], [96, 173, 17], [99, 173, 17], [102, 174, 16], [105, 175, 16], [108, 176, 16], [111, 176, 16], [114, 177, 17], [117, 178, 17], [121, 179, 17], [124, 179, 18], [127, 180, 18], [130, 181, 19], [132, 182, 19], [135, 182, 20], [138, 183, 20], [141, 184, 20], [144, 184, 21], [147, 185, 21], [150, 186, 22], [153, 186, 22], [155, 187, 23], [158, 188, 23], [161, 188, 24], [164, 189, 24], [166, 190, 25], [169, 190, 25], [172, 191, 25], [175, 192, 26], [177, 192, 26], [180, 193, 27], [183, 194, 27], [186, 194, 28], [188, 195, 28], [191, 195, 29], [194, 196, 29], [196, 197, 30], [199, 197, 30], [202, 198, 30], [204, 199, 31], [207, 199, 31], [210, 200, 32], [212, 200, 32], [215, 201, 33], [217, 201, 33], [220, 202, 34], [223, 202, 34], [225, 202, 34], [227, 203, 35], [230, 203, 35], [232, 203, 35], [234, 203, 36], [236, 203, 36], [238, 203, 36], [240, 203, 36], [241, 202, 36], [243, 202, 36], [244, 201, 36], [245, 200, 36], [246, 200, 36], [247, 199, 36], [248, 197, 36], [248, 196, 36], [249, 195, 36], [249, 194, 35], [249, 192, 35], [250, 191, 35], [250, 190, 35], [250, 188, 34], [250, 187, 34], [250, 185, 34], [250, 184, 33], [250, 182, 33], [250, 180, 33], [250, 179, 32], [249, 177, 32], [249, 176, 32], [249, 174, 31], [249, 173, 31], [249, 171, 31], [249, 169, 30], [249, 168, 30], [249, 166, 30], [248, 165, 29], [248, 163, 29], [248, 161, 29], [248, 160, 29], [248, 158, 28], [248, 157, 28], [248, 155, 28], [247, 153, 27], [247, 152, 27], [247, 150, 27], [247, 148, 26], [247, 147, 26], [246, 145, 26], [246, 143, 26], [246, 142, 25], [246, 140, 25], [246, 138, 25], [245, 137, 24], [245, 135, 24], [245, 133, 24], [245, 132, 24], [244, 130, 23], [244, 128, 23], [244, 127, 23], [244, 125, 23], [244, 123, 22], [243, 121, 22], [243, 119, 22], [243, 118, 22], [243, 116, 21], [242, 114, 21], [242, 112, 21], [242, 110, 21], [241, 109, 21], [241, 107, 21], [241, 105, 21], [241, 103, 21], [240, 101, 21], [240, 100, 22], [240, 98, 22], [240, 96, 23], [240, 95, 24], [240, 93, 26], [240, 92, 27], [240, 90, 29], [240, 89, 31], [240, 88, 33], [240, 87, 36], [240, 87, 38], [241, 86, 41], [241, 86, 44], [242, 86, 47], [242, 86, 51], [243, 86, 54], [243, 87, 58], [244, 88, 62], [245, 88, 65], [245, 89, 69], [246, 90, 73], [247, 91, 77], [247, 92, 82], [248, 94, 86], [249, 95, 90], [249, 96, 94], [250, 97, 98], [251, 99, 102], [251, 100, 106], [252, 101, 111], [252, 103, 115], [253, 104, 119], [253, 105, 123], [254, 107, 128], [254, 108, 132], [255, 109, 136], [255, 111, 140], [255, 112, 145], [255, 114, 149], [255, 115, 153], [255, 116, 157], [255, 118, 162], [255, 119, 166], [255, 120, 170], [255, 122, 175], [255, 123, 179], [255, 125, 183], [255, 126, 188], [255, 127, 192], [255, 129, 196], [255, 130, 201], [255, 132, 205], [255, 133, 210], [255, 134, 214], [255, 136, 219], [255, 137, 223], [255, 139, 227], [255, 140, 232], [255, 141, 236], [254, 143, 241], [254, 144, 245], [253, 146, 250]]
function Rainbow(v) {
	if (isNaN(v)) { return RGBToHex(0, 0, 0); }
	var i = Math.floor((Math.min(v, 1), Math.max(v, 0)) * 255)
	var r = RB[i][0]
	var g = RB[i][1]
	var b = RB[i][2]
	return RGBToHex(r, g, b)
}
RGBToHex = function (r, g, b) {
	var bin = r << 16 | g << 8 | b;
	return (function (h) {
		return "#" + new Array(7 - h.length).join("0") + h
	})(bin.toString(16).toUpperCase())
}
function Jump(txtarea,line,rows)
{
	var ta = document.getElementById(txtarea)
	//This isn't right to fiddle with 5.7
	//There must be a proper way
	var lineHeight = ta.scrollHeight / rows*5.7;
	var jump = line * lineHeight;
	ta.scrollTop = jump;
}

//SELECT TEXT RANGE
$.fn.selectRange = function(start, end) {
	return this.each(function() {
		if (this.setSelectionRange) {
			this.focus();
			this.setSelectionRange(start, end);
		} else if (this.createTextRange) {
			var range = this.createTextRange();
			range.collapse(true);
			range.moveEnd('character', end);
			range.moveStart('character', start);
			range.select();
		}
	});
};


// below here is contents of app.js

(function() {
// Redraw plots on page resize
    window.addEventListener("resize", resizeThrottler, false);
    var resizeTimeout;

    function resizeThrottler() {
        // ignore resize events as long as an actualResizeHandler execution is in the queue
        if ( !resizeTimeout ) {
            resizeTimeout = setTimeout(function() {
                resizeTimeout = null;
                actualResizeHandler();

                // The actualResizeHandler will execute at a rate of 15fps
            }, 66);
        }
    }

    function actualResizeHandler() {
        CalcIt();
    }

}());

function showTooltip(x, y, contents) {
    $('<div id="tooltip">' + contents + '</div>').css({
        position: 'absolute',
        display: 'none',
        top: y + 5,
        left: x + 5,
        border: '1px solid #b4b4ff',
        padding: '2px',
        'background-color': '#c4c4ff',
        opacity: 0.80
    }).appendTo("body").fadeIn(200);
}

function setupInput(store, selector) {
    var ThemAll;
    if (localStorage) {
        ThemAll = localStorage.getItem(store);
    }

    if (ThemAll) {
        var s = ThemAll.split("\n");
        var sl = "";
        selector.each(function () {
            for (i = 0; i < s.length; i++) {
                if (s[i].indexOf(this.id) === 0) {
                    sl = s[i].split(":");
                    if (this.type === "checkbox" || this.type === "radio") {
                        if (sl[1] === "true") {
                            this.checked = true;
                        } else {
                            this.checked = false;
                        }
                    }
                    else {
                        if ($(this).attr("id").indexOf("Slide") >= 0) {
                            $(this).slider('setValue', parseFloat(sl[1]));
                        }
                        else {
                            try {this.value = sl[1];} catch(err) {}
                         }
                    }
                    break;
                }
            }
        }).change(function () {
            CalcIt();
        });
        $("select").each(function (index) {
            for (i = 0; i < s.length; i++) {
                if (s[i].indexOf(this.id) == 0) {
                    sl = s[i].split(":");
                    this.value = sl[1]
                }
            }
        }).change(function () {
            CalcIt();
        });
    }
}

function setupCheckRadio(selector) {
    var ThemAll = "";
    selector.each(function () {
            if (this.type === "checkbox" || this.type === "radio") {
                ThemAll += this.id + ":" + this.checked + "\n";
            }
            else {
                ThemAll += this.id + ":" + this.value + "\n";
            }
        }
    );
    $("select").each(function (index) {
        ThemAll += this.id + ":" + this.value + "\n";
    })

    return ThemAll;
}
