# A (friendly) method of redirecting after successful form submission

When a form to add a new model or array of models into the DB has been submitted, rather than staying on that same component, you want to direct the user probably back to an index component listing all the models of that type, ideally with those new entries at the top of the list, for example. But in that case where do we show the user the feedback that their form submission was successful? Its possible in some cases to show it on the index component, maybe, I don't really like it. And sometimes the component to which they are redirected has a completely different context and the message about the form submission would just look completely out of place.

Here is another way.

Route the user to a page with this sucess-redirect component on it to show the feedback and take the user in a friendly way to whereever it is they need to go.

```javascript
<template>
        <Alert ref="alert" :content="this.successMessage" :alert-type="success" />
        <div>{{ $t('You will be redirected shortly.') }}</div>
</template>

<script>
import { onMounted } from 'vue';
import Alert from "../components/Alert.vue";

export default {
    components: {
        Alert
    },
    props: {
        successMessage: {
            type: String,
            required: true
        },
        redirect: {
            type: String,
            required: true
        }
    },
    setup(props) {
        onMounted(() => {
            setTimeout(() => {
                window.location = props.redirect;
            }, 2000);
        });        
    }
}
</script>
```
