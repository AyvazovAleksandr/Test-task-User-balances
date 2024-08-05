<template>
    <ol class="list-group list-group-numbered">
        <li
            v-for="(operation, index) in operationList"
            :key="index"
            class="list-group-item"
            :class="operationClass(operation.type)"
        >
            {{ operation.amount_format }} - {{ operation.description }}
        </li>
    </ol>
</template>

<script>
export default {
    props: {
        operation: {
            type: Array,
            required: false,
            default: () => ([])
        }
    },
    data() {
        return {
            operationList: this.operation
        };
    },
    computed: {
        operationClass() {
            return (type) => ({
                'list-group-item-success': type === 'add',
                'list-group-item-danger': type === 'subtract'
            })
        }
    },
    methods: {
        async fetchOperation() {
            const response = await fetch('/operations');
            if (response.ok) {
                let data = await response.json();
                this.operationList = data.operations;
            } else {
                console.error("Status: " + response.status);
            }
        }
    },
    async created() {
        await this.fetchOperation();
    },
    mounted() {
        this.interval = setInterval(() => {
            this.fetchOperation();
        }, 5000); // fetch every 5 seconds
    },
    beforeUnmount() {
        clearInterval(this.interval);
    }
}
</script>
