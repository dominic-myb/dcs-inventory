document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("search-bar").addEventListener("keyup", async function () {
    const query = this.value;

    const response = await fetch(`./backend/search.php?q=${query}`);
    const data = await response.json();

    const result = document.getElementById("table-body");
    result.innerHTML = "";

    if (data.length === 0) {
      document.getElementById("search-result").style.display = "none";
      result.innerHTML = `
          <tr scope="row">
            <td colspan="6">0 Item Listed!</td>
          </tr>`;
    } else {
      document.getElementById("search-result").style.display = "block";
      data.forEach((item) => {
        result.innerHTML += `
            <tr scope="row">
              <td>${item.item_name}</td>
              <td>${item.quantity}</td>
              <td>${item.location}</td>
              <td>${item.description}</td>
              <td>${item.status}</td>
              <td>
                <a href="update.php?update_id=${item.id}" class="btn btn-primary">Update</a>
                <a href="delete.php?delete_id=${item.id}" class="btn btn-danger">Delete</a>
              </td>
            </tr>
            `;
      });
    }
  });
});
