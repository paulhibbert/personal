<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/buttons-min.css">
    <title>Fairly random password generator</title>

    <style>
        body {
            font-family: "BlinkMacSystemFont", -apple-system, "Segoe UI", "Roboto", "Helvetica", "Arial", "Droid Sans", sans-serif;
        }

        .container {
            margin: 0 auto;
            position: relative;
            max-width: 99%;
        }

        #sortable {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .box {
            min-width: 2.4em;
            float: left;
            text-align: center;
            margin-right: 0.1em;
            cursor: pointer;
            background-color: LightCyan;
            color: #404040;
            border: 1px solid #aaaaaa;
        }

        .noshow {
            display: none
        }

        .nofloat {
            clear: both;
            padding-top: 20px
        }

        p.long {
            word-wrap: break-word;
        }

        .custom-button {
            border-radius: 1vh;
            background: rgb(6, 78, 160);
            /* this is a dark blue */
            color: white;
            font-size: 80%;
        }
    </style>

    <script type="text/javascript">
        var random_word;
        var scrambled;
        var w;
        var started = 0;
        /* 
        * Replace the following with any combination or length of potential characters to use in your passwords.
        * I have chosen not to use capital O and lower case l as these can be confused with zero and 1 in my experience.
        */
        var alphanum = "0123456789ABCDEFGHIJKLMNPQRSTUVWXYZ$&()[]{}abcdefghijkmnopqrstuvwxyz@>:;^!+-~=_#01234567890abcdefghijkmnopqrstuvwxyz";

        function get_word() {
            random_word = alphanum;
            put_word();
            started = 1;
        }

        function get_pword() {
            if (started) {
                var ele = document.getElementsByClassName("box");
                for (var i = 0; i < ele.length; i++) {
                    ele[i].style.backgroundColor = "LightCyan";						//reset the colours in case multiple runs
                    ele[i].style.color = "#404040";
                }
                var pLen = document.getElementById("pLength").value;
                var out = "";
                var chosen = "";
                var idx = 0;
                for (var i = 0; i < pLen; i++) {
                    idx = Math.floor((Math.random() * scrambled.length));           //generate random index into the near alphanumeric string
                    chosen = scrambled.substr(idx, 1);                              //retrieve it
                    document.getElementById(idx).style.backgroundColor = "green";   //display that it has been used (can use more than once)
                    document.getElementById(idx).style.color = "white";
                    out += chosen;                                                  //add to the output string
                }
                document.getElementById("output").innerHTML = out;                  //display the final randomized string
            }
        }

        function put_word() {
            scrambled = scramble(random_word, random_word.length);
            var list = document.getElementById("sortable");
            var letters = scrambled.length;
            var out = " ";
            for (var i = 0; i < letters; i++) {
                out += "<li id='" + i + "' class='box'><p>" + scrambled.charAt(i) + "</p></li>";
            }
            list.innerHTML = out;                                                   //replace the whole list of boxes with newly minted ones
        }

        function scramble(inStr, chrs) {
            var outStr = "";							    //initialise an output String variable
            var in_idx = new Array(chrs);
            for (var j = 0; j < in_idx.length; j++)			//initialise an array with 0 up to the length of the string (e.g. 0,1,2,3,4,5,6)
            {
                in_idx[j] = j;
            }
            var out_idx = new Array();						//initialise an array for the jumbled index
            while (true) {
                var new_idx = Math.floor((Math.random() * in_idx.length));	//generate a new random index into the string
                var unique = 1;							    //assume it is unique
                for (var k = 0; k < out_idx.length; k++) {
                    if (in_idx[new_idx] == out_idx[k])		// check to see if that idx is already there
                    {
                        unique = 0;					        //if already have it then say so, cannot use it twice
                    }
                }
                if (unique == 1) {
                    out_idx.push(in_idx[new_idx]);			//if still unique then we can use it.
                    if (in_idx.length == 1) {
                        break;						        //if that was the last letter to use then exit this forever loop
                    }
                    in_idx.splice(new_idx, 1);				//otherwise remove idx from the in-array so cannot use it again
                }
            }

            for (var i = 0; i < out_idx.length; i++)		// output the string based on the scrambled order.
            {
                outStr += inStr.charAt(out_idx[i]);
            }
            return outStr;							        // return the scrambled string
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('input[id="pLength"]').onchange = changeEventHandler;
        }, false);

        function changeEventHandler(event) {
            get_pword();
        }

        function copy_pword() {
            /* source: https://hackernoon.com/copying-text-to-clipboard-with-javascript-df4d4988697f */
            var el = document.createElement('textarea');
            el.value = document.querySelector("#output").textContent;
            el.setAttribute('readonly', '');
            el.style.position = 'absolute';
            el.style.left = '-9999px';
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
        }
    </script>
</head>

<body>
    <div class="container">
        <h3>Generate Password from Scrambled Input</h3>
        <p>Click start to get a jumbled up set of mostly alphanumeric characters, and then scramble them as many times as
            you like. When finished click on generate to create a password as many times as you like. Change the length to
            regenerate.</p>
        <p>There are no doubt better ways to do this, but this is mine.</p>
        <ul id="sortable">
            <li class="box">
                <p>S</p>
            </li>
            <li class="box">
                <p>t</p>
            </li>
            <li class="box">
                <p>a</p>
            </li>
            <li class="box">
                <p>r</p>
            </li>
            <li class="box">
                <p>t</p>
            </li>
        </ul>
    </div>
    <div class="container nofloat">
        <button class="pure-button custom-button" onclick="get_word()">Start</button>
        <button class="pure-button custom-button" onclick="put_word()">Scramble</button>
        <button class="pure-button custom-button" onclick="get_pword()">Generate</button>
        <button class="pure-button custom-button" onclick="copy_pword()">Copy to Clipboard</button>
        <p class="long" id="output"></p>
        <p>Password length: <input id="pLength" type="number" min="8" value="16"></p>
    </div>

</html>