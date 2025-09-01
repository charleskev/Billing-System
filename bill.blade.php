<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Electricity Bill</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 min-h-screen flex items-center justify-center">

  <div class="bg-white/90 backdrop-blur-md shadow-2xl rounded-2xl p-8 w-full max-w-lg">
    <h1 class="text-3xl font-extrabold text-indigo-700 text-center mb-6">⚡ Electricity Bill System</h1>
    
    <div id="customer-info" class="mt-6 space-y-3 text-gray-800 text-lg font-medium text-center"></div>

    <div id="bill-summary" class="mt-6 hidden bg-gray-50 border border-gray-200 rounded-xl p-4 shadow-inner text-center">
      <h2 class="text-xl font-bold text-gray-700 mb-2">Bill Summary</h2>
      <p id="base-bill" class="text-indigo-600 font-semibold"></p>
      <p id="total-bill" class="text-green-600 font-bold text-2xl"></p>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", async () => {
      const urlParams = new URLSearchParams(window.location.search);
      const customer_name = urlParams.get('customer_name') || '';
      const customer_type = urlParams.get('customer_type') || '';
      const consumption_kwh = urlParams.get('consumption_kwh') || '';

      const query = new URLSearchParams({
        ...(customer_name && { customer_name }),
        ...(customer_type && { customer_type }),
        ...(consumption_kwh && { consumption_kwh })
      }).toString();

  const billUrl = '/bill' + (query ? ?${query} : '');

      try {
        const response = await fetch(billUrl);
        const data = await response.json();

        if (data.status === 'success') {
          const customerInfo = `
            <p><strong class="text-indigo-600">Customer Name:</strong> ${data.customer_name || ''}</p>
            <p><strong class="text-indigo-600">Type:</strong> ${data.customer_type || ''}</p>
            <p><strong class="text-indigo-600">Consumption:</strong> ${data.consumption_kwh || ''} kWh</p>
          `;
          document.getElementById('customer-info').innerHTML = customerInfo;

          document.getElementById('base-bill').innerText = "Base Bill: ₱" + (data.base_bill || 0);
          document.getElementById('total-bill').innerText = "Total Bill: ₱" + (data.total_bill || 0);
          document.getElementById('bill-summary').classList.remove('hidden');

          setTimeout(() => {
            const message =
              '⚡ Base Bill: ₱' + (data.base_bill || 0) + '\n' +
              '💰 Total Bill: ₱' + (data.total_bill || 0);
            alert(message);
          }, 10);

        } else {
          document.getElementById('customer-info').innerHTML =
            <p class="text-red-600 font-semibold">Error: ${data.error}</p>;
          setTimeout(() => { alert("Error: " + data.error); }, 10);
        }
      } catch (error) {
        document.getElementById('customer-info').innerHTML =
          <p class="text-red-600 font-semibold">⚠ Failed to load bill data. Check connection or backend.</p>;
        alert("Failed to load bill data. Check connection or backend.");
      }
    });
  </script>
</body>
</html>
