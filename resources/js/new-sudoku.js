import { createApp } from 'vue'
import Sudoku from './components/Sudoku.vue'

const el = document.getElementById('vue-sudoku');

createApp(Sudoku).mount(el);