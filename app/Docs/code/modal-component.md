# Vue single-file component for a dismissable modal using the Options API

sometimes the composition API is over the top for a simple component. This component has a named slot for the content of the modal.

```javascript
<template>
    <div class="modal fade" :class="{'show d-block': isOpen}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ title }}
                    </h5>
                    <button @click="this.$emit('modal-close')" class="btn btn-icon ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x fs-2"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <slot name="body"></slot>
                </div>
                <div class="modal-footer">
                    <button @click="this.$emit('modal-close')" type="button" class="btn btn-outline" data-bs-dismiss="modal">
                        {{ $t('cancel') }}
                    </button>
                    <button v-if="showConfirm" type="button" class="btn btn-primary modal-confirm">
                        <span class="indicator-label">
                            {{ $t('ok') }}
                        </span>
                        <span class="indicator-progress">
                            {{ $t('waiting&hellip;') }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div v-if="isOpen" class="modal-backdrop fade show"></div>
</template>

<script>
import { onClickOutside } from '@vueuse/core';

export default {
    props: {
        isOpen: Boolean,
        title: String,
        body: String,
        showConfirm: Boolean,
    },
    emits: ['modal-close'],
    data() {
        return {
            target: null,
        };
    },
    mounted() {
        onClickOutside(this.target, () => this.$emit('modal-close'));
    },
};
</script>
```

Example use:

```javascript
<ModalComponent :isOpen="isModalOpened" @modal-close="closeModal" name="validation-modal" title="Validation Error">
    <template #body>
        <span>{{ $t("Some validation error in a modal for some reason") }}</span>
    </template>
</ModalComponent>

<script>
    openModal() {
        this.isModalOpened = true;
    },
    closeModal() {
        this.isModalOpened = false;
    },
</script>
```
