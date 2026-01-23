<!DOCTYPE HTML>
<html>

<head>

    <style type="text/css">
        h1.question {
            color: red;
        }

        td.box {
            width: 150px;
            height: 200px;
            border-spacing: 0px;
            border: 1px solid #aaaaaa;
        }

        td.buffer {
            width: 150px;
            height: 600px;
            border: 1px solid #aaaaaa;
        }

        .wrapper {
            margin: 0 auto;
            position: relative;
            width: 900px;
        }
    </style>

    <script>
        var whats_where = new Array(); //stores the starting order
        whats_where[0] = "06";
        whats_where[1] = "04";
        whats_where[2] = "00";
        whats_where[3] = "01";
        whats_where[4] = "08";
        whats_where[5] = "02";
        whats_where[6] = "03";
        whats_where[7] = "05";
        whats_where[8] = "07";

        var correct = new Array(); //stores the ids of the correct order
        correct[0] = "00";
        correct[1] = "01";
        correct[2] = "02";
        correct[3] = "03";
        correct[4] = "04";
        correct[5] = "05";
        correct[6] = "06";
        correct[7] = "07";
        correct[8] = "08";

        function allowDrop(ev) {
            ev.preventDefault();
        }


        function drag(ev) {
            ev.dataTransfer.setData("picked_up", ev.target.id);
            document.getElementById("statusbar").innerHTML = ""; //clear the status bar
            document.getElementById("being_dragged").innerHTML = ev.target.id; //store the id of the image being dragged
        }

        function itisright() {
            for (var i = 0; i < correct.length; i++) {
                if (whats_where[i] != correct[i]) return false; //if any image not in correct place reject
            }
            return true; //if all pass then image is correctly assembled
        }

        function drop(ev) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("picked_up");
            ev.target.appendChild(document.getElementById(data)); //overwrites the box with the dragged image
            var sq = ev.target.id;
            whats_where[sq.valueOf() - 1] = document.getElementById("being_dragged")
            .innerHTML; //stores id of the dragged image in its new place in the order
            if (itisright()) {
                document.getElementById("statusbar").innerHTML = "You have correctly assembled the image. Well done!";
            } else {
                document.getElementById("statusbar").innerHTML = "";
            }
            //document.getElementById("statusbar").innerHTML=whats_where ;
        }
    </script>

</head>

<body>
    <div class="wrapper">

        <table>
            <tr>
                <td id="1" class="box" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <div id="06" draggable="true" ondragstart="drag(event)">


                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150 199"
                            preserveAspectRatio="xMidYMid meet">


                            <g transform="translate(0.000000,199.000000) scale(0.100000,-0.100000)" fill="#000000"
                                stroke="none">

                                <path d="M1100 1983 c1 -22 53 -206 60 -213 3 -3 5 -11 6 -17 1 -7 2 -25 3
                                    -40 2 -22 4 -24 9 -10 8 18 20 -26 82 -293 67
                                    -291 59 -535 -30 -870 -23 -87
                                    -22 -105 7 -134 47 -47 206 -125 256 -126 4 0 7 152 7 338 0 221 -4 332 -10
                                    322 -5 -8 -10 -26 -11 -40 0 -23 -1 -23 -8 -5
                                    -15 36 -41 188 -46 275 -3 47
                                    -8 105 -10 130 -3 31 -1 40 5 30 5 -8 10 -24 10 -35 0 -19 59 -267 65 -273 2
                                    -2 4 215 4 482 l1 486 -200 0 c-110 0 -200 -3
                                    -200 -7z" />
                            </g>

                        </svg>


                    </div>
                </td>
                <td id="2" class="box" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <div id="04" draggable="true" ondragstart="drag(event)">



                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150.000000 198.000000"
                            preserveAspectRatio="xMidYMid meet">
                            <g transform="translate(0.000000,198.000000) scale(0.100000,-0.100000)" fill="#000000"
                                stroke="none">

                                <path d="M0 1625 l0 -105 153 -1 c135 0 164 -3 257 -28 58 -16 126 -37 153
                                    -47 55 -22 84 -12 79 27 -7 57 -172 155 -309 184 -43 9 -130 30 -193 46 -63
                                    16 -120 29 -127 29 -10 0 -13 -27 -13 -105z" />

                                <path d="M1420 1670 c-77 -24 -260 -123 -289 -155 -35 -41 -37 -48 -15 -66 22
                                    -18 74 -15 120 8 21 11 68 25 104 32 36 6 86 16 113 22 l47 11 0 79 0 79 -27
                                    -1 c-16 0 -39 -4 -53 -9z" />

                                <path d="M176 1451 c-44 -9 -43 -29 1 -37 177 -31 277 -74 321 -138 28 -41 56
                                    -169 47 -216 -16 -83 -96 -180 -184 -221 -160 -74 -243 -125 -262 -161 -21
                                    -39 3 -35 126 23 33 15 84 37 112 48 192 75 261 149 289 309 14 82 6 159 -22
                                    214 -16 33 -79 98 -94 98 -5 0 -37 13 -72 29 -67 30 -181 62 -214 60 -10 -1
                                    -32 -4 -48 -8z" />

                                <path d="M1176 1249 c-14 -17 -26 -37 -26 -45 0 -7 -11 -47 -25 -88 -24 -73
                                    -34 -176 -16 -176 5 0 12 -15 15 -33 9 -51 116 -207 116 -170 0 4 -18 60 -40
                                    123 -50 145 -54 231 -14 325 34 80 38 95 26 95 -6 0 -22 -14 -36 -31z" />

                                <path d="M697 1093 c-2 -5 -12 -30 -21 -58 -9 -27 -32 -75 -51 -105 -19 -30
                                    -49 -80 -66 -110 -18 -30 -48 -71 -67 -92 -60 -67 -108 -221 -127 -408 -7 -79
                                    11 -95 96 -84 47 6 48 7 55 48 6 36 8 38 14 16 6 -24 9 -25 84 -25 113 0 116
                                    6 128 211 7 126 6 159 -4 165 -25 16 -34 9 -93 -66 -45 -58 -61 -86 -89 -161
                                    -22 -60 -25 -65 -25 -36 -1 38 25 99 98 229 27 50 56 115 65 144 17 64 31 325
                                    17 333 -5 4 -12 3 -14 -1z" />

                                <path d="M884 643 c-11 -24 -14 -301 -4 -329 11 -28 59 -44 134 -44 70 0 86
                                    10 86 55 0 77 -105 310 -147 326 -37 14 -60 11 -69 -8z" />

                                <path d="M0 215 l0 -215 76 0 c69 0 75 2 68 18 -12 29 -17 162 -6 162 13 0 6
                                    94 -9 124 -13 25 -110 126 -121 126 -4 0 -8 -97 -8 -215z" />
                            </g>

                        </svg>


                    </div>
                </td>
                <td id="3" class="box" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <div id="00" draggable="true" ondragstart="drag(event)">


                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150.000000 199.000000"
                            preserveAspectRatio="xMidYMid meet">

                            <g transform="translate(0.000000,199.000000) scale(0.100000,-0.100000)" fill="#000000"
                                stroke="none">

                                <path d="M1460 1725 c-143 -50 -331 -178 -484 -331 -112 -112 -269 -362 -316
                                    -504 -48 -142 -100 -423 -100 -536 0 -40 -5 -75 -12 -82 -9 -9 -9 -17 -1 -34
                                    11 -22 24 -108 28 -179 1 -19 5 -41 9 -47 5 -9 116 -12 437 -12 401 0 430 1
                                    435 18 3 9 14 35 25 57 18 37 19 63 19 366 0 267 -3 331 -15 355 -27 56 -30
                                    160 -6 254 20 79 21 106 19 386 l-3 301 -35 -12z" />
                            </g>

                        </svg>


                    </div>
                </td>
                <td id="parking" rowspan="3" class="buffer" ondrop="drop(event)" ondragover="allowDrop(event)">
                </td>
            </tr>
            <tr>
                <td id="4" class="box" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <div id="01" draggable="true" ondragstart="drag(event)">


                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150.000000 199.000000"
                            preserveAspectRatio="xMidYMid meet">
                            <g transform="translate(0.000000,199.000000) scale(0.100000,-0.100000)" fill="#000000"
                                stroke="none">

                                <path d="M819 1915 c-3 -2 -63 -6 -135 -8 -71 -3 -147 -10 -169 -16 -22 -6
                                    -96 -24 -165 -41 -108 -26 -158 -42 -322 -102 l-28 -10 0 -307 0 -306 29 60
                                    c40 85 109 161 208 232 312 220 475 299 718 347 143 28 306 46 427 46 l118 0
                                    0 35 c0 21 -5 35 -12 35 -7 0 -67 8 -133 16 -112 15 -526 29 -536 19z" />

                                <path d="M85 840 c-7 -34 -49 -72 -71 -63 -12 4 -14 -42 -14 -323 0 -180 2
                                    -325 4 -323 9 9 59 160 82 249 27 107 51 368 40 443 -8 54 -31 64 -41 17z" />
                            </g>

                        </svg>


                    </div>
                </td>
                <td id="5" class="box" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <div id="08" draggable="true" ondragstart="drag(event)">


                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150.000000 199.000000"
                            preserveAspectRatio="xMidYMid meet">


                            <g transform="translate(0.000000,199.000000) scale(0.100000,-0.100000)" fill="#000000"
                                stroke="none">

                                <path d="M565 1955 c-109 -39 -144 -90 -161 -230 -7 -64 -15 -75 -54 -75 -25
                                    0 -25 0 -25 -94 l0 -93 -37 -42 c-21 -22 -38 -51 -38 -64 0 -12 -7 -47 -16
                                    -77 -8 -30 -22 -85 -29 -123 -12 -57 -21 -74 -60 -115 l-46 -47 32 -28 c17
                                    -16 44 -52 59 -80 15 -29 32 -52 36 -52 5 0 12 37 16 82 10 120 33 230 60 293
                                    14 30 31 71 38 90 7 19 28 64 45 100 18 36 36 81 40 100 4 19 22 67 40 105 18
                                    39 42 99 53 135 11 36 32 92 48 125 43 93 44 94 36 98 -4 2 -20 -2 -37 -8z" />

                                <path d="M115 1758 c-11 -6 -41 -32 -67 -56 l-48 -45 0 -139 0 -138 96 0 c70
                                    0 95 3 92 12 -3 7 -18 16 -36 20 -26 7 -33 15 -46 62 -9 30 -16 86 -16 125 0
                                    69 1 73 40 115 22 24 40 46 40 50 0 10 -33 6 -55 -6z" />

                                <path d="M18 993 c-16 -4 -18 -22 -18 -193 l0 -188 41 -7 c58 -10 72 7 35 42
                                    -38 35 -59 87 -52 132 3 20 8 67 11 106 7 80 9 85 36 85 10 0 19 7 19 15 0 15
                                    -33 19 -72 8z" />
                            </g>

                        </svg>


                    </div>
                </td>
                <td id="6" class="box" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <div id="02" draggable="true" ondragstart="drag(event)">


                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150.000000 199.000000"
                            preserveAspectRatio="xMidYMid meet">


                            <g transform="translate(0.000000,199.000000) scale(0.100000,-0.100000)" fill="#000000"
                                stroke="none">

                                <path d="M0 1845 c0 -19 2 -35 4 -35 18 0 227 -43 248 -51 14 -6 36 -8 48 -4
                                    20 6 20 8 5 25 -15 16 -137 60 -250 89 -55 15 -55 15 -55 -24z" />

                                <path d="M548 798 c-4 -278 -3 -328 5 -413 14 -133 25 -185 58 -287 l32 -98
                                    108 0 108 0 -15 51 c-8 28 -22 87 -29 132 -8 44 -26 110 -40 146 -31 82 -109
                                    343 -130 436 -9 38 -20 74 -25 80 -5 5 -17 34 -27 64 -34 100 -43 79 -45 -111z" />
                            </g>

                        </svg>


                    </div>
                </td>
            </tr>
            <tr>
                <td id="7" class="box" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <div id="03" draggable="true" ondragstart="drag(event)">


                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150.000000 198.000000"
                            preserveAspectRatio="xMidYMid meet">

                            <g transform="translate(0.000000,198.000000) scale(0.100000,-0.100000)" fill="#000000"
                                stroke="none">

                                <path d="M590 1974 c0 -3 9 -50 20 -103 19 -95 43 -160 113 -311 19 -41 51
                                    -124 72 -184 51 -152 52 -230 2 -374 -20 -57 -51 -124 -70 -150 -94 -132 -141
                                    -290 -117 -394 37 -153 212 -364 316 -381 11 -1 24 -5 29 -8 6 -4 28 -12 50
                                    -19 22 -7 52 -21 67 -31 23 -17 47 -19 227 -19 l201 0 0 218 0 217 -65 53
                                    c-36 29 -65 60 -65 68 0 8 20 24 45 35 25 11 45 24 45 28 0 4 -44 8 -98 8
                                    -129 0 -137 5 -152 93 -17 98 -17 312 -1 385 18 84 66 169 120 214 53 44 118
                                    81 143 81 10 0 18 7 18 15 0 13 -7 15 -37 9 -21 -4 -46 -11 -55 -15 -22 -12
                                    -68 -12 -68 0 0 5 15 27 33 49 32 41 71 62 113 62 24 0 24 1 24 111 l0 112
                                    -84 -6 c-46 -3 -86 -4 -89 -1 -3 3 11 33 32 67 20 34 48 88 63 120 l28 57
                                    -430 0 c-237 0 -430 -3 -430 -6z m535 -1520 c33 -9 81 -19 108 -24 68 -14 194
                                    -74 228 -111 49 -53 30 -119 -35 -119 -25 0 -40 11 -80 56 -50 57 -146 125
                                    -233 165 -26 12 -66 30 -88 41 l-40 19 40 -7 c22 -3 67 -12 100 -20z" />
                            </g>

                        </svg>


                    </div>
                </td>
                <td id="8" class="box" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <div id="05" draggable="true" ondragstart="drag(event)">





                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150.000000 198.000000"
                            preserveAspectRatio="xMidYMid meet">


                            <g transform="translate(0.000000,198.000000) scale(0.100000,-0.100000)" fill="#000000"
                                stroke="none">

                                <path d="M650 1972 c0 -5 9 -35 20 -67 11 -32 20 -64 20 -71 0 -7 23 -45 50
                                    -85 28 -40 50 -76 50 -80 0 -5 13 -27 28 -51 16 -24 37 -64 48 -90 25 -62 49
                                    -65 41 -5 -4 23 -9 78 -12 122 -3 44 -13 137 -22 208 l-16 127 -104 0 c-56 0
                                    -103 -4 -103 -8z" />

                                <path d="M58 1696 l-58 -9 0 -85 c0 -76 2 -83 18 -77 9 3 85 9 167 12 170 6
                                    205 17 205 61 0 35 -23 68 -60 87 -35 18 -189 24 -272 11z" />

                                <path d="M109 1424 c-92 -15 -109 -22 -109 -44 0 -16 14 -18 143 -22 177 -6
                                    218 -19 297 -97 75 -74 84 -104 75 -265 -12 -224 -46 -357 -101 -393 -38 -25
                                    -132 -20 -243 12 -88 26 -146 32 -156 16 -11 -18 40 -63 80 -71 22 -4 72 -19
                                    110 -33 103 -37 194 -64 242 -72 55 -9 93 19 125 89 22 49 23 60 23 321 l-1
                                    270 -32 76 c-37 87 -68 121 -143 156 -135 63 -197 75 -310 57z" />

                                <path d="M831 433 c-66 -13 -238 -77 -276 -103 -84 -58 -141 -146 -150 -232
                                    -9 -84 5 -91 62 -32 119 122 222 211 266 232 26 12 88 32 138 43 115 27 143
                                    51 97 83 -22 15 -82 19 -137 9z" />
                            </g>

                        </svg>


                    </div>
                </td>
                <td id="9" class="box" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <div id="07" draggable="true" ondragstart="drag(event)">



                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150.000000 199.000000"
                            preserveAspectRatio="xMidYMid meet">
                            <g transform="translate(0.000000,199.000000) scale(0.100000,-0.100000)" fill="#000000"
                                stroke="none">

                                <path d="M0 1696 l0 -294 33 -5 c17 -3 63 -4 100 -3 60 1 70 4 86 25 18 23 19
                                    24 25 4 11 -34 97 -63 190 -63 61 0 74 15 27 31 -28 10 -86 71 -108 114 -46
                                    90 -3 218 78 231 29 5 45 1 76 -20 39 -26 40 -28 32 -64 -5 -20 -12 -81 -15
                                    -135 -6 -84 -4 -100 11 -117 45 -50 177 -79 205 -46 9 12 4 19 -29 40 -47 30
                                    -61 68 -61 167 0 121 40 203 94 194 47 -9 117 -49 111 -63 -14 -36 -21 -144
                                    -16 -227 l6 -90 37 -12 c42 -14 165 -20 175 -9 4 4 -5 29 -20 56 -51 91 -55
                                    195 -10 283 16 32 35 34 86 7 20 -11 43 -20 50 -20 17 0 27 -180 15 -290 -3
                                    -23 1 -25 62 -35 73 -11 140 -8 140 7 0 6 -16 28 -35 49 -33 37 -35 43 -35
                                    113 0 95 15 174 40 208 11 15 20 30 20 33 0 12 -34 3 -98 -28 l-69 -33 -23 33
                                    -23 34 29 30 c35 36 27 56 -32 76 -38 14 -243 20 -275 9 -19 -7 -357 -35 -444
                                    -37 -120 -3 -159 8 -215 58 -27 24 -52 53 -55 63 -6 18 -16 20 -86 20 l-79 0
                                    0 -294z m219 3 c26 -19 27 -23 20 -67 -4 -26 -8 -78 -8 -116 -1 -58 -3 -67
                                    -13 -53 -7 9 -34 25 -61 36 -56 24 -97 62 -97 91 0 30 28 69 74 101 47 35 49
                                    35 85 8z" />

                                <path d="M0 772 l0 -489 42 -17 c91 -37 351 -100 475 -115 43 -6 145 -20 228
                                    -31 187 -26 216 -25 226 12 15 56 65 104 155 147 120 57 241 98 313 107 42 4
                                    61 11 61 20 0 11 -24 14 -112 15 -164 0 -498 27 -498 40 0 9 65 50 85 53 28 4
                                    39 23 17 30 -36 12 -47 82 -34 221 6 67 14 130 18 139 3 9 21 23 40 32 56 27
                                    37 53 -38 54 -31 0 -106 -27 -125 -44 -11 -10 -25 -127 -38 -323 -2 -29 -6
                                    -57 -9 -62 -4 -5 -31 -15 -62 -21 -47 -10 -59 -9 -80 4 -22 15 -24 22 -23 104
                                    1 194 29 275 107 307 17 8 32 18 32 23 0 25 -213 23 -238 -2 -24 -24 -45 -146
                                    -46 -271 l-1 -120 -35 -3 c-57 -6 -108 15 -126 50 -27 52 -11 180 34 275 14
                                    31 53 53 93 53 35 0 20 29 -17 36 -32 6 -165 -9 -185 -21 -4 -3 -21 -39 -38
                                    -80 -27 -65 -32 -89 -34 -175 l-2 -100 -45 -1 c-66 -2 -73 0 -94 24 -26 31
                                    -18 106 21 188 39 84 61 109 95 109 15 0 30 5 34 12 10 16 -27 40 -52 34 -18
                                    -5 -23 1 -34 37 -6 23 -27 67 -45 97 -18 30 -36 72 -39 92 -19 112 -25 12 -26
                                    -440z" />

                                <path d="M1234 1001 c-17 -4 -48 -16 -70 -27 -45 -22 -52 -45 -34 -108 12 -45
                                    18 -111 19 -227 l1 -76 68 -23 c64 -20 72 -20 105 -6 21 8 37 19 37 23 0 4
                                    -24 19 -53 33 l-52 25 -3 130 c-2 121 -1 134 21 175 18 34 31 46 53 50 17 3
                                    29 11 29 20 0 17 -70 23 -121 11z" />

                                <path d="M1472 983 c-43 -8 -54 -42 -42 -129 6 -44 15 -115 20 -159 5 -44 9
                                    -81 9 -82 1 -2 10 -3 21 -3 19 0 20 7 20 190 0 105 -1 189 -2 189 -2 -1 -13
                                    -4 -26 -6z" />
                            </g>

                        </svg>


                    </div>
                </td>
            </tr>
        </table>
        <br>
        <h2>Drag and Drop the image fragments onto EMPTY squares</h2>
        <h3>
            <div id="statusbar">
        </h3>
    </div>
    <div hidden id="being_dragged"></div>
</body>

</html>
