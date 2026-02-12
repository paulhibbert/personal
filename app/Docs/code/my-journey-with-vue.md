# My journey with Vue

While the majority of code I have written using Vue.js (and most of my other code come to that) is locked away in private repositories there are some bits and pieces lying around to illustrate the journey.

## Early Days

It started in 2018 with Vue version 2 when commercially I was still forced to use JQuery for the majority of my work. So a few toy projects at home followed. I wanted them to run locally on my machine and be able to install them as web apps via Chrome, hence these early projects have a `manifest.json` file and icons for mobile and desktop. One of them at least is still hosted on [render](https://vue-calc.onrender.com/) and opening in Chrome still invites an installation as a web app, nice to see that element still working.

These are crude and simple toy projects, but still give me some pleasure in that the code still works, even though I have tweaked bits of it more recently. Vue.js is loaded from a cdn, a method which [still works](https://vuejs.org/guide/quick-start.html#using-vue-from-cdn) and is a perfectly reasonable approach for progressive enhancement of an existing web page, or as in these toy examples using in a static html file that can be served anywhere with no build step required.

This code from 2018 simply mounts Vue on an element on the page, declares some data and methods. As a learning too its great. In the console its possible to call `vm.clearInput()` for example to clear the data and the elements which are bound reactively to the data (no importing ref in those days).

```javascript
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
```

A couple of bare functions are declared (so these can also be used in the console), one to evaluate the text expressions like "sqrt(78)" or "6+(3/7)" and so on, and one to display the result.

```javascript
function displayResult() {
    try{
        temp = evaluate(vm.inputDisplay);
        vm.resultDisplay = temp.toString();
    }
    catch(error){
        vm.resultDisplay = '';
    }
}
```

The original quickly put together version used the dreaded eval as a quick hack (no danger anyway in these circumstances) but I recently added a parser written by Copilot which is somewhat safer, it returns a Number type or NaN.

The calculator buttons are mostly bound to the calculatorInput method and add their associated data element to the string.

```html
<div data-button="1" v-on:click="calculatorInput">1</div>
<div data-button="/" v-on:click="calculatorInput">/</div>
```

Where the symbol on the button does not match the string representation, for example the multiply button, the div content is an SVG, and very handily SVGs being proper elements (for a long time now) can also have a data attribute as can the lines so it does not matter where the click event
is generated.

```html
<div data-button="*" v-on:click="calculatorInput">
    <svg 
        data-button="*" 
        width="100%" 
        height="100%" 
        viewBox="0 0 24 24" 
        fill="none" 
        stroke="currentColor" 
        stroke-width="2" 
        stroke-linecap="round" 
        stroke-linejoin="round" 
        class="feather feather-x">
        <line data-button="*" x1="18" y1="6" x2="6" y2="18"></line>
        <line data-button="*" x1="6" y1="6" x2="18" y2="18"></line>
    </svg>
</div>      
```

## First commercial use

Jump forward in time to 2019 and I was working with Laravel version 6 and Laravel Nova version 2 and I created a custom Nova component to display two records side by side in columns which were determined to be duplicates (source data having been imported from many sources) and enabling the admin to select the best data from each model to get a single new record to replace the duplicates with the best of the imported values. I won't go into too many of the details.

This was still Vue version 2.5 but this was a single file component which Nova loads as a module (if that is the correct terminology). I have removed anything non-generic and most of the details of the implementation, what is shown here is to illustrate the pattern, the data in the vue instance is returned as a function much like its returned in the composition API when that appears in the future.

The code snippet, though now completely divorced from the original context, shows that each attribute of the records being compared had a checkbox and checkbox = on meant the merged version should use that version, checking off returned the value to its original state. It was also possible to use all the values from one side in a single click (and then uncheck a few if not needed).

I do remember that there was a very rudimentary user interface design and most of the decisions about the UX (such as adding the use all values from one side, adding a reset button and so on) were made by me as I built it.

```javascript
<script>
module.exports =  {
    data:function() {
        return {
            target: {
                id: null,
                source_id: 0,
                remove_source: false,
                name: '',
                address_line_1: '',
                address_line_2: '',
                address_line_3: '',
                town: '',
                postcode: '',
            },
            original:{
            },
            source: {
            },
            sourceError: false,
            targetError: false,
            targetMessage: false,
        }
    },
    mounted() {
            this.fillTarget(some_id);
            this.fillSource(another_id);
        }
    },
    watch: {},
    methods: {
        fillTarget: function(some_id){
            this.targetError = false;
            axios.get('backend_url' + some_id)
                .then(response => {
                    this.target.id = response.data.id;
                    this.target.name = response.data.name;
                })
                .catch(error => {
                    this.targetError = true;
                });
        },
        fillSource: function(another_id){
            this.sourceError = false;
            axios.get('backend_url'+another_id)
                .then(response => {
                    this.source.id = response.data.id;
                    this.source.name = response.data.name;
                })
                .catch(error => {
                    this.sourceError = true;
                    this.source.name = null;
                    this.resetTarget();
                });
        },
        getSource: function(event){
            this.fillSource(this.source.id);
            this.resetTarget();
        },
        getTarget: function(event){
            this.fillTarget(this.target.id);
        },
        checkClicked: function(event){
            if(event.currentTarget.checked) {
                switch (event.target.name) {
                    case 'address_line_1':
                        this.original.address_line_1 = this.target.address_line_1;
                        this.target.address_line_1 = this.source.address_line_1;
                        break;
                }
            }
            else {
                switch (event.target.name) {
                    case 'address_line_1':
                        this.target.address_line_1 = this.original.address_line_1;
                        break;
                }
            }
        },
        resetTarget: function(){
            ...
        },
        updateBackend: function() {
            this.targetMessage = false;
            if(this.targetError || this.sourceError){
                this.targetMessage = 'Please resolve errors.'
            }
            else {
                this.target.source_id = this.source.id;
                if (this.source.id) {
                    axios.post('backend_url' + this.target.id, this.target)
                        .then(response => {
                            if (response.status === 200) {
                                this.targetMessage = 'Updated Successfully';
                                if(this.target.remove_source){
                                    this.fillSource(this.target.source_id);
                                }
                            } else if (response.status === 204) {
                                this.targetMessage = 'No Change';
                            } else {
                                this.targetMessage = response.statusText;
                            }
                        })
                        .catch(error => {
                            console.log(error);
                            this.targetMessage = 'Failed to Update';
                        })
                } else {
                    this.targetMessage = 'Please select a model as the source, and merge field values.'
                }
            }
        },
        triggerBoxes: function(){
            const boxes = document.getElementsByClassName('checkbox merge');
            for (var i=0; i<boxes.length; i++) {
                boxes[i].click();
            }
        },
    },
}
</script>
```

## Vue 3

Fast forward to 2021 and in a completely different commercial environment there was a need for a display of calls data in a filterable and flexible data table on a legacy system (more JQuery) with an export function available for the filtered data. In this case using local versions of the JS downloaded from CDN, this was a progressive enhancement of a page served by the legacy backend. I will leave out the details of how the data is retrieved and much of the implementation detail, focusing again on the structure and generic functionality.

Suffice to say that the page loads `vue.v3.2.37.min.js` and `quasar.v2.7.7.umd.min.js` as well as the quasar css. There is as usual a div on the page with the id 'q-app' where Vue is mounted. The vue instance is created with `createApp` and then Quasar is added with `app.use` before the whole thing is mounted on the div.

```javascript
const app = Vue.createApp({
setup () {
    return {
        visibleColumns: Vue.ref(visibleColumns),
        initialPagination: {
            page: 1,
            rowsPerPage: 20
        },
        columns,
        rows, // this is the raw data
        filter: Vue.ref(filter),
        filterColumn,
        callsTable,
        customFilter(rows, terms) {
            const lowerTerms = terms ? terms.toLowerCase() : '';
            const toFilter = [filterColumn.value];
            const filteredRows = rows.filter(
                row => toFilter.some(col => (row[col] + '').toLowerCase().includes(lowerTerms))
            )
            return filteredRows;
        },
        exportTable() {
            // function to wrap every cell in quotes for csv is omitted here
            Quasar.exportFile(exportFilename, headerRow.concat(dataRows).join('\r\n'), 'text/csv');
        }
    }
}
});
app.use(Quasar);
app.mount('#q-app');
```

At this point in time it was the whole of Quasar which was added to Vue even though we only wanted the table component, it was not then possible to load a single component in the universal module format (whether that is now possible I have not checked).

The Quasar table is added as an html component inside the div where Vue is then mounted and of course is then able to render this custom component which the browser would otherwise skip as unsupported.

The `q-table` element is bound to the various objects and methods returned by the Vue app setup method

```html
<q-table
      title="Call Data"
      class="sticky-header"
      :rows="rows"
      :columns="columns"
      row-key="idx"
      :filter="filter"
      :filter-method="customFilter"
      :pagination="initialPagination"
      :rows-per-page-options="[10, 20, 30, 40, 50, 0]"
      virtual-scroll
      :visible-columns="visibleColumns"
      no-data-label="No results returned - Try a different date range"
      no-results-label="There are no results matching your filter"
      ref="callsTable"
    />
        <template v-slot:top>
            <q-btn
                color="primary"
                icon-right="archive"
                label="Export Filtered Results to csv"
                no-caps
                @click="exportTable"
            /></q-btn>
            <q-space></q-space>
            <q-radio v-model="filterColumn" val="team_name" label="Team"></q-radio>
            <q-radio v-model="filterColumn" val="fullname" label="Name"></q-radio>
            <div class="q-pa-md">
                <q-input outlined dense debounce="300" v-model="filter" placeholder="Filter">
                    <template v-slot:append>
                    <q-icon name="search" ></q-icon>
                    </template>
                </q-input>
            </div>
        </template>
    </q-table>
```

It was also possible to override some of the Quasar css by targeting the class of the custom element creating the equivalent of scoped css.

```css
<style>
    .sticky-header {
        height: 750px;
    }
    .sticky-header .q-table__top,
    .sticky-header .q-table__bottom,
    .sticky-header thead tr:first-child th {
        background-color: #fff;
    }
    .sticky-header thead tr th {
        position: sticky;
        z-index: 1;
    }
    .sticky-header thead tr:last-child th {
        top: 48px;
    }
    .sticky-header thead tr:first-child th {
        top: 0;
    }
</style>
```

## Vue and Inertia

Naturally I don't have access any more to the code I wrote using Vue 3 with Inertia in a Laravel application more recently. I've illustrated some small and generic single file components on other pages.

- [an alert component](articles/alert)
- [a friendly redirect component](articles/success)
- [a dismissable modal component](articles/modal-component)

The following is a sort of generic form component which illustrates how that old version of Inertia and precognition was used and some observations about form validation in this context. Much of the original has been omitted or simplified for illustration.

While precognition is being used so business rule validation can be applied in one place, on the backend, I did not want to have network round trips on every input field change to validate html native requirement such as a field being required or needing to be a number or match a pattern. With the use of precognition the whole point is of course to do validation in one place, but for the sake of UX I felt that we could at least take advantage of the native html attributes and the validityState API, in this case it is only checking `input.validity.required` locally in order to avoid an unnecessary round trip delay.

In other more complex forms its simple to use `input.validity.valid` to check the input conforms to ALL native validation constraints in one simple check, though of course inspecting all of the possible [invalid states](https://developer.mozilla.org/en-US/docs/Web/API/ValidityState#instance_properties) and returning appropriate error messages locally adds a layer of complexity that is almost certainly not justified given the desired goal of doing validation in one place (the backend).

```javascript
<template>
    <div class="container-sm mt-5">
        <div class="card p-10">
            <div class="d-flex  align-items-center mb-4">
                <ThingIcon :iconSize="48" :opacity="1.0" :locked="false"/>
                <h3 v-if="creating" class="px-2 text-dark h1 fw-normal">{{ $t('Create a New Thing') }}</h3>
                <h3 v-else class="px-2 text-dark h1 fw-normal">{{ $t('Edit the Thing') }}</h3>
            </div>
            <form id="Thing-form" @submit.prevent="saveThing">

                <Alert v-if="this.errorMessage" :content="this.errorMessage" alert-type="error" />

                <div class="card-body mx-auto w-50">
                    <div class="d-flex  align-items-center mb-4">
                        <Details />
                        <h5 class="px-2">{{ $t('Tell us about the Thing') }}</h5>
                    </div>

                    <div class="form-group mb-3">
                        <label for="name" class="form-label required">{{ $t('Name') }}</label>
                        <input type="text" class="form-control" id="name" v-model="form.name" required
                            @change="validateField('name')" />
                        <div v-if="form.invalid('name')" class="text-danger small">{{ form.errors.name }}</div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="Thing_reference" class="form-label required">{{ $t('Thing Reference Number')
                            }}</label>
                        <input type="text" class="form-control" id="Thing_reference" v-model="form.Thing_reference"
                            required @change="validateField('Thing_reference')" />
                        <div v-if="form.invalid('Thing_reference')" class="text-danger small">{{
                            form.errors.Thing_reference }}</div>
                    </div>
            </form>
            <div class="d-flex justify-content-between mx-auto card-body w-50">
                <button type="button" class="btn btn-outline me-2 mw-50" @click="cancel">{{ $t('Cancel') }}</button>
                <button v-if="canDelete" type="button" class="btn btn-outline me-2 flex-grow-1 mw-50"
                    @click="deleteThing" :disabled="isSubmitting">{{ $t('Delete') }}</button>
                <button type="submit" class="btn btn-primary mw-50" @click="saveThing" :disabled="isSubmitting">{{
                    $t('Save Thing') }}</button>
            </div>
        </div>
    </div>
</template>

<script>
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useForm } from 'laravel-precognition-vue-inertia';
import { cleanFieldName } from '../../../../utility.js';
import Alert from "../../../../components/Alert.vue";
import ThingIcon from '../../../../Icons/ThingIcon.vue';

export default {
    components: {
        Alert,
        Thing,
    },
    props: {
        creating: {
            type: Boolean,
            required: true,
        },
        canDelete: {
            type: Boolean,
            default: false,
        },
        errorMessage: {
            type: String,
            default: ''
        },
        Thing: {
            type: Object,
            required: true,
        },
    },
    setup(props) {
        let baseUrl = `backend_url`;
        let formUrl = baseUrl;

        if (props.Thing.uuid.length > 0) {
            // add uuid to the end of the route for update
            formUrl = formUrl + '/' + props.Thing.uuid;
        }

        const form = useForm('put', formUrl, {
            name: props.Thing.name,
            Thing_reference: props.Thing.Thing_reference,
        });

        const cancel = () => {
            router.visit(baseUrl);
        };

        const validateField = (fieldId) => {
            form.forgetError(fieldId);
            let input = document.getElementById(fieldId);
            if (input.required && (input.validity.valueMissing || (input.type === 'hidden' && input.value == ""))) {
                form.setError(fieldId, `${cleanFieldName(fieldId)} is required`);
            } else if (!isSubmitting.value) {
                form.validate(fieldId); //backend validation for each field individually only when not submitting the form
            }
        };

        const isSubmitting = ref(false);
        const scrollToFirstError = () => {
            let elementId = Object.getOwnPropertyNames(form.errors)[0];
            document.getElementById(elementId).parentElement.scrollIntoView({ behavior: "smooth", block: "center" });
        };
        const saveThing = () => {
            if (isSubmitting.value) return; // Prevent multiple form submissions
            isSubmitting.value = true;
            let inputs = document.getElementById("Thing-form").elements;
            for (let i = 0; i < inputs.length; i++) {
                if (inputs[i].nodeName === "INPUT" && inputs[i].id !== "") {
                    validateField(inputs[i].id);
                }
            }
            if (form.hasErrors) {
                scrollToFirstError();
                isSubmitting.value = false;
                return;
            }
            form.submit({
                preserveScroll: false,
                onError: () => {
                    scrollToFirstError();
                },
                finally: () => {
                    isSubmitting.value = false;
                }
            });
        };
        
        const deleteThing = () => {
            if (isSubmitting.value) return;
            isSubmitting.value = true;
            form.delete(formUrl, {
                finally: () => {
                    isSubmitting.value = false;
                }
            });
        }

        return {
            form,
            validateField,
            saveThing,
            cancel,
            deleteThing,
            isSubmitting,
        };
    }
};
</script>

<style scoped>
h5,
h3 {
    margin: unset;
}
</style>
```
