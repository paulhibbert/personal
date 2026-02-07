<template>
  <div class="wrapper">
    <input v-for="cell in cells" 
        v-model="cell.num"
        @input="checkNumber"
        :style="{ 'background-color': cell.color }" 
        class="cell"
        type="text" pattern="[1-9]" maxlength="1"
    />
  </div>
</template>

<style scoped>
    input {
        width: 3em;
        height: 3em;
        line-height: 3em;
        color: blue;
        text-align: center;
        border-color: darkgray;
        border-style: solid;
        border-width: 2px 2px 2px 2px;
        background: aliceblue;
        font-size: inherit;
    }
    /* This styles any input not matching the regex pattern defined in the html*/
    input:invalid {
        background: red !important;
    }
    /* This does the same thing but where the JS above sets the attribute
    *  Once the attribute is removed the cell reverts to whatever style is bound by Vue to the element in the cell.color property
    */
    input[title="invalid"] {
        background: red !important;
    }

    input:disabled {
        color: darkgrey;
    }

    .wrapper {
        display: grid;
        grid-template-columns: repeat(9, 3em);
        row-gap: .2em;
        column-gap: .2em;
    }
</style>

<script>
import { onMounted, ref } from 'vue';

export default {

    setup() {
        const cells = ref([]);
        const dataElement = document.getElementById('sudoku-data');
        const clues = JSON.parse(dataElement.dataset.props);
        const column0 = [80, 71, 62, 53, 44, 35, 26, 17, 8];
        const column1 = [79, 70, 61, 52, 43, 34, 25, 16, 7];
        const column2 = [78, 69, 60, 51, 42, 33, 24, 15, 6];
        const column3 = [77, 68, 59, 50, 41, 32, 23, 14, 5];
        const column4 = [76, 67, 58, 49, 40, 31, 22, 13, 4];
        const column5 = [75, 66, 57, 48, 39, 30, 21, 12, 3];
        const column6 = [74, 65, 56, 47, 38, 29, 20, 11, 2];
        const column7 = [73, 64, 55, 46, 37, 28, 19, 10, 1];
        const column8 = [72, 63, 54, 45, 36, 27, 18, 9, 0];
        const beige = [3, 4, 5, 12, 13, 14, 21, 22, 23, 27, 28, 29, 36, 37, 38, 45, 46, 47, 33, 34, 35, 42, 43, 44, 51, 52, 53, 57, 58, 59, 66, 67, 68, 75, 76, 77];
        const square0 = [80,79,78,71,70,69,62,61,60];
        const square1 = [77,76,75,68,67,66,59,58,57];
        const square2 = [74,73,72,65,64,63,56,55,54];
        const square3 = [53,52,51,44,43,42,35,34,33];
        const square4 = [50,49,48,41,40,39,32,31,30];
        const square5 = [47,46,45,38,37,36,29,28,27];
        const square6 = [26,25,24,17,16,15,8,7,6];
        const square7 = [23,22,21,14,13,12,5,4,3];
        const square8 = [20,19,18,11,10,9,2,1,0];
        let rowValue = 0;
        let columnValue = 0;
        let numValue = '';
        let squareValue = 0;
        let colorValue = '';
        let i = 81;
        while (i--) {
            if (i < 72) {
                rowValue = 1;
            }
            if (i < 63) {
                rowValue = 2;
            }
            if (i < 54) {
                rowValue = 3;
            }
            if (i < 45) {
                rowValue = 4;
            }
            if (i < 36) {
                rowValue = 5;
            }
            if (i < 27) {
                rowValue = 6;
            }
            if (i < 18) {
                rowValue = 7;
            }
            if (i < 9) {
                rowValue = 8;
            }
            if (column0.includes(i)) {
                columnValue = 0;
            }
            else if (column1.includes(i)) {
                columnValue = 1;
            }
            else if (column2.includes(i)) {
                columnValue = 2;
            }
            else if (column3.includes(i)) {
                columnValue = 3;
            }
            else if (column4.includes(i)) {
                columnValue = 4;
            }
            else if (column5.includes(i)) {
                columnValue = 5;
            }
            else if (column6.includes(i)) {
                columnValue = 6;
            }
            else if (column7.includes(i)) {
                columnValue = 7;
            }
            else if (column8.includes(i)) {
                columnValue = 8;
            }
            if (square0.includes(i)){
                squareValue = 0;
            }
            else if(square1.includes(i)){
                squareValue = 1;
            }
            else if(square2.includes(i)){
                squareValue = 2;
            }
            else if(square3.includes(i)){
                squareValue = 3;
            }
            else if(square4.includes(i)){
                squareValue = 4;
            }
            else if(square5.includes(i)){
                squareValue = 5;
            }
            else if(square6.includes(i)){
                squareValue = 6;
            }
            else if(square7.includes(i)){
                squareValue = 7;
            }
            else {
                squareValue = 8;
            }
            numValue = '';
            colorValue = 'aliceblue';
            if (beige.includes(i)) {
                colorValue = 'beige';
            }
            clues.forEach(function (clue, key) {
                if (clue.row == rowValue && clue.column == columnValue) {
                    numValue = clue.num;
                }
            });
            cells.value.push({
                num: numValue,
                row: rowValue,
                column: columnValue,
                square: squareValue,
                color: colorValue
            });
        }

        onMounted(() => {
            const boxes = document.getElementsByClassName('cell');
            i = boxes.length;
            while (i--) {
                boxes[i].id = "cell" + i;
                if (boxes[i].value != '') {
                    boxes[i].setAttribute("disabled", "");
                }
            }
        });

        const checkNumber = (event) => {
            event.target.setAttribute("title", "");
            const cell = event.target;
            const value = cell.value;
            if (value == '') {
                return;
            }
            if (value < 1 || value > 9 || isNaN(value)) {
                cell.setAttribute("title", "invalid");
            }
            let valid = true;
            const cellId = event.target.id.substr(4, 2);
            const entry = cells.value[cellId].num;
            const sameRow = cells.value.filter(cell => cell.row == cells.value[cellId].row).filter(cell => cell.column != cells.value[cellId].column).filter(cell => cell.num != "");
            const sameCol = cells.value.filter(cell => cell.column == cells.value[cellId].column).filter(cell => cell.row != cells.value[cellId].row).filter(cell => cell.num != "");
            const sameSquare = cells.value.filter(cell => cell.square == cells.value[cellId].square).filter(cell => cell.column != cells.value[cellId].column).filter(cell => cell.row != cells.value[cellId].row).filter(cell => cell.num != "");
            const alreadyUsed = sameRow.concat(sameCol).concat(sameSquare);
            for (let i = 0; i < alreadyUsed.length; i++) {
                if (alreadyUsed[i].num == entry) {
                    event.target.setAttribute("title", "invalid");
                    valid = false;
                }
            }
            if (valid) {
                // check if the board is complete and valid. If it is, change the color of all cells to green and disable them.
                // This is done by checking if there are any cells that are not filled in.
                // If there are none, then we check if the sum of each row, column and square is 45 (the sum of numbers 1-9).
                // If any of these checks fail, the board is not valid.
                // If they all pass, the board is valid and we change the color of all cells to green and disable them.
                var notFilledIn = cells.value.filter(cell => cell.num == "");
                if (notFilledIn.length == 0) {
                    for (let i = 0; i <= 8; i++) {
                        if (cells.value.filter(cell => cell.row == i).reduce((acc, cv) => { return acc + parseInt(cv.num) }, 0) != 45) {
                            valid = false;
                        }
                    }
                    for (let i = 0; i <= 8; i++) {
                        if (cells.value.filter(cell => cell.column == i).reduce((acc, cv) => { return acc + parseInt(cv.num) }, 0) != 45) {
                            valid = false;
                        }
                    }
                    for (let i = 0; i <= 8; i++) {
                        if (cells.value.filter(cell => cell.square == i).reduce((acc, cv) => { return acc + parseInt(cv.num) }, 0) != 45) {
                            valid = false;
                        }
                    }
                    if (cells.value.reduce((acc, cv) => { return acc + parseInt(cv.num) }, 0) != 405) {
                        valid = false;
                    }
                    if (valid) {
                        for (let j = 0; j < cells.value.length; j++) {
                            cells.value[j].color = '#99ff99';
                            var boxes = document.getElementsByClassName('cell');
                            i = boxes.length;
                            while (i--) {
                                boxes[i].id = "cell" + i;
                                if (boxes[i].value != '') {
                                    boxes[i].setAttribute("disabled", "");
                                }
                            }
                        }
                    }
                }
            }
        }

        // @todo the equivalent of the checkNumber function in the original JS code needs to be implemented here and bound to the input event on the cells. This will allow the invalid attribute to be set on the cell when an invalid number is entered and removed when a valid number is entered. This will allow the CSS to style the cell accordingly. 

        return {
            cells,
            checkNumber,
        }
    },
}
</script>