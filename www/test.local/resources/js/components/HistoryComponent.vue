<template>
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label for="search" class="form-label">Поиск по описанию:</label>
                <input type="text" id="search" v-model="searchQuery" class="form-control" placeholder="Введите описание">
            </div>
            <div class="mb-3">
                <label for="sort" class="form-label">Сортировка по дате:</label>
                <select id="sort" v-model="sortOrder" class="form-select">
                    <option value="asc">По возрастанию</option>
                    <option value="desc">По убыванию</option>
                </select>
            </div>
            История транзакций:
            <ol class="list-group list-group-numbered">
                <li
                    v-for="(operation, index) in filteredAndSortedOperations"
                    :key="index"
                    class="list-group-item"
                    :class="operationClass(operation.type)"
                >
                    {{ operation.amount_format }} - {{ operation.description }} - {{ operation.created_at }}
                </li>
            </ol>
        </div>
    </div>
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
            operationList: this.operation,
            searchQuery: '',
            sortOrder: 'asc'
        };
    },
    computed: {
        operationClass() {
            return (type) => ({
                'list-group-item-success': type === 'add',
                'list-group-item-danger': type === 'subtract'
            });
        },
        filteredAndSortedOperations() {
            let filteredOperations = this.operationList.filter(operation =>
                operation.description.toLowerCase().includes(this.searchQuery.toLowerCase())
            );

            return filteredOperations.sort((a, b) => {
                let dateA = new Date(a.created_at);
                let dateB = new Date(b.created_at);
                if (this.sortOrder === 'asc') {
                    return dateA - dateB;
                } else {
                    return dateB - dateA;
                }
            });
        }
    },
    methods: {
        async fetchOperation() {
            const response = await fetch('/transactions');
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
