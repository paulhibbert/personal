<!DOCTYPE HTML>
<html lang="en-GB">

<head>
    <title>Tasks</title>
    <meta charset="utf-8">
    <meta name="description" content="Vue.js - To Do">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.7.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.16.0/vuedraggable.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/buttons-min.css">
</head>

<body>

    <div id="app" class="appcontainer">
        <h1>Tasks</h1>
        <div class="buttons">
            <button class="pure-button custom-button button1" v-on:click="addTask">Add</button>
            <button class="pure-button custom-button button2" v-on:click="removeCompleted">Clear</button>
        </div>
        <draggable class="grid-item" :list="tasks" @start="dragging=true" @end="dragging=false">
            <div v-for="(task, index) in tasks" :key="index" class="wrapper">
                <div class="leftcolrow2">
                    <label class="container">
                        <input type="checkbox" v-model="task.done">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="middlecolumn">
                    <textarea v-model="task.todo" v-bind:class="{ done: task.done }"></textarea>
                </div>
                <div class="rightcolrow1">
                </div>
                <div class="rightcolrow2" v-on:click="removeTask(index)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-trash-2">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </div>
                <div class="rightcolrow3">
                </div>

            </div>
        </draggable>
    </div>
    <script>
        var STORAGE_KEY = 'tasks-vuejs-2.0'
        var taskStorage = {
            fetch: function() {
                var tasks = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]')
                tasks.forEach(function(task, index) {
                    task.id = index
                })
                taskStorage.uid = tasks.length
                return tasks
            },
            save: function(tasks) {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(tasks))
            }
        }

        var vm = new Vue({
            el: '#app',
            data: {
                tasks: taskStorage.fetch(),
                dragging: false
            },
            // watch tasks change for localStorage persistence
            watch: {
                tasks: {
                    handler: function(tasks) {
                        taskStorage.save(tasks)
                    },
                    deep: true
                }
            },
            methods: {
                addTask: function() {
                    this.tasks.unshift({
                        todo: '',
                        done: false
                    })
                },
                removeTask: function(index) {
                    this.tasks.splice(index, 1)
                },
                removeCompleted: function() {
                    var i;
                    for (i = this.tasks.length - 1; i >= 0; i -= 1) {
                        if (this.tasks[i].done) {
                            this.tasks.splice(i, 1);
                        }
                    }
                }
            }
        })
    </script>
    <style>
        body {
            font-family: "BlinkMacSystemFont", -apple-system, "Segoe UI", "Roboto", "Helvetica", "Arial", "Droid Sans", sans-serif;
            font-size: 3vh;
            background-color: darkgray;
        }

        h1 {
            font-size: 6vh;
            text-align: center;
            color: #064ea0;
            margin-top: -1vh;
            margin-bottom: 2vh;
        }

        .appcontainer {
            width: 90vw;
            margin: auto;
        }

        textarea {
            width: 100%;
            border-width: 1px;
            border-style: solid;
            border-color: #a6a6a6;
            font-size: 1.5rem;
            text-align: left;
            background-color: white;
            resize: vertical;
            height: 3.25rem;
            margin-bottom: 0.8rem;
            padding: 0.5rem;
        }

        .wrapper {
            display: grid;
            grid-template-columns: 24px auto 24px;
            column-gap: 0.8rem;
        }

        .leftcolrow2 {
            grid-column: 1;
            grid-row: 2;
        }

        .middlecolumn {
            grid-column: 2 / 3;
            grid-row: 1 / 4;
        }

        .rightcolrow1 {
            grid-column: 3;
            grid-row: 1;
        }

        .rightcolrow2 {
            grid-column: 3;
            grid-row: 2;
        }

        .rightcolrow3 {
            grid-column: 3;
            grid-row: 3;
        }

        .feather {
            cursor: pointer;
            margin-left: 0.8rem;
        }

        .buttons {
            display: grid;
            grid-template-columns: 24px 1fr 1fr 1fr 1fr 1fr 24px;
            margin-bottom: 0.8rem;
        }

        .button1 {
            grid-column: 3;
        }

        .button2 {
            grid-column: 5;
        }

        .trashButton {
            text-align: right;
        }

        .custom-button {
            border-radius: 1vh;
            background: rgb(6, 78, 160);
            /* this is a dark blue */
            color: white;
            font-size: 80%;
        }

        /* https://www.w3schools.com/howto/howto_css_custom_checkbox.asp */
        /* The container */

        .container {
            position: relative;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browsers default checkbox */

        .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        /* Create a custom checkbox */

        .checkmark {
            position: absolute;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: #eee;
        }

        /* On mouse-over, add a grey background color */

        .container:hover input~.checkmark {
            background-color: #ccc;
        }

        /* When the checkbox is checked, add a blue background */

        .container input:checked~.checkmark {
            background-color: #064ea0;
        }

        /* Create the checkmark/indicator (hidden when not checked) */

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the checkmark when checked */

        .container input:checked~.checkmark:after {
            display: block;
        }

        /* Style the checkmark/indicator */

        .container .checkmark:after {
            left: 7px;
            top: 2px;
            width: 4px;
            height: 9px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        .done {
            font-style: oblique;
            text-decoration: line-through;
        }
    </style>
</body>

</html>
