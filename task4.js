const form = document.getElementById("expense-form");
const list = document.getElementById("expense-list");
const totalDisplay = document.getElementById("total-display");
const totalAmount = document.getElementById("total");
const toggleButton = document.getElementById("toggle-total");

let expenses = JSON.parse(localStorage.getItem("expenses")) || [];

function saveExpenses() {
  localStorage.setItem("expenses", JSON.stringify(expenses));
}

function renderExpenses() {
  list.innerHTML = "";
  let total = 0;

  expenses.forEach((item, index) => {
    total += Number(item.amount);
    const li = document.createElement("li");
    li.innerHTML = `
      ${item.description} - $${item.amount} (${item.category}) on ${item.date}
      <span class="actions">
        <button onclick="editExpense(${index})">Edit</button>
        <button onclick="deleteExpense(${index})">Delete</button>
      </span>
    `;
    list.appendChild(li);
  });

  totalAmount.textContent = total;
}

form.addEventListener("submit", function (e) {
  e.preventDefault();

  const description = document.getElementById("description").value;
  const amount = document.getElementById("amount").value;
  const category = document.getElementById("category").value;
  const date = document.getElementById("date").value;

  expenses.push({ description, amount, category, date });
  saveExpenses();
  renderExpenses();
  form.reset();
});

function deleteExpense(index) {
  expenses.splice(index, 1);
  saveExpenses();
  renderExpenses();
}

function editExpense(index) {
  const item = expenses[index];
  document.getElementById("description").value = item.description;
  document.getElementById("amount").value = item.amount;
  document.getElementById("category").value = item.category;
  document.getElementById("date").value = item.date;
  deleteExpense(index);
}

toggleButton.addEventListener("click", () => {
  const isVisible = totalDisplay.style.display === "block";
  totalDisplay.style.display = isVisible ? "none" : "block";
  toggleButton.textContent = isVisible ? "Show Total" : "Hide Total";
});

renderExpenses();
