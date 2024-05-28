<template>
    <div class="container">
        <h1>Stock Data</h1>
        <div v-if="error" class="alert alert-danger">{{ error }}</div>
        <table v-if="stocks.length" class="table table-responsive">
            <thead>
            <tr>
                <th>Exchange Name</th>
                <th>Symbol</th>
                <th>Current Price</th>
                <th>Previous Close</th>
                <th>Price Change</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="stock in stocks" :key="stock.symbol">
                <td>{{ stock.fullExchangeName }}</td>
                <td>{{ stock.symbol }}</td>
                <td>{{ stock.latestClose }}</td>
                <td>{{ stock.previousClose }}</td>
                <td :class="{'price-up': parseFloat(stock.priceChange) >= 0, 'price-down': parseFloat(stock.priceChange) < 0}">
                    {{ parseFloat(stock.priceChange) >= 0 ? '+' : '' }}{{ stock.priceChange }}
                </td>
            </tr>
            </tbody>
        </table>
        <div v-else>
            <p>No stock data available</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            stocks: [],
            error: null,
        };
    },
    mounted() {
        this.fetchStockData();
        setInterval(this.fetchStockData, 60000); // Refresh every minute
    },
    methods: {
        fetchStockData() {
            axios.get('/api/stocks')
                .then(response => {
                    this.stocks = response.data;
                })
                .catch(error => {
                    this.error = 'Unable to fetch stock data at this time. Please try again later.';
                    console.error(error);
                });
        },
    },
};
</script>

<style>
.price-up { color: green; }
.price-down { color: red; }
</style>
