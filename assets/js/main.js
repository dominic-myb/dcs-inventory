document.addEventListener("DOMContentLoaded", function () {
  /***** SEARCH BAR TYPING LISTENER *****/
  document.getElementById("searchBar").addEventListener("keyup", async function () {
    const query = this.value;
    const token = document.getElementById("token").value;
    const formData = {
      q: query,
      token: token,
    };
    const response = await fetch(`./backend/search.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "CSRF-Token": token,
      },
      body: JSON.stringify(formData),
    });
    const data = await response.json();

    updateTable(data);
  });

  /***** START OF TABLE UPDATE *****/
  function updateTable(data) {
    const result = document.getElementById("tableBody");
    const searchResult = document.getElementById("searchResult");
    result.innerHTML = "";

    if (data.length === 0) {
      searchResult.style.display = "none";
      result.innerHTML = `
          <tr scope="row">
            <td colspan="6">0 Item Listed!</td>
          </tr>`;
    } else {
      searchResult.style.display = "block";
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
  }
});
