<template>
    <div class="card-header">Balance: {{ localBalance }}</div>
</template>

<script>
export default {
    props: {
        balance: {
            type: String,
            required: false,
            default: () => ('')
        }
    },
    data() {
        return {
            localBalance: this.balance
        };
    },
    methods: {
        async fetchBalance() {
            const response = await fetch('/balance');
            if (response.ok) {
                let data = await response.json();
                this.localBalance = data.balance_format;
            } else {
                console.error("Status: " + response.status);
            }
        }
    },
    async created() {
        await this.fetchBalance();
    },
    mounted() {
        this.interval = setInterval(() => {
            this.fetchBalance();
        }, 5000); // fetch every 5 seconds
    },
    beforeUnmount() {
        clearInterval(this.interval);
    }
}
</script>
