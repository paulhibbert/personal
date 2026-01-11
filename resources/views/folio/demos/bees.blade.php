<!DOCTYPE html>
<html lang="en-GB">

<head>
    <title>Bees</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <style>
        html {
            overflow: hidden;
        }
        body {
            font-family: "BlinkMacSystemFont", -apple-system, "Segoe UI", "Roboto", "Helvetica", "Arial", "Droid Sans", sans-serif;
            font-size: 2vw;
        }
    </style>
</head>

<body>
    <canvas id="cv"></canvas>
    <script>
        let intViewportWidth;
        let intViewportHeight;
        let x = new Array();
        let y = new Array();
        const bees = 10;
        const beeHeight = 60;
        const beeWidth = 60;
        let canvas = document.getElementById('cv');
        let context = canvas.getContext('2d');
        const beeSVG = `
        <svg height="60" width="60" viewBox="0 0 2800 2800" xmlns="http://www.w3.org/2000/svg">
            <g transform="translate(0 1747.6)">
                <g transform="translate(0 106.77)">
            <path transform="translate(0 -1747.6)" d="m1400 565.88c-226.67 0-409.16 182.46-409.16 409.12v650.09c0 182.83 118.73 336.92 283.59 389.69l125.56 175.25 125.56-175.25c164.87-52.763 283.59-206.86 283.59-389.69v-650.09c0-226.67-182.49-409.12-409.16-409.12zm-121.94 1450c1.6034 0.4967 3.2319 0.9914 4.8437 1.4688-1.6203-0.4799-3.232-0.9695-4.8437-1.4688zm243.88 0c-1.6117 0.4993-3.2234 0.9889-4.8437 1.4688 1.6118-0.4774 3.2403-0.9721 4.8437-1.4688zm-234.19 2.875c1.5254 0.4314 3.0611 0.836 4.5938 1.25-1.5335-0.4141-3.0676-0.8185-4.5938-1.25zm224.5 0c-1.5262 0.4315-3.0603 0.8359-4.5938 1.25 1.5327-0.414 3.0684-0.8186 4.5938-1.25zm-219.28 1.4376c1.5139 0.4064 3.0103 0.7979 4.5312 1.1874-1.5144-0.3877-3.0238-0.7829-4.5312-1.1874zm214.06 0c-1.5074 0.4045-3.0168 0.7997-4.5312 1.1874 1.5209-0.3895 3.0173-0.781 4.5312-1.1874zm-204.59 2.4062c1.2273 0.2981 2.4558 0.588 3.6875 0.875-1.2305-0.2867-2.4613-0.5773-3.6875-0.875zm195.12 0c-1.2262 0.2977-2.457 0.5883-3.6875 0.875 1.2317-0.287 2.4602-0.5769 3.6875-0.875zm-188.06 1.6562c2.0136 0.4513 4.0376 0.8909 6.0625 1.3126-2.0273-0.422-4.0465-0.8609-6.0625-1.3126zm181 0c-2.016 0.4517-4.0352 0.8906-6.0625 1.3126 2.0249-0.4217 4.0489-0.8613 6.0625-1.3126zm-165.69 3.125c1.9445 0.3584 3.8895 0.7003 5.8437 1.0313-1.9526-0.3305-3.9007-0.6733-5.8437-1.0313zm150.38 0c-1.943 0.358-3.8911 0.7008-5.8437 1.0313 1.9542-0.331 3.8992-0.6729 5.8437-1.0313zm-126.25 3.7188c1.2967 0.1601 2.6058 0.3207 3.9063 0.4688-1.3053-0.1484-2.6049-0.3083-3.9063-0.4688zm102.12 0c-1.3014 0.1605-2.601 0.3204-3.9063 0.4688 1.3005-0.1481 2.6096-0.3087 3.9063-0.4688zm-87.406 1.5312c1.5855 0.1383 3.1906 0.286 4.7813 0.4063-1.5968-0.1206-3.1898-0.2676-4.7813-0.4063zm72.688 0c-1.5915 0.1387-3.1845 0.2857-4.7813 0.4063 1.5907-0.1203 3.1958-0.268 4.7813-0.4063zm-55.156 1.1563c0.9797 0.044 1.956 0.088 2.9375 0.125-0.983-0.037-1.9563-0.081-2.9375-0.125zm37.625 0c-0.9812 0.044-1.9545 0.088-2.9375 0.125 0.9815-0.037 1.9578-0.081 2.9375-0.125z" fill="#ff0"/>
            <path transform="translate(0 -1747.6)" d="m1274.4 2014.8 125.56 175.25 125.56-175.25c-39.535 12.653-81.721 19.469-125.56 19.469s-86.028-6.8162-125.56-19.469z"/>
            <path transform="translate(-76.341 -1726.7)" d="m1571.7 905.93c0 52.672-42.699 95.371-95.371 95.371s-95.371-42.699-95.371-95.371h95.371z" fill="#2b0000"/>
            <g transform="translate(12.473)">
                <g transform="translate(0 -36.416)">
                <rect x="1228.5" y="-979.94" width="60.507" height="129.66" rx="30.253" ry="30.343"/>
                <rect x="1237.2" y="-963.18" width="24.091" height="51.623" rx="12.045" ry="12.081" fill="#fff"/>
                </g>
                <g transform="translate(257.61 -36.416)">
                <rect x="1228.5" y="-979.94" width="60.507" height="129.66" rx="30.253" ry="30.343"/>
                <rect x="1237.2" y="-963.18" width="24.091" height="51.623" rx="12.045" ry="12.081" fill="#fff"/>
                </g>
            </g>
            <g transform="translate(-.7747)">
                <path d="m1204-891.28c-3.2781 0.0681-6.2378 0.87239-8.5624 2.75-12.398 10.014 42.906 10.5 42.906 10.5s-20.138-13.545-34.344-13.25zm0.75 13.156c-8.8224 0.17066-17.65 2.0173-21.125 8.0625-7.9414 13.818 43.813-5.7188 43.813-5.7188s-11.344-2.5632-22.688-2.3438z"/>
                <path d="m1597.5-891.28c3.2781 0.0681 6.2378 0.87239 8.5624 2.75 12.398 10.014-42.906 10.5-42.906 10.5s20.138-13.545 34.344-13.25zm-0.75 13.156c8.8224 0.17066 17.65 2.0173 21.125 8.0625 7.9414 13.818-43.813-5.7188-43.813-5.7188s11.344-2.5632 22.688-2.3438z"/>
            </g>
            <g transform="translate(4.0432)">
                <path d="m1275.9-1107s-50.578-33.719-82.274 20.906l-14.836-44.509s38.439-52.938 93.064-18.545c4.3834 26.975 4.0462 42.148 4.0462 42.148z"/>
                <path d="m1516-1107s50.578-33.719 82.274 20.906l14.836-44.509s-38.439-52.938-93.064-18.545c-4.3834 26.975-4.0462 42.148-4.0462 42.148z"/>
            </g>
            <path transform="translate(0 -1747.6)" d="m990.84 1137.5v132.56c111.89 34.918 254.04 55.75 409.16 55.75s297.26-20.832 409.16-55.75v-132.56c-111.89 29.531-254.03 47.156-409.16 47.156s-297.26-17.625-409.16-47.156zm0 240.03v125.41c111.89 44.37 254.05 70.844 409.16 70.844s297.27-26.474 409.16-70.844v-125.41c-111.89 39.275-254.05 62.719-409.16 62.719s-297.27-23.444-409.16-62.719zm0 222.12v25.406c0 33.915 4.1052 66.839 11.812 98.312 110 49.788 247.65 79.281 397.34 79.281s287.34-29.493 397.34-79.281c7.7073-31.473 11.812-64.397 11.812-98.312v-25.406c-111.89 48.298-254.05 77.125-409.16 77.125s-297.27-28.828-409.16-77.125zm50.937 223.88c24.036 43.448 55.762 82.005 93.344 113.88 80.894 23.763 170.49 36.938 264.88 36.938s183.98-13.174 264.88-36.938c37.582-31.87 69.308-70.426 93.344-113.88-102.78 42.318-225.78 66.875-358.22 66.875s-255.44-24.557-358.22-66.875z"/>
            <path transform="translate(0 -1747.6)" d="m1400 963c-26.751 0-50.237 13.928-63.656 34.906 16.883 15.148 39.188 24.375 63.656 24.375s46.773-9.227 63.656-24.375c-13.419-20.979-36.905-34.906-63.656-34.906z" fill="#f00"/>
            <g transform="translate(-8.0156)">
                <path d="m1318-1351.2c-18.962 0-34.344 15.351-34.344 34.312 0 14.232 8.6629 26.45 21 31.656v137.09c0 7.397 5.9469 13.344 13.344 13.344s13.344-5.9467 13.344-13.344v-137.09c12.323-5.2121 20.969-17.435 20.969-31.656 0-18.962-15.351-34.312-34.313-34.312z"/>
                <path transform="matrix(.70313 0 0 .70313 393.3 -1507.3)" d="m1345.7 270.76c0 16.855-13.664 30.519-30.519 30.519s-30.519-13.664-30.519-30.519 13.664-30.519 30.519-30.519 30.519 13.664 30.519 30.519z" fill="#ff0"/>
                <path d="m1498-1351.2c-18.962 0-34.344 15.351-34.344 34.312 0 14.232 8.6629 26.45 21 31.656v137.09c0 7.397 5.9469 13.344 13.344 13.344s13.344-5.9467 13.344-13.344v-137.09c12.323-5.2121 20.969-17.435 20.969-31.656 0-18.962-15.351-34.312-34.313-34.312z"/>
                <path transform="matrix(.70313 0 0 .70313 573.3 -1507.3)" d="m1345.7 270.76c0 16.855-13.664 30.519-30.519 30.519s-30.519-13.664-30.519-30.519 13.664-30.519 30.519-30.519 30.519 13.664 30.519 30.519z" fill="#ff0"/>
            </g>
            <g transform="translate(3.7807 -236)" fill="#fea">
                <path d="m560.53-881.61c-59.868 0.92441-115.8 29.914-159.22 104.75-179.3 309 247.96 442.49 572.22 400.53v-236.5s-225.67-271.67-413-268.78zm287.94 520c-296.56 1.6691-604.04 137.69-447.16 408.06 179.3 309 572.22-164.03 572.22-164.03v-236.53c-40.533-5.2453-82.697-7.7384-125.06-7.5z"/>
                <path d="m2231.9-881.61c59.868 0.92441 115.8 29.914 159.22 104.75 179.3 309-247.96 442.49-572.22 400.53v-236.5s225.67-271.67 413-268.78zm-287.94 520c296.56 1.6691 604.04 137.69 447.16 408.06-179.3 309-572.22-164.03-572.22-164.03v-236.53c40.533-5.2453 82.697-7.7384 125.06-7.5z"/>
            </g>
            </g>
            </g>
        </svg>
        `;
        const backgroundSVG = `
        <svg width="1920" height="1920" viewBox="0 0 1920 1920"
            xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="d" href="#c"
                        patternTransform="matrix(2.1568 0 0 2.1568 -259.21 -1696.9)" />

                <pattern id="c" width="60" height="51.9601"
                        patternTransform="translate(-259.21 -1696.9)"
                        patternUnits="userSpaceOnUse">
                <path d="m0 0v10.454l13.447 7.764v15.528l-13.447 7.764v10.451h1.5528v-7.764l13.447-7.7635 13.447 7.7635v7.764h3.1055v-7.764l13.447-7.7635 13.447 7.7635v7.764h1.5528v-10.451l-13.447-7.764v-15.528l13.447-7.764v-10.454h-1.5528v7.764l-13.447 7.7635-13.447-7.7635v-7.764h-3.1055v7.764l-13.447 7.7635-13.447-7.7635v-7.764h-1.5528zm30 10.454 13.447 7.764v15.528l-13.447 7.764-13.447-7.764v-15.528l13.447-7.764z"
                        style="stroke:#d3d3d3; fill:#d3d3d3"/>
                </pattern>
            </defs>
            <g transform="translate(259.21 1696.9)">
                <rect x="-259.21" y="-1696.9" width="1920" height="1920" fill="url(#d)" />
            </g>
        </svg>
        `;
        let background = new Image();
        background.crossOrigin = "anonymous";
        background.src = "data:image/svg+xml;charset=utf-8," + encodeURIComponent(backgroundSVG);
        background.onerror = (e) => console.error("SVG failed to load", e);
        let bee = new Image();
        bee.crossOrigin = "anonymous";
        bee.src = "data:image/svg+xml;charset=utf-8," + encodeURIComponent(beeSVG);
        bee.onerror = (e) => console.error("SVG failed to load", e);
        const increment = 4;

        const load = () => {
            console.log("load event detected!");
            intViewportWidth = window.innerWidth;
            intViewportHeight = window.innerHeight;
            setCanvasSize(intViewportWidth, intViewportHeight);
            context.drawImage(background, 0, 0);
            initBees();
        }
        const resize = () => {
            intViewportWidth = window.innerWidth;
            intViewportHeight = window.innerHeight;
            setCanvasSize(intViewportWidth, intViewportHeight);
            context.drawImage(background, 0, 0);
        }
        function setCanvasSize(w, h) {
            let cv = document.getElementById("cv");
            cv.width = w;
            cv.height = h;
        }
        function initBees() {
        	for (let i=0;i<bees;i++)
		{ 
			x[i] = intViewportWidth / 2;
			y[i] = intViewportHeight / 2;
		}
        }
        window.onload = load;
        window.onresize = resize;
        
        (function() {
  		var requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
                              window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
  		window.requestAnimationFrame = requestAnimationFrame;
	})();
        
	function draw()
	{
		context.clearRect(0,0,canvas.width,canvas.height);
	        context.drawImage(background, 0, 0);
	        for (let i=0;i<bees;i++)
		{ 
			context.drawImage(bee,x[i],y[i]);
		}
		requestAnimationFrame(draw);
		get_next_xy()
	}
	
	function get_next_xy() {
		let xdiff;
		let ydiff;
	        for (let i=0;i<bees;i++)
		{ 
			xdiff = Math.random();
			ydiff = Math.random();
			if (xdiff < 0.34) {
				x[i] += increment;
				if (x[i] > (intViewportWidth - beeWidth)) {
					x[i] -= increment;
				}
			}
			else if (xdiff > 0.66) {
				x[i] -= increment;
				if (x[i] < 0) {
					x[i] += increment;
				}			}
			if (ydiff < 0.34) {
				y[i] += increment;
				if (y[i] > (intViewportHeight - beeHeight)) {
					y[i] -= increment;
				}
			}
			else if (ydiff > 0.66) {
				y[i] -= increment;
				if (y[i] < 0) {
					y[i] += increment;
				}			
			}
		}
	}
	
	requestAnimationFrame(draw);        
        
    </script>
</body>