document.addEventListener("DOMContentLoaded", () => {
  fetchSummary();
  fetchTopProducts();
  fetchMonthlySales();
  fetchLowStock();
});

// 1. Fetch Summary Data
function fetchSummary() {
  fetch('php/get_summary.php')
    .then(res => res.json())
    .then(data => {
      document.getElementById("totalProducts").textContent = data.total_products;
      document.getElementById("totalSales").textContent = data.total_sales;
      document.getElementById("totalRevenue").textContent = `$${data.total_revenue}`;
      document.getElementById("lowStockCount").textContent = data.low_stock_count;
    });
}

// 2. Top Selling Products (Bar Chart)
function fetchTopProducts() {
  fetch('php/get_top_products.php')
    .then(res => res.json())
    .then(data => {
      const ctx = document.getElementById('topProductsChart').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: data.map(d => d.product_name),
          datasets: [{
            label: 'Units Sold',
            data: data.map(d => d.total_sold),
            backgroundColor: 'rgba(54, 162, 235, 0.7)'
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { display: false }
          }
        }
      });
    });
}

// 3. Monthly Sales Trend (Line Chart)
function fetchMonthlySales() {
  fetch('php/get_monthly_sales.php')
    .then(res => res.json())
    .then(data => {
      const ctx = document.getElementById('monthlySalesChart').getContext('2d');
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: data.map(d => d.month),
          datasets: [{
            label: 'Revenue ($)',
            data: data.map(d => d.total_revenue),
            fill: false,
            borderColor: 'rgba(75, 192, 192, 1)',
            tension: 0.3
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { position: 'top' }
          }
        }
      });
    });
}

// 4. Low Stock Table
function fetchLowStock() {
  fetch('php/get_low_stock.php')
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById("lowStockTable");
      tbody.innerHTML = "";
      data.forEach(item => {
        const row = `
          <tr>
            <td>${item.product_name}</td>
            <td>${item.quantity}</td>
            <td>${item.min_required}</td>
          </tr>
        `;
        tbody.innerHTML += row;
      });
    });
}
