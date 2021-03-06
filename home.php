<!DOCTYPE html>
<html>
    <head>
        <title>Geovent</title>
        <style type="text/css">
            body 
            {
                margin: 0px;
               overflow: hidden;
            }
        </style>
    </head>
    <body>
        <canvas id="canvas"></canvas>
        <script>
            //alert(links.join('\n'));
            var circleDistribution = [  1,
                                        3,
                                        10,
                                        20];
            var links = [];
            var sliceLength = [];
            var isOnCircle = false;
            var linksNumbers = [3 , 4 , 4 ,2,2,2,2,2,2,2,2,2,2,2];
            var circles = [[0,0,0]];
            var linkedCircles = [];
            var redLinkedCircles = [];
            var colors = ["#ff0000"];
            var angleInput = document.getElementById("angle");
            var bufferArray;
            var imageLinks = [0,0,0,0,0,0,"images/1.jpg","images/2.jpg",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,"images/2.jpg"];
            var images = [];
            var circleActions = ["index.html",null,null,null,null,null,"selectPicture.html"];
            var imagesDrawn = false;
            var activeCircle = null;
            var timeOnCircle = [];
            var radii = [   15,
                            20,
                            25,
                            30,
                            35,
                            40,
                            45,
                            50,
                            55,
                            60,
                            65,
                            70,
                            75,
                            80,
                            85,
                            90];
            var links;
            var gradientLinks = [];
            var redLinks = [];
            var randomRotation;
            var degToRad = Math.PI/180;
            var radToDeg = 180/Math.PI;
            var mouseX = 0, mouseY = 0;
            var canvas = document.getElementById("canvas");
            var canvasContext = canvas.getContext("2d");  
            var currentDistanceFromOrigin;
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;   
            canvasContext.translate(window.innerWidth/2,window.innerHeight/2);
            init();
            drawMenu(1);
            window.onload = function() {
                fillCircles ();
            };
            function initImages () {
                for (i = 0; i < imageLinks.length; i++) {
                    if (imageLinks[i] !== 0) {
                        var img = new Image();
                        img.src = imageLinks[i];
                        images.push(img);
                    }
                    else {
                        images.push(null);
                    }
                }
            }
            function init () {
                var currentCircleNumber = 0;
                currentDistanceFromOrigin = 0;
                for (i = 0; i < circleDistribution.length; i++) {
                    if (i !== 0) {
                        randomRotation = Math.random()*(360/circleDistribution[i])*degToRad;
                        currentDistanceFromOrigin += screen.height/radii[i-1]*2.8;
                        for (o = 0; o < circleDistribution[i]; o++) {
                            circles.push([Math.cos((360/circleDistribution[i])*degToRad*o +randomRotation)*currentDistanceFromOrigin , -Math.sin((360/circleDistribution[i])*degToRad*o + randomRotation)*currentDistanceFromOrigin,i]);
                            colors.push('#'+('00000'+(Math.random()*(1<<24)|0).toString(16)).slice(-6));
                            currentCircleNumber++;
                        }
                    }
                }
                initSliceLength ();
                initLinks ();
                initImages ();
            }
            function initSliceLength () {
                var currentLength = 0;
                for (i = 0;i < circleDistribution.length;i++) {
                    currentLength = currentLength + circleDistribution[i];
                    sliceLength.push(currentLength);
                }
            }
            function firstInNextSlice (circle) {
                for (i = 0;i < sliceLength.length;i++) {
                    if (circle < sliceLength[i]) {
                        return sliceLength[i];
                    }
                }
            }
            function lastInNextSlice (circle) {
                for (i = 0;i < sliceLength.length;i++) {
                    if (circle < sliceLength[i]) {
                        return (sliceLength[i + 1] - 1);
                    }
                }
            }
            function initLinks () {
                var distances = [];
                for (i = 1; i <= circleDistribution[1]; i++) {
                    links.push([0 , i]);    
                }
                for (t = 1; t < linksNumbers.length; t++) {
                    var last = lastInNextSlice (t);
                    var first = firstInNextSlice (t);
                    for (o = first;o <= last; o++) {
                        if (!isThiscircleLinked (o)) {
                            distances.push([Math.sqrt((circles[t][0] - circles[o][0])*(circles[t][0] - circles[o][0]) + (circles[t][1] - circles[o][1])*(circles[t][1] - circles[o][1])) , o]);
                        }
                    }
                    distances = distances.sort(function(a, b){return a[0]-b[0];});
                    checkDistancesOrder (distances);
                    var currentCircle = 0;
                    var newLinks = 0;
                    for (u = 0;u < linksNumbers[t];u++){
                        links.push([t,distances[u][1]]);
                        linkedCircles.push(distances[u][1]); 
                    }
                    distances = [];
                }
                
            }
            function checkDistancesOrder (distances) {
                for (a = 0;a < distances.length - 1;a++) {
                    if (distances[a][0] >= distances[a + 1][0]) {
                        alert("error");
                    }
                }
            }
            function isThiscircleLinked (circle) {
                if (linkedCircles.indexOf(circle) === -1) {
                    return false;
                }
                return true;
            }
            function drawMenu (overload) {
                if (overload === 1) {
                    canvas.width = canvas.width;
                    canvasContext.translate(window.innerWidth/2,window.innerHeight/2);
                    var a = 0;
                    drawLinks ();
                    for (i = 0; i < circleDistribution.length; i++) {
                        for (o = 0; o < circleDistribution[i]; o++) {
                            canvasContext.beginPath();
                            canvasContext.arc(circles[a][0],circles[a][1], screen.height/radii[i], 0, 2 * Math.PI, false);
                            canvasContext.fillStyle = colors[a];
                            canvasContext.fill();
                            a++;
                        }
                    }
                    {
                        {
                            canvasContext.beginPath();
                            canvasContext.arc(0,0, screen.height/50, 0, 2 * Math.PI, false);
                            canvasContext.fillStyle = "white";
                            canvasContext.fill();
                        }
                        {
                            canvasContext.beginPath();
                            canvasContext.arc(0,0, screen.height/30, 0, 2 * Math.PI, false);
                            canvasContext.lineWidth = 10;
                            canvasContext.strokeStyle = "white";
                            canvasContext.stroke();
                        }   
                        {
                            canvasContext.beginPath();
                            canvasContext.moveTo(screen.width/60, 0);
                            canvasContext.lineTo(screen.width/30, 0);
                            canvasContext.stroke();
                        }
                        {
                            canvasContext.beginPath();
                            canvasContext.moveTo(-screen.width/60, 0);
                            canvasContext.lineTo(-screen.width/30, 0);
                            canvasContext.stroke();
                        }
                        {
                            canvasContext.beginPath();
                            canvasContext.moveTo(0, -screen.width/60);
                            canvasContext.lineTo(0, -screen.width/30);
                            canvasContext.stroke();
                        }
                        {
                            canvasContext.beginPath();
                            canvasContext.moveTo(0, screen.width/60);
                            canvasContext.lineTo(0, screen.width/30);
                            canvasContext.stroke();
                        }
                    }
                    fillCircles ();
                }
                else if (isOnCircle) {
                    canvas.width = canvas.width;
                    canvasContext.translate(window.innerWidth/2,window.innerHeight/2);
                    var a = 0;
                    if (gradientLinks.length === 0 && redLinks.length === 0) {
                        gradientLinks = getLinksToCircle(activeCircle , activeCircle , 1);
                    }
                    drawLinks ();
                    drawGradientLinks ();
                    drawRedLinks ();
                    for (i = 0; i < circleDistribution.length; i++) {
                        for (o = 0; o < circleDistribution[i]; o++) {
                            canvasContext.beginPath();
                            canvasContext.arc(circles[a][0],circles[a][1], screen.height/radii[i], 0, 2 * Math.PI, false);
                            canvasContext.fillStyle = colors[a];
                            canvasContext.fill();
                            a++;
                        }
                    }
                    {
                        {
                            canvasContext.beginPath();
                            canvasContext.arc(0,0, screen.height/50, 0, 2 * Math.PI, false);
                            canvasContext.fillStyle = "white";
                            canvasContext.fill();
                        }
                        {
                            canvasContext.beginPath();
                            canvasContext.arc(0,0, screen.height/30, 0, 2 * Math.PI, false);
                            canvasContext.lineWidth = 10;
                            canvasContext.strokeStyle = "white";
                            canvasContext.stroke();
                        }
                        {
                            canvasContext.beginPath();
                            canvasContext.moveTo(screen.width/60, 0);
                            canvasContext.lineTo(screen.width/30, 0);
                            canvasContext.stroke();
                        }
                        {
                            canvasContext.beginPath();
                            canvasContext.moveTo(-screen.width/60, 0);
                            canvasContext.lineTo(-screen.width/30, 0);
                            canvasContext.stroke();
                        }
                        {
                            canvasContext.beginPath();
                            canvasContext.moveTo(0, -screen.width/60);
                            canvasContext.lineTo(0, -screen.width/30);
                            canvasContext.stroke();
                        }
                        {
                            canvasContext.beginPath();
                            canvasContext.moveTo(0, screen.width/60);
                            canvasContext.lineTo(0, screen.width/30);
                            canvasContext.stroke();
                        }
                    }
                    fillCircles ();
                }
                else {
                    redLinks = [];
                    gradientLinks = [];
                    timeOnCircle = [];
                }
            }
            function getLinksToCircle (circle , exception , level) {
                var linksToCircle = [];
                for (cv = 0; cv < links.length;cv++) {
                    if (links[cv][0] === circle && links[cv][1] !== exception) {
                        linksToCircle.push([links[cv][0] , links[cv][1] , level]);
                    }
                    else if (links[cv][1] === circle && links[cv][0] !== exception) {
                        linksToCircle.push([links[cv][1] , links[cv][0] , level]);
                    }
                }
                return linksToCircle;
            }
            function drawGradientLinks () {
                for (i = 0; i < gradientLinks.length;i++) {
                    canvasContext.beginPath();
                    timeOnCurrentCircle = (Date.now()-timeOnCircle[gradientLinks[i][2] - 1])/5;
                    canvasContext.arc(circles[gradientLinks[i][0]][0],circles[gradientLinks[i][0]][1], (screen.height/3000)*timeOnCurrentCircle, 0, 2 * Math.PI, false);
                    canvasContext.closePath();
                    canvasContext.save();
                    /*canvasContext.globalAlpha = 0.5;
                    canvasContext.fill();*/
                    canvasContext.clip();
                    canvasContext.beginPath();
                    canvasContext.moveTo(circles[gradientLinks[i][0]][0], circles[gradientLinks[i][0]][1]);
                    canvasContext.lineTo(circles[gradientLinks[i][1]][0], circles[gradientLinks[i][1]][1]);
                    canvasContext.strokeStyle = "red";
                    canvasContext.stroke();
                    canvasContext.restore();
                    if (Math.sqrt((circles[gradientLinks[i][0]][0] - circles[gradientLinks[i][1]][0])*(circles[gradientLinks[i][0]][0] - circles[gradientLinks[i][1]][0]) + (circles[gradientLinks[i][0]][1] - circles[gradientLinks[i][1]][1])*(circles[gradientLinks[i][0]][1] - circles[gradientLinks[i][1]][1])) -(screen.height/3000)*timeOnCurrentCircle  <= 1) {
                        redLinks.push([gradientLinks[i][0],gradientLinks[i][1]]);
                        gradientLinks = gradientLinks.concat(getLinksToCircle(gradientLinks[i][1] , gradientLinks[i][0] , gradientLinks[i][2] + 1));
                        gradientLinks.splice(i,1);
                        timeOnCircle.push(Date.now());
                    }

                }
            }
            function drawRedLinks () {
                for (i = 0; i < redLinks.length;i++) {
                    canvasContext.beginPath();
                    canvasContext.moveTo(circles[redLinks[i][0]][0], circles[redLinks[i][0]][1]);
                    canvasContext.lineTo(circles[redLinks[i][1]][0], circles[redLinks[i][1]][1]);
                    canvasContext.strokeStyle = "red";
                    canvasContext.stroke();
                    
                }
            }
            function fillCircles () {
                for (i = 0;i < images.length;i++) {
                    if (images[i] !== null) {
                        canvasContext.beginPath();
                        var insideRadius = screen.height/(radii[circles[i][2]] * 1.3);
                        canvasContext.arc(circles[i][0],circles[i][1], insideRadius, 0, 2 * Math.PI, false);
                        canvasContext.closePath();
                        canvasContext.save();
                        canvasContext.clip();
                        canvasContext.drawImage(    images[i],
                                                    circles[i][0] - insideRadius,
                                                    circles[i][1] - insideRadius,
                                                    insideRadius * 2,
                                                    insideRadius * 2);
                        canvasContext.restore();
                    }
                }
            }
            function drawLinks () {
                canvasContext.lineWidth = 10;
                for (i = 0; i < links.length; i++){
                    canvasContext.beginPath();
                    canvasContext.moveTo(circles[links[i][0]][0], circles[links[i][0]][1]);
                    canvasContext.lineTo(circles[links[i][1]][0], circles[links[i][1]][1]);
                    canvasContext.stroke();
                }
            }
            document.addEventListener( 'click', click, false );
            function click( event ) {
                var a = 0;
                for (i = 0; i < circleDistribution.length; i++) {
                    for (o = 0; o < circleDistribution[i]; o++) {
                        if (Math.sqrt((window.innerWidth/2 + circles[a][0] - event.clientX)*(window.innerWidth/2 + circles[a][0] - event.clientX) + (window.innerHeight/2 + circles[a][1] - event.clientY)*(window.innerHeight/2 + circles[a][1] - event.clientY)) <= screen.height/radii[i]) {
                            if (circleActions[a] !== null && typeof circleActions[a] !== 'undefined') {
                                document.location.href = circleActions[a];
                            }
                            else {
                                alert(a);
                            }
                        }
                        a++;
                    }
                }
            }
            setInterval(function() { drawMenu(2); } , 0);
            document.addEventListener( 'mousemove', mousemove, false );
            function mousemove( event ) {
                isOnCircle = false;
                var a = 0;
                for (i = 0; i < circleDistribution.length; i++) {
                    for (o = 0; o < circleDistribution[i]; o++) {
                        if (Math.sqrt((window.innerWidth/2 + circles[a][0] - event.clientX)*(window.innerWidth/2 + circles[a][0] - event.clientX) + (window.innerHeight/2 + circles[a][1] - event.clientY)*(window.innerHeight/2 + circles[a][1] - event.clientY)) <= screen.height/radii[i]) {
                            isOnCircle = true;
                            if (activeCircle === null) {
                                timeOnCircle = [Date.now()];
                                colors[a] = invertColor(colors[a]);
                                drawMenu(1);
                                activeCircle = a;
                            }
                            else if (activeCircle !== a){
                                timeOnCircle = [Date.now()];
                                colors[activeCircle] = invertColor(colors[activeCircle]);
                                colors[a] = invertColor(colors[a]);
                                drawMenu(1);
                                activeCircle = a;
                            }
                        }
                        a++;
                    }
                }
                if (!isOnCircle && activeCircle !== null) {
                    colors[activeCircle] = invertColor(colors[activeCircle]);
                    activeCircle = null;
                    drawMenu(1);
                }
            }
            function invertColor(hexTripletColor) {
                var color = hexTripletColor;
                color = color.substring(1);
                color = parseInt(color, 16);
                color = 0xFFFFFF ^ color;
                color = color.toString(16);
                color = ("000000" + color).slice(-6);
                color = "#" + color;                  
                return color;
            }
            window.onresize = function(event) {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;   
                drawMenu(1);
            };
        </script>
    </body>
</html>
