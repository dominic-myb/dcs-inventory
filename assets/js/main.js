document.addEventListener("DOMContentLoaded", function () {
  /***** SEARCH BAR TYPING LISTENER *****/
  document.getElementById("searchBar").addEventListener("keyup", async function () {
    // GET THE QUERY VALUE PLUS THE TOKEN HASH
    const query = this.value;
    const token = document.getElementById("token").value;
    const formData = {
      q: query,
      token: token,
    };

    // SUBMIT QUERY
    try {
      const response = await fetch(`./backend/search.php`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "CSRF-Token": token,
        },
        body: JSON.stringify(formData),
      });

      const data = await response.json(); // GET RESPONSE FROM SERVER
      loadTableData(data); // LOAD/UPDATE THE TABLE DATA
    } catch (error) {
      console.log("Error: ", error);
    }
  });

  /***** ADDING ITEM *****/
  document.getElementById("addItemForm").addEventListener("submit", async (e) => {
    e.preventDefault();
    // SANITIZE FORM DATA
    const itemName = DOMPurify.sanitize(document.getElementById("itemName").value.trim());
    const quantity = DOMPurify.sanitize(document.getElementById("quantity").value.trim());
    const location = DOMPurify.sanitize(document.getElementById("location").value.trim());
    const description = DOMPurify.sanitize(document.getElementById("description").value.trim());
    const status = DOMPurify.sanitize(document.getElementById("status").value.trim());

    if (quantity < 0) {
      console.log("Quantity less than 0");
      return;
    }

    const formData = {
      item_name: itemName,
      quantity: quantity,
      location: location,
      description: description,
      status: status,
    };

    try {
      const response = await fetch(`./backend/add-item.php`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(formData),
      });

      // HIDES THE MODAL FORM AFTER SUBMIT
      const addItemModal = document.getElementById("add-item-modal");
      const modalInstance = bootstrap.Modal.getInstance(addItemModal) || new bootstrap.Modal(addItemModal);
      modalInstance.hide();

      const data = await response.json();
      if (data.status === "success") {
        popupSystemMessage("System Message", data.message);

        try {
          const response = await fetch(`./backend/get-item.php`);
          const data = await response.json();
          loadTableData(data);
        } catch (error) {
          console.log("Error: ", error);
        }
      } else {
        popupSystemMessage("System Message", data.message);
      }
    } catch (error) {
      console.log(error.message);
    }
  });

  /***** GET/SHOW ITEMS FUNCTION *****/
  function loadTableData(data) {
    const tbody = document.getElementById("tableBody");
    tbody.innerHTML = "";

    if (data.length === 0) {
      result.innerHTML = `
          <tr scope="row">
            <td colspan="6">0 Item Listed!</td>
          </tr>
          `;
    } else {
      data.forEach((item) => {
        tbody.innerHTML += `
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

  /***** TIMED MODAL MESSAGE SHOW *****/
  function popupSystemMessage(title, message) {
    const modalElement = document.getElementById("popupMsg");
    const titleId = document.getElementById("popupTitle");
    const modalBody = document.getElementById("popupMsgContent");

    titleId.textContent = title;
    modalBody.textContent = message;

    const modalInstance = new bootstrap.Modal(modalElement);
    modalInstance.show();

    setTimeout(() => {
      modalInstance.hide();
    }, 3000);
  }
});
