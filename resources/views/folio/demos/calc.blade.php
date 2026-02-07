<!DOCTYPE html>
<html lang="en-GB">

<head>
    <title>Simple Calculator</title>
    <meta charset="utf-8">
    <meta name="description" content="Simple calculator made with Vue">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <style>
        body {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            font-size:10vh;
        }
        .wrapper{
            width:90vw;
            margin:auto;
        }
        .display{
            width:100%;
            text-align: right;
            height:14vh;
            line-height:14vh;
            font-size:8vh;
        }
        .displayInput{
            font-size:5vh;
            overflow: hidden;
            overflow-x: auto;
            display: block;
            white-space: nowrap;
        }
        .buttonGrid{
            display:grid;
            grid-template-columns: 25% 25% 25% 25%;
            border-color:grey;
            border-style:solid;
            border-width: 0px 2px 2px 0px;
        }
        .calcButton{
            height:12vh;
            line-height: 12vh;
            text-align:center;
            border-color:inherit;
            border-style:inherit;
            border-width: 2px 0px 0px 2px;
            background:aliceblue;
            -webkit-user-select: none; /* Safari 3.1+ */
            -moz-user-select: none; /* Firefox 2+ */
            -ms-user-select: none; /* IE 10+ */
            user-select: none; /* Standard syntax */
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.min.js"></script>
</head>

<body>
<div id="app" class="wrapper">
    <div id="displayInput" class="display displayInput">@{{ inputDisplay }}</div>
    <div id="displayResult" class="display">@{{ resultDisplay }}</div>
    <div class="buttonGrid">
        <div class="calcButton" data-button="1" v-on:click="calculatorInput">1</div>
        <div class="calcButton" data-button="2" v-on:click="calculatorInput">2</div>
        <div class="calcButton" data-button="3" v-on:click="calculatorInput">3</div>
        <div class="calcButton" data-button="+" v-on:click="calculatorInput"><svg xmlns="http://www.w3.org/2000/svg" data-button="+" width="100%" height="100%" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line data-button="+" x1="12" y1="5" x2="12" y2="19"></line><line data-button="+" x1="5" y1="12" x2="19" y2="12"></line></svg></div>
        <div class="calcButton" data-button="4" v-on:click="calculatorInput">4</div>
        <div class="calcButton" data-button="5" v-on:click="calculatorInput">5</div>
        <div class="calcButton" data-button="6" v-on:click="calculatorInput">6</div>
        <div class="calcButton" data-button="-" v-on:click="calculatorInput"><svg xmlns="http://www.w3.org/2000/svg" data-button="-" width="100%" height="100%" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line data-button="-" x1="5" y1="12" x2="19" y2="12"></line></svg></div>
        <div class="calcButton" data-button="7" v-on:click="calculatorInput">7</div>
        <div class="calcButton" data-button="8" v-on:click="calculatorInput">8</div>
        <div class="calcButton" data-button="9" v-on:click="calculatorInput">9</div>
        <div class="calcButton" data-button="/" v-on:click="calculatorInput">/</div>
        <div class="calcButton" data-button="." v-on:click="calculatorInput">.</div>
        <div class="calcButton" data-button="0" v-on:click="calculatorInput">0</div>
        <div class="calcButton" data-button="^" v-on:click="getRoot"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"><path d="M3,12H4.31a1,1,0,0,1,.93.65L8,20,10.85,4.82a1,1,0,0,1,1-.82H21" style="fill: none; stroke: black; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/></svg></div>
        <div class="calcButton" data-button="*" v-on:click="calculatorInput"><svg xmlns="http://www.w3.org/2000/svg" data-button="*" width="100%" height="100%" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line data-button="*" x1="18" y1="6" x2="6" y2="18"></line><line data-button="*" x1="6" y1="6" x2="18" y2="18"></line></svg></div>
        <div class="calcButton" v-on:click="clearInput"><svg xmlns="http://www.w3.org/2000/svg" width="60%" height="100%" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></div>
        <div class="calcButton" data-button="(" v-on:click="calculatorInput">(</div>
        <div class="calcButton" data-button=")" v-on:click="calculatorInput">)</div>
        <div class="calcButton" v-on:click="backSpace"><svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg></div>
    </div>
</div>
<script>
    var vm = new Vue({
        el: '#app',
        data: {
            inputDisplay: '',
            resultDisplay: ''
        },
        updated: function () {
            if(document.getElementById("displayResult").scrollWidth > document.getElementById("displayResult").offsetWidth){
                this.resultDisplay = (this.resultDisplay * 1).toExponential(4);
            }
        },
        methods: {
            calculatorInput: function (event) {
                if (event) {
                    this.inputDisplay = this.inputDisplay + event.target.dataset.button;
                    displayResult();
                }
            },
            clearInput: function () {
                this.inputDisplay = '';
                this.resultDisplay = '';
            },
            backSpace: function () {
                this.inputDisplay = this.inputDisplay.slice(0,-1);
                displayResult();
            },
            getRoot: function () {
                try{
                    temp = evaluate(this.inputDisplay);
                    this.resultDisplay = (Math.sqrt(temp) * 1).toFixed(5).toString();
                    this.inputDisplay = 'sqrt(' + this.inputDisplay + ')'; 
                }
                catch(error){
                    this.resultDisplay = 'error';
                }
            }
        }
    })
    
    function evaluate(expr) {
        if (!/^[0-9+\-*/().\sA-Za-z]+$/.test(expr)) {
            throw new Error("Invalid characters");
        }

        const output = [];
        const ops = [];
        const prec = { "sqrt": 3, "*": 2, "/": 2, "+": 1, "-": 1 };

        const tokens = expr.match(/sqrt|[0-9.]+|[()+\-*/]/g);

        for (const t of tokens) {
            if (!isNaN(t)) {
            output.push(parseFloat(t));
            } else if (t === "sqrt") {
            ops.push(t);
            } else if (t in prec) {
            while (
                ops.length &&
                prec[ops[ops.length - 1]] >= prec[t]
            ) {
                output.push(ops.pop());
            }
            ops.push(t);
            } else if (t === "(") {
            ops.push(t);
            } else if (t === ")") {
            while (ops.length && ops[ops.length - 1] !== "(") {
                output.push(ops.pop());
            }
            ops.pop();
            if (ops.length && ops[ops.length - 1] === "sqrt") {
                output.push(ops.pop());
            }
            }
        }

        while (ops.length) output.push(ops.pop());

        const stack = [];
        for (const t of output) {
            if (typeof t === "number") {
            stack.push(t);
            } else if (t === "sqrt") {
            const a = stack.pop();
            stack.push(Math.sqrt(a));
            } else {
            const b = stack.pop();
            const a = stack.pop();
            switch (t) {
                case "+": stack.push(a + b); break;
                case "-": stack.push(a - b); break;
                case "*": stack.push(a * b); break;
                case "/": stack.push(a / b); break;
            }
            }
        }

        return stack[0];
    }

    function displayResult() {
        try{
            temp = evaluate(vm.inputDisplay);
            temp = (temp * 1).toString();
            vm.resultDisplay = temp;
        }
        catch(error){
            vm.resultDisplay = '';
        }
    }
</script>
</body>
</html>
