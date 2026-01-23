<!DOCTYPE HTML>
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
    <h1>A canvas demo</h1>
    <canvas id="cv" width="700" height="450" style="border:1px solid #000000"></canvas>
    <p id="status"></p>
    <script>
        var canvas = document.getElementById('cv');
        var context = canvas.getContext('2d');

        //set up the variables which are used by all circles

        var radius = 20;
        var startAngle = 0;
        var endAngle = 2 * Math.PI;
        var max_random_y = canvas.height - (radius * 3);
        var max_random_x = canvas.width - (radius * 3);
        slices = 128;
        var circles = 20;
        var counter = 0;
        var start_xdiff = max_random_x / slices; // co-ord change set by longest distance to go, here = x

        //document.getElementById("test").innerHTML = start_xdiff + "<br>";
        //var displayed_test = 0;



        //set up the arrays (keep it simple) for the circles

        var x = new Array();
        var y = new Array();
        var direction = new Array();
        var target_x = new Array();
        var target_y = new Array();
        var xdiff = new Array();
        var ydiff = new Array();
        var shades = ["#0000FF", "#FF7F50", "#6495ED", "#228B22", "#DDA0DD", "#5F9EA0", "#ADD8E6", "#FFDAB9", "#FA8072",
            "#4682B4", "#0000FF", "#FF7F50", "#6495ED", "#228B22", "#DDA0DD", "#5F9EA0", "#ADD8E6", "#FFDAB9",
            "#FA8072", "#4682B4"
        ];

        //initialise the arrays for the circles - all start at top left and go towards right edge

        for (var i = 0; i < circles; i++) {
            x[i] = 0.0;
            y[i] = 0.0;
            direction[i] = "start right";
            target_x[i] = 0;
            target_y[i] = 0;
            xdiff[i] = 0.0;
            ydiff[i] = 0.0;
        }

        (function() {
            var requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
                window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
            window.requestAnimationFrame = requestAnimationFrame;
        })();

        function draw() {
            context.clearRect(0, 0, canvas.width, canvas.height);
            for (var i = 0; i < circles; i++) {
                context.beginPath();
                context.arc(x[i], y[i], radius, startAngle, endAngle);
                context.closePath();
                context.fillStyle = shades[i];
                context.fill();
                get_next_xy(i);
            }
            counter += 1;
            document.getElementById("status").innerHTML = counter + " frames.";
            requestAnimationFrame(draw);
        }


        function get_next_xy(circ) {
            switch (direction[circ]) {
                case "start right":
                    target_x[circ] = canvas.width - radius; //set target of x to be right side
                    target_y[circ] = Math.floor((Math.random() * max_random_y) +
                        radius) // y to be random between radius and bottom
                    x[circ] += start_xdiff;
                    y[circ] += target_y[circ] / slices;
                    direction[circ] = "going right";
                    break;
                case "going right":
                    if (x[circ] < target_x[circ]) {
                        x[circ] += start_xdiff; // x is getting bigger towards right edge
                        y[circ] += target_y[circ] / slices; // and y is getting bigger
                    } else {
                        direction[circ] = "going down";
                        target_y[circ] = canvas.height - radius; // y target now bottom
                        target_x[circ] = Math.floor((Math.random() * max_random_x) +
                        radius); // x target is random but not less than radius
                        if ((target_y[circ] - y[circ]) >= (x[circ] - target_x[
                            circ])) // if the x-distance to go is greater than the y distance
                        {
                            ydiff[circ] = start_xdiff; // else y distance is longer and it sets the pace
                            xdiff[circ] = (x[circ] - target_x[circ]) / ((target_y[circ] - y[circ]) /
                            start_xdiff); // and x has to match it
                        } else {
                            xdiff[circ] = start_xdiff; // then x sets the pace
                            ydiff[circ] = (target_y[circ] - y[circ]) / ((x[circ] - target_x[circ]) /
                                start_xdiff) // y has to match it
                        }
                        y[circ] += ydiff[circ]; // y is still getting bigger to bottom edge
                        x[circ] -= xdiff[circ]; // but x has to get smaller
                    }
                    break;
                case "going down":
                    if (y[circ] < target_y[circ]) {
                        y[circ] += ydiff[circ];
                        x[circ] -= xdiff[circ];
                    } else {
                        direction[circ] = "going left";
                        target_x[circ] = radius; // x target now left side
                        target_y[circ] = Math.floor((Math.random() * max_random_y) + radius);
                        if ((x[circ] - target_x[circ]) >= (y[circ] - target_y[
                            circ])) // if the x-distance to go is greater than the y distance
                        {
                            xdiff[circ] = start_xdiff; // then x sets the pace
                            ydiff[circ] = (y[circ] - target_y[circ]) / ((x[circ] - target_x[circ]) /
                                start_xdiff) // y has to match it
                        } else {
                            ydiff[circ] = start_xdiff; // else y distance is longer and it sets the pace
                            xdiff[circ] = (x[circ] - target_x[circ]) / ((y[circ] - target_y[circ]) /
                            start_xdiff); // and x has to match it
                        }

                        y[circ] -= ydiff[circ]; // x is still getting smaller to left edge
                        x[circ] -= xdiff[circ]; // y also getting smaller
                    }
                    break;
                case "going left":
                    if (x[circ] > target_x[circ]) {
                        y[circ] -= ydiff[circ]; // x is still getting smaller to left edge
                        x[circ] -= xdiff[circ]; // y also getting smaller
                    } else {
                        direction[circ] = "going up";
                        target_y[circ] = radius; // y target now top edge
                        target_x[circ] = Math.floor((Math.random() * max_random_x) + radius);
                        if ((target_x[circ] - x[circ]) >= (y[circ] - target_y[
                            circ])) // if the x-distance to go is greater than the y distance
                        {
                            xdiff[circ] = start_xdiff; // then x sets the pace
                            ydiff[circ] = (y[circ] - target_y[circ]) / ((target_x[circ] - x[circ]) /
                                start_xdiff) // y has to match it
                        } else {
                            ydiff[circ] = start_xdiff; // else y distance is longer and it sets the pace
                            xdiff[circ] = (target_x[circ] - x[circ]) / ((y[circ] - target_y[circ]) /
                            start_xdiff); // and x has to match it
                        }
                        x[circ] += xdiff[circ]; // x is getting bigger to random point
                        y[circ] -= ydiff[circ]; // y is still getting smaller to top
                    }
                    break;
                case "going up":
                    if (y[circ] > target_y[circ]) {
                        x[circ] += xdiff[circ]; // x is getting bigger to random point
                        y[circ] -= ydiff[circ]; // y is still getting smaller to top
                    } else {
                        direction[circ] = "start right";
                    }
                    break
            }
        }

        requestAnimationFrame(draw);
    </script>
</body>

</html>
