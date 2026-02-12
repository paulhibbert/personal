# A dismissable Alert component using the Composition API

In this case using bootstrap 5 for the CSS and font awesome icons version 4.

```javascript
<template>
    <transition name="fade" mode="in-out">
        <div v-if="isVisible" class="alert d-flex align-items-center p-3 py-4 mb-5" :class="[alertClass]">
            <div class="flex-grow-1">
                <i class="fa me-2" :class="icon"></i>
                <div class="d-inline-block">
                    <span class="text-gray-900">{{ alertContent }}</span>
                </div>
            </div>
            <div class="text-end">
                <button @click="dismissAlert" class="btn btn-icon btn-sm align-self-end w-auto h-auto me-2" aria-label="Close">
                    <i class="bi bi-x fs-2"></i>
                </button>
            </div>
        </div>
    </transition>
</template>

<script>
import { ref } from 'vue';
export default {
    name: 'Alert',
    props: {
        alertContent: {
            type: String,
            required: true,
        },
        alertType: {
            type: String,
            required: true,
            validator: function(value) {
                return ['error', 'warning', 'success'].includes(value);
            },
        }
    },
    computed: {
        alertClass() {
            if (this.alertType === 'error') {
                return 'alert-danger border-danger';
            } else if (this.alertType === 'warning') {
                return 'alert-warning border-warning';
            } else {
                return 'alert-success border-success';
            }
        },
        icon() {
            if (this.alertType === 'error') {
                return ['far', 'fa-exclamation-circle', 'text-danger'];
            } else if (this.alertType === 'warning') {
                return ['far', 'fa-exclamation-triangle', 'text-warning'];
            } else {
                return ['far', 'fa-check-circle', 'text-success'];
            }
        }
    },
    setup () {
        const dismissAlert = () => {
            isVisible.value = false;
        };

        const displayAlert = () => {
            isVisible.value = true;
        }

        const isVisible = ref(true);

        return {
            dismissAlert,
            displayAlert,
            isVisible
        }
    }
}
</script>

<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity 0.2s ease-out;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>
```

There is an example use of this component in another [component](articles/success).
